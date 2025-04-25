<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['father_firstname'] = $_POST['father_firstname'] ?? '';
    $_SESSION['father_middlename'] = $_POST['father_middlename'] ?? '';
    $_SESSION['father_surname'] = $_POST['father_surname'] ?? '';
    $_SESSION['father_birthdate'] = $_POST['father_birthdate'] ?? '';
    $_SESSION['father_contact'] = $_POST['father_contact'] ?? '';
    
    $_SESSION['mother_firstname'] = $_POST['mother_firstname'] ?? '';
    $_SESSION['mother_middlename'] = $_POST['mother_middlename'] ?? '';
    $_SESSION['mother_surname'] = $_POST['mother_surname'] ?? '';
    $_SESSION['mother_birthdate'] = $_POST['mother_birthdate'] ?? '';
    $_SESSION['mother_contact'] = $_POST['mother_contact'] ?? '';
    
    $_SESSION['guardian_firstname'] = $_POST['guardian_firstname'] ?? '';
    $_SESSION['guardian_middlename'] = $_POST['guardian_middlename'] ?? '';
    $_SESSION['guardian_surname'] = $_POST['guardian_surname'] ?? '';
    $_SESSION['guardian_address'] = $_POST['guardian_address'] ?? '';
    $_SESSION['guardian_province'] = $_POST['guardian_province'] ?? '';
    $_SESSION['guardian_city'] = $_POST['guardian_city'] ?? '';
    $_SESSION['guardian_contact'] = $_POST['guardian_contact'] ?? '';
    $_SESSION['guardian_email'] = $_POST['guardian_email'] ?? '';
    $_SESSION['guardian_telephone'] = $_POST['guardian_telephone'] ?? '';
    $_SESSION['emergency_complete_name'] = $_POST['emergency_complete_name'] ?? '';
    $_SESSION['emergency_complete_name_select'] = $_POST['emergency_complete_name_select'] ?? '';
    $_SESSION['emergency_complete_address'] = $_POST['emergency_complete_address'] ?? '';
    $_SESSION['emergency_contact'] = $_POST['emergency_contact'] ?? '';
    $_SESSION['emergency_email'] = $_POST['emergency_email'] ?? '';
    $_SESSION['emergency_telephone'] = $_POST['emergency_telephone'] ?? '';

    $requiredFields = [
        'guardian_firstname',
        'guardian_surname',
        'guardian_address',
        'guardian_province',
        'guardian_city',
        'guardian_contact',
        'guardian_telephone',
        'emergency_complete_name',
        'emergency_complete_address',
        'emergency_contact'
    ];

    $allFilled = true;
    foreach ($requiredFields as $field) {
        if (empty($_SESSION[$field])) {
            $allFilled = false;
            break;
        }
    }

    if ($allFilled) {
        header('Location: http://localhost/admission_portal/admission-main/pages/required_docs.php'); // Next page
        exit();
    } else {
        $error = "Please fill out all required fields.";
    }
}
