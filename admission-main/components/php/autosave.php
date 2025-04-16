<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field = $_POST['field'] ?? null;
    $value = $_POST['value'] ?? null;
    if ($field && in_array($field, ['application_type', 'preferred_course'])) {
        $_SESSION[$field] = $value;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid field']);
    }
}
?>
