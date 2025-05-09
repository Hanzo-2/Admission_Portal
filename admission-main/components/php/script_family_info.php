<?php
// Redirect if required previous session data is missing (from educational background page)
$requiredPreviousFields = [
    'lrn_num',
    'school_type',
    'student_type',
    'school_name',
    'school_address',
    'track_strand',
    'year_graduation',
    'shs_average'
];

foreach ($requiredPreviousFields as $field) {
    if (empty($_SESSION[$field]) && $_SESSION[$field] !== '0') {
        header('Location: educational_bg.php');
        exit();
    }
}

// Define sanitization helpers
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function capitalizeFirstLetter($input) {
    return ucfirst(strtolower(trim($input)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define all fields to sanitize
    $allFields = [
        // Father
        'father_firstname',
        'father_middlename',
        'father_surname',
        'father_birthdate',
        'father_contact',

        // Mother
        'mother_firstname',
        'mother_middlename',
        'mother_surname',
        'mother_birthdate',
        'mother_contact',

        // Guardian
        'guardian_firstname',
        'guardian_middlename',
        'guardian_surname',
        'guardian_address',
        'guardian_province',
        'guardian_city',
        'guardian_barangay',
        'guardian_contact',
        'guardian_email',
        'guardian_telephone',

        // Emergency Contact
        'emergency_complete_name',
        'emergency_complete_name_select',
        'emergency_complete_address',
        'emergency_contact',
        'emergency_email',
        'emergency_telephone'
    ];

    // Define fields that should be capitalized
    $capitalizeFields = [
        'father_firstname', 'father_middlename', 'father_surname',
        'mother_firstname', 'mother_middlename', 'mother_surname',
        'guardian_firstname', 'guardian_middlename', 'guardian_surname',
        'emergency_complete_name'
    ];

    // Sanitize and store all inputs in session
    foreach ($allFields as $field) {
        $value = $_POST[$field] ?? '';
        if (in_array($field, $capitalizeFields)) {
            $value = capitalizeFirstLetter($value);
        }
        $_SESSION[$field] = sanitizeInput($value);
    }

    // Required fields for validation
    $requiredFields = [
        'guardian_firstname',
        'guardian_surname',
        'guardian_address',
        'guardian_province',
        'guardian_city',
        'guardian_barangay',
        'guardian_contact',
        'emergency_complete_name',
        'emergency_complete_address',
        'emergency_contact'
    ];

    $allFilled = true;
    foreach ($requiredFields as $field) {
        $value = $_SESSION[$field] ?? '';
        if (trim($value) === '' && $value !== '0') {
            $allFilled = false;
            break;
        }
    }

    if ($allFilled) {
        header('Location: required_docs.php'); // Next page
        exit();
    } else {
        $error = "Please fill out all required fields.";
    }
}
