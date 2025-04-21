<?php
include '../components/php/header.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['personal_firstname'] = $_POST['personal_firstname'] ?? '';
    $_SESSION['personal_middlename'] = $_POST['personal_middlename'] ?? '';
    $_SESSION['personal_surname'] = $_POST['personal_surname'] ?? '';
    $_SESSION['personal_birthdate'] = $_POST['personal_birthdate'] ?? '';
    $_SESSION['birthplace'] = $_POST['birthplace'] ?? '';
    $_SESSION['sex'] = $_POST['sex'] ?? '';
    $_SESSION['civilstatus'] = $_POST['civilstatus'] ?? '';
    $_SESSION['nationality'] = $_POST['nationality'] ?? '';
    $_SESSION['religion'] = $_POST['religion'] ?? '';
    $_SESSION['address'] = $_POST['address'] ?? '';
    $_SESSION['selected_province'] = $_POST['selected_province'] ?? '';
    $_SESSION['selected_city'] = $_POST['selected_city'] ?? '';
    $_SESSION['selected_barangay'] = $_POST['selected_barangay'] ?? '';
    $_SESSION['personal_contact'] = $_POST['personal_contact'] ?? '';
    $_SESSION['personal_email'] = $_POST['personal_email'] ?? '';
    $_SESSION['telephone'] = $_POST['telephone'] ?? '';

    $phoneDigits = preg_replace('/\D/', '', $_SESSION['personal_contact']);
    $telDigits = preg_replace('/\D/', '', $_SESSION['telephone']);

    $isPhoneValid = strlen($phoneDigits) === 11;
    $isTelValid = strlen($telDigits) === 9 || $_SESSION['telephone'] === ''; // Allow blank but not invalid

    if (!$isPhoneValid) {
        $_SESSION['personal_contact'] = '';
    }

    if (!$isTelValid) {
        $_SESSION['telephone'] = '';
    }

    $requiredFields = [
      'personal_firstname',
      'personal_surname',
      'personal_birthdate',
      'birthplace',
      'sex',
      'civilstatus',
      'nationality',
      'religion',
      'address',
      'selected_province',
      'selected_city',
      'selected_barangay',
      'personal_contact'
    ];

    $allFilled = true;
    foreach ($requiredFields as $field) {
        if (empty($_SESSION[$field])) {
            $allFilled = false;
            break;
        }
    }

    if ($allFilled) {
        header('Location: http://localhost/admission_portal/admission-main/pages/educational_bg.php'); // Next page
        exit();
    } else {
        $error = "Please fill out all required fields.";
    }
}
?>