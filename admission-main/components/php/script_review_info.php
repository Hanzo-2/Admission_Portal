<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../../../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_SESSION['google_id'], $_SESSION['uploaded_docs'][$_SESSION['google_id']]) &&
        is_array($_SESSION['uploaded_docs'][$_SESSION['google_id']])
    ) {
        // Setup applicant info
        $applicantSurname = $_SESSION['personal_surname'] ?? '';
        $applicantFirstname = $_SESSION['personal_firstname'] ?? '';
        $applicantMiddlename = $_SESSION['personal_middlename'] ?? '';
        $applicantName = trim($applicantSurname . ', ' . $applicantFirstname . ' ' . $applicantMiddlename);
        $applicantName = !empty(trim($applicantName)) ? $applicantName : 'Not provided';
        $email = $_SESSION['user']['email'] ?? 'Not provided';
        $applicationType = $_SESSION['application_type'] ?? 'Not provided';
        $preferredCourse = $_SESSION['preferred_course'] ?? 'Not provided';

        // Set timezone to PHT
        date_default_timezone_set('Asia/Manila');
        $dateSubmitted = date('m-d-Y');
        $timeSubmitted = date('h:i:s A');

        // **Admission Number Generation**
        if (!isset($_SESSION['application_num'])) {
            $_SESSION['application_num'] = 1; // Initialize admission number if not set
        } else {
            $_SESSION['application_num']++; // Increment admission number
        }

        // Format admission number (e.g., 00001, 00002)
        $admissionNumber = str_pad($_SESSION['application_num'], 5, '0', STR_PAD_LEFT);

        // 1. Send email to registrar
        $mailRegistrar = new PHPMailer(true);
        try {
            $mailRegistrar->isSMTP();
            $mailRegistrar->Host       = $_ENV['MAIL_HOST'];
            $mailRegistrar->SMTPAuth   = true;
            $mailRegistrar->Username   = $_ENV['MAIL_USERNAME'];
            $mailRegistrar->Password   = $_ENV['MAIL_PASSWORD'];
            $mailRegistrar->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mailRegistrar->Port       = (int) $_ENV['MAIL_PORT'];

            $mailRegistrar->setFrom($_ENV['MAIL_FROM'], 'Admission Portal');
            $mailRegistrar->addAddress($_ENV['MAIL_TO']); // Registrar only

            $mailRegistrar->isHTML(true);
            $mailRegistrar->Subject = 'New Admission Submission from ' . $applicantName . ' - ' . date('d-m-Y h:i A');
            $mailRegistrar->Body = "
                Applicant Name: $applicantName<br>
                Email: $email<br>
                Application Type: $applicationType<br>
                Preferred Course: $preferredCourse<br>
                Date Submitted: $dateSubmitted<br>
                Time Submitted: $timeSubmitted<br>
                Admission Number: $admissionNumber
            ";

            // Attach uploaded documents
            foreach ($_SESSION['uploaded_docs'][$_SESSION['google_id']] as $index => $doc) {
                if (isset($doc['server_path']) && file_exists($doc['server_path'])) {
                    $customFilename = "Document_{$index}_" . basename($doc['name']);
                    $mailRegistrar->addAttachment($doc['server_path'], $customFilename);
                }
            }
            if (isset($_SESSION['review_pdf_path']) && file_exists($_SESSION['review_pdf_path'])) {
                $mailRegistrar->addAttachment($_SESSION['review_pdf_path'], 'Admission_Application_of_'.$applicantSurname.'_'.$applicantFirstname.'_'.$applicantMiddlename.'_.pdf');
            }
            $mailRegistrar->send();
            if (isset($_SESSION['review_pdf_path']) && file_exists($_SESSION['review_pdf_path'])) {
                unlink($_SESSION['review_pdf_path']);
                unset($_SESSION['review_pdf_path']);
            }
        } catch (Exception $e) {
            echo "Error sending to registrar: {$mailRegistrar->ErrorInfo}";
            exit;
        }

        // 2. Send confirmation to applicant (logged-in user)
        if (!empty($email)) {
            $mailUser = new PHPMailer(true);
            try {
                $mailUser->isSMTP();
                $mailUser->Host       = $_ENV['MAIL_HOST'];
                $mailUser->SMTPAuth   = true;
                $mailUser->Username   = $_ENV['MAIL_USERNAME'];
                $mailUser->Password   = $_ENV['MAIL_PASSWORD'];
                $mailUser->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mailUser->Port       = (int) $_ENV['MAIL_PORT'];

                $mailUser->setFrom($_ENV['MAIL_FROM'], 'SPIST Admissions');
                $mailUser->addAddress($email); // Logged-in user's email

                $mailUser->isHTML(true);
                $mailUser->Subject = 'Admission Application Submitted';
                $mailUser->Body = "
                    We've received your application — thank you! You'll be notified via email if there are any missing requirements or once your submission has been reviewed.<br><br>
                    <strong>Summary of Submitted Application:</strong><br>
                    Applicant Name: $applicantName<br> 
                    Email: $email<br>
                    Application Type: $applicationType<br>
                    Preferred Course: $preferredCourse<br>
                    Date Submitted: $dateSubmitted<br>
                    Time Submitted: $timeSubmitted<br>
                    Admission Number: $admissionNumber
                ";
                $mailUser->send();
            } catch (Exception $e) {
                echo "Error sending to applicant: {$mailUser->ErrorInfo}";
                exit;
            }
        }

        // Cleanup
        foreach ($_SESSION['uploaded_docs'][$_SESSION['google_id']] as $doc) {
            if (isset($doc['server_path']) && file_exists($doc['server_path'])) {
                unlink($doc['server_path']);
            }
        }

        $preserve_keys = ['google_id', 'user'];
        $preserved = [];
        foreach ($preserve_keys as $key) {
            if (isset($_SESSION[$key])) {
                $preserved[$key] = $_SESSION[$key];
            }
        }

        session_unset();
        foreach ($preserved as $key => $value) {
            $_SESSION[$key] = $value;
        }

        $_SESSION['date_submitted'] = $dateSubmitted;
        $_SESSION['time_submitted'] = $timeSubmitted;
        // Redirect to confirmation page with admission number
        header('Location: application_num.php');
        exit();
    }
}
