<?php
session_start();

// Redirect if required previous session data is missing (from family_info.php)
$requiredPreviousFields = [
    'guardian_firstname',
    'guardian_surname',
    'guardian_address',
    'guardian_province',
    'guardian_city',
    'guardian_contact',
    'emergency_complete_name',
    'emergency_complete_address',
    'emergency_contact'
];

foreach ($requiredPreviousFields as $field) {
    if (empty($_SESSION[$field]) && $_SESSION[$field] !== '0') {
        header('Location: family_info.php');
        exit();
    }
}

// Define sanitization helpers
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Handle file upload and processing
$uploadDir = __DIR__ . '/../../uploads-req-docs/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$basePath = 'uploads-req-docs/';
$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
$maxFileSize = 1 * 1024 * 1024; // 1MB

header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $googleId = $_SESSION['google_id'] ?? 'unknown';

        // Sanitize POST data before processing
        if ($action === 'upload' && isset($_FILES)) {
            foreach ($_FILES as $key => $file) {
                $index = (int) str_replace('file_', '', $key);

                if ($file['error'] !== UPLOAD_ERR_OK) {
                    echo json_encode(['success' => false, 'error' => 'File upload error.']);
                    exit;
                }

                if (!in_array($file['type'], $allowedTypes)) {
                    echo json_encode(['success' => false, 'error' => 'Invalid file type.']);
                    exit;
                }

                if ($file['size'] > $maxFileSize) {
                    echo json_encode(['success' => false, 'error' => 'File must be under 1MB.']);
                    exit;
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $name = pathinfo($file['name'], PATHINFO_FILENAME);
                $newName = 'Document_' . $index . '_' . $googleId . '_' . $name . '.' . $ext;

                $uploadDirAbs = realpath(__DIR__ . '/../../uploads-req-docs');
                $uploadPath = $uploadDirAbs . '/' . $newName;
                $relativePath = '/admission_portal/admission-main/uploads-req-docs/' . $newName;

                if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    echo json_encode(['success' => false, 'error' => 'Failed to move file.']);
                    exit;
                }

                $_SESSION['uploaded_docs'][$googleId]['file_' . $index] = [
                    'name' => $file['name'],
                    'path' => $relativePath,
                    'server_path' => $uploadPath,
                    'status' => 'success'
                ];

                echo json_encode(['success' => true, 'path' => $relativePath]);
                exit;
            }

        } elseif ($action === 'remove' && isset($_POST['file_index'])) {
            $index = (int) $_POST['file_index'];
            $key = 'file_' . $index;

            if (isset($_SESSION['uploaded_docs'][$googleId][$key])) {
                $serverPath = $_SESSION['uploaded_docs'][$googleId][$key]['server_path'] ?? '';

                if ($serverPath && file_exists($serverPath)) {
                    unlink($serverPath);
                    unset($_SESSION['submitted']);
                }

                unset($_SESSION['uploaded_docs'][$googleId][$key]);
                echo json_encode(['success' => true]);
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => 'File not found in session.']);
                exit;
            }

        } elseif ($action === 'validate') {
            if (isset($_SESSION['uploaded_docs'][$googleId]['file_1'])) {
                echo json_encode(['success' => true]);
                $_SESSION['submitted'] = true;
            } else {
                echo json_encode(['success' => false, 'error' => 'Upload FORM 138 to continue']);
            }
            exit;
        } elseif ($action === 'fetch_uploaded_docs') {
            echo json_encode([
                'success' => true,
                'docs' => $_SESSION['uploaded_docs'][$googleId] ?? []
            ]);
            exit;
        }
    }
    // If no valid `action` was matched
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
    exit;
}
