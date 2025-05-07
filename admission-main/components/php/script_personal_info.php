<?php

// Redirect if critical session data is missing
if (empty($_SESSION['application_type']) && empty($_SESSION['preferred_course'])) {
    header('Location: admission_application.php');
    exit();
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
        'personal_firstname',
        'personal_middlename',
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
        'personal_contact',
        'personal_email',
        'telephone'
    ];

    // Define fields that should be capitalized (first letter only)
    $capitalizeFields = [
        'personal_firstname',
        'personal_middlename',
        'personal_surname',
        'birthplace',
        'nationality',
        'religion'
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

    // Check if all required fields are filled
    $allFilled = true;
    foreach ($requiredFields as $field) {
        if (empty($_SESSION[$field])) {
            $allFilled = false;
            break;
        }
    }

    // Optional: Validate email format
    if (!empty($_SESSION['personal_email']) && !filter_var($_SESSION['personal_email'], FILTER_VALIDATE_EMAIL)) {
        $allFilled = false;
        $error = "Please enter a valid email address.";
    }

    // Redirect or show error
    if ($allFilled) {
        header('Location: educational_bg.php');
        exit();
    } else {
        if (!isset($error)) {
            $error = "Please fill out all required fields.";
        }
    }
}