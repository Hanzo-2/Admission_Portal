<?php
session_start();

// Get JSON from POST
$data = json_decode(file_get_contents('php://input'), true);

// Update session values
if ($data) {
    $_SESSION['emergency_complete_name_select'] = $data['emergency_complete_name_select'] ?? '';
    $_SESSION['emergency_complete_name'] = $data['emergency_complete_name'] ?? '';
    $_SESSION['emergency_complete_address'] = $data['emergency_complete_address'] ?? '';
    $_SESSION['emergency_contact'] = $data['emergency_contact'] ?? '';
    $_SESSION['emergency_email'] = $data['emergency_email'] ?? '';
    $_SESSION['emergency_telephone'] = $data['emergency_telephone'] ?? '';
}

http_response_code(200); // OK