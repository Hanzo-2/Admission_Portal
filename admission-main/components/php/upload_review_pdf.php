<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $uploadDir = __DIR__ . '/../../uploads-req-docs/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $googleId = $_SESSION['google_id'] ?? 'guest';
    $filename = 'review_' . $googleId . '_' . time() . '.pdf';
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $targetPath)) {
        $_SESSION['review_pdf_path'] = $targetPath;
        echo "Success";
    } else {
        http_response_code(500);
        echo "Failed to move uploaded file.";
    }
}
