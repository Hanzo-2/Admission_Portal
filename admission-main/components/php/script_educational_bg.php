<?php
include '../components/php/header.php';

if (isset($_SESSION['google_id'])) {
    echo "Session is active for user ID: " . $_SESSION['google_id'];
} else {
    echo "Session not active.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['lrn_num'] = $_POST['lrn_num'] ?? '';
    $_SESSION['school_type'] = $_POST['school_type'] ?? '';
    $_SESSION['student_type'] = $_POST['student_type'] ?? '';
    $_SESSION['school_name'] = $_POST['school_name'] ?? '';
    $_SESSION['school_address'] = $_POST['school_address'] ?? '';
    $_SESSION['track_strand'] = $_POST['track_strand'] ?? '';
    $_SESSION['year_graduation'] = $_POST['year_graduation'] ?? '';
    $_SESSION['shs_average'] = $_POST['shs_average'] ?? '';

    $requiredFields = [
      'lrn_num',
      'school_type',
      'student_type',
      'school_name',
      'school_address',
      'track_strand',
      'year_graduation',
      'shs_average'
    ];

    $allFilled = true;
    foreach ($requiredFields as $field) {
        if (empty($_SESSION[$field])) {
            $allFilled = false;
            break;
        }
    }

    if ($allFilled) {
        header('Location: http://localhost/admission_portal/admission-main/pages/family_info.php'); // Next page
        exit();
    } else {
        $error = "Please fill out all required fields.";
    }
}
?>