<?php
// Define all required fields from the previous page (e.g., personal info)
$requiredPreviousFields = [
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

// Check if any required session data is missing
foreach ($requiredPreviousFields as $field) {
    if (empty($_SESSION[$field]) && $_SESSION[$field] !== '0') {
        header('Location: personal_info.php');
        exit();
    }
}

// Define sanitization helpers
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define all fields to sanitize
    $allFields = [
        'lrn_num',
        'school_type',
        'student_type',
        'school_name',
        'school_address',
        'track_strand',
        'year_graduation',
        'shs_average'
    ];

    // Sanitize and store all inputs in session
    foreach ($allFields as $field) {
        $value = $_POST[$field] ?? '';

        $_SESSION[$field] = sanitizeInput($value);
    }

    // Required fields for validation
    $requiredFields = $allFields;

    $allFilled = true;
    foreach ($requiredFields as $field) {
        $value = $_SESSION[$field] ?? '';
        if (trim($value) === '' && $value !== '0') {
            $allFilled = false;
            break;
        }
    }

    if ($allFilled) {
        header('Location: family_info.php'); // Next page
        exit();
    } else {
        $error = "Please fill out all required fields.";
    }
}
