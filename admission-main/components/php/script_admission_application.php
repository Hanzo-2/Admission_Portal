<?php
if (isset($_SESSION['formsubmitted']) && $_SESSION['formsubmitted'] === true) {
    header("Location: application_num.php");
    exit();
}

// Disable page caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $google_oauth = new Google\Service\Oauth2($client);
        $user_info = $google_oauth->userinfo->get();

        // Set session
        $_SESSION['google_id'] = $user_info->id;
        $_SESSION['user'] = [
            'id' => $user_info->id,
            'email' => $user_info->email,
            'name' => $user_info->name,
            'profile_picture' => $user_info->picture
        ];

        $googleId = $_SESSION['google_id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM applications WHERE google_id = ?");
            $stmt->execute([$googleId]);
            $application = $stmt->fetch();

            if ($application) {
                header("Location: ../pages/application_num.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            exit();
        }

        header("Location: http://localhost/admission_portal/admission-main/pages/admission_application.php");
        exit();
    } else {
        die("Authentication Error: " . htmlspecialchars($token['error']));
    }
}

// Handle form POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION['school_campus'] = $_POST['school_campus'] ?? '';
    $_SESSION['classification'] = $_POST['classification'] ?? '';
    $_SESSION['grade_level'] = $_POST['grade_level'] ?? '';
    $_SESSION['academic_year_term'] = $_POST['academic_year_term'] ?? '';
    $_SESSION['application_type'] = $_POST['application_type'] ?? '';
    $_SESSION['preferred_course'] = $_POST['preferred_course'] ?? '';
    $_SESSION['admission_submit'] = $_POST['admission_submit'] ?? '';

    if (!empty($_SESSION['application_type']) && !empty($_SESSION['preferred_course'])) {
        header('Location: personal_info.php');
        exit();
    } else {
        $error = "Please fill out all required fields.";
    }
}