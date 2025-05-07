<?php
require_once __DIR__ . '/../php/db.php';

// Assume the Google ID is stored in the session after login
$googleId = $_SESSION['google_id'] ?? null;

$applicantEmail = 'Not available';
$dateSubmitted = 'Not available';
$timeSubmitted = 'Not available';
$admissionNumber = 'Not available';

if ($googleId !== null) {
    $hashedGoogleId = hash('sha256', $googleId);
    try {
        // Query to check if an application already exists for this Google ID
        $stmt = $pdo->prepare("SELECT email, date_submitted, time_submitted, admission_number 
                               FROM applications 
                               WHERE google_id = ?");
        $stmt->execute([$hashedGoogleId]);

        $result = $stmt->fetch();

        if ($result) {
            // Application found, display details
            $applicantEmail = $result['email'];
            $dateSubmitted = date('F j, Y', strtotime($result['date_submitted']));
            $timeSubmitted = date('h:i A', strtotime($result['time_submitted']));
            $admissionNumber = str_pad($result['admission_number'], 5, '0', STR_PAD_LEFT);
        } else {
            // No application found
            $admissionNumber = 'No application found';
            $applicantEmail = 'Not available';
            $dateSubmitted = 'Not available';
            $timeSubmitted = 'Not available';
        }
    } catch (PDOException $e) {
        // Error handling
        $admissionNumber = 'Error retrieving application';
        $applicantEmail = 'Not available';
        $dateSubmitted = 'Not available';
        $timeSubmitted = 'Not available';
    }
}