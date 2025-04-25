<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field = $_POST['field'] ?? null;
    $value = $_POST['value'] ?? null;
    $allowedFields = [
        'application_type', 'preferred_course',
        'personal_firstname', 'personal_middlename', 'personal_surname',
        'personal_birthdate', 'birthplace', 'sex', 'civilstatus',
        'nationality', 'religion', 'address',
        'selected_province', 'selected_city', 'selected_barangay',
        'personal_contact', 'personal_email', 'telephone', 'lrn_num', 'school_type',
        'student_type', 'school_name', 'school_address', 'track_strand', 'year_graduation',
        'shs_average', 'father_firstname', 'father_middlename', 'father_surname', 'father_birthdate',
        'father_contact', 'mother_firstname', 'mother_middlename', 'mother_surname', 'mother_birthdate',
        'mother_contact', 'guardian_firstname', 'guardian_middlename', 'guardian_surname',
        'guardian_address', 'guardian_province', 'guardian_city', 'guardian_barangay', 'guardian_contact', 'guardian_email',
        'guardian_telephone', 'emergency_complete_name', 'emergency_complete_name_select', 'emergency_complete_address', 'emergency_contact',
        'emergency_email', 'emergency_telephone'
    ];

    if ($field && in_array($field, $allowedFields)) {
        $_SESSION[$field] = $value;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid field']);
    }
}

