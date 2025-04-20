<?php
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

        $_SESSION['google_id'] = $user_info->id;
        $_SESSION['user'] = [
            'id' => $user_info->id,
            'email' => $user_info->email,
            'name' => $user_info->name,
            'profile_picture' => $user_info->picture
        ];

        header("Location: http://localhost/admission_portal/admission-main/pages/admission_application.php");
        exit();
    } else {
        die("Authentication Error: " . htmlspecialchars($token['error']));
    }
}

include '../components/php/header.php';

if (isset($_SESSION['google_id'])) {
    echo "Session is active for user ID: " . $_SESSION['google_id'];
} else {
    echo "Session not active.";
}

// Handle form POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION['school_campus'] = $_POST['school_campus'] ?? '';
    $_SESSION['classification'] = $_POST['classification'] ?? '';
    $_SESSION['grade_level'] = $_POST['grade_level'] ?? '';
    $_SESSION['academic_year_term'] = $_POST['academic_year_term'] ?? '';
    $_SESSION['application_type'] = $_POST['application_type'] ?? '';
    $_SESSION['preferred_course'] = $_POST['preferred_course'] ?? '';

    if (!empty($_SESSION['application_type']) && !empty($_SESSION['preferred_course'])) {
        header('Location: http://localhost/admission_portal/admission-main/pages/personal_info.php');
        exit();
    } else {
        $error = "Please fill out all required fields.";
    }
}
?>