<?php
session_start();

$uploadDir = __DIR__ . '/../../uploads-req-docs/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$basePath = 'uploads-req-docs/';
$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
$maxFileSize = 1 * 1024 * 1024; // 1MB

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $googleId = $_SESSION['google_id'] ?? 'unknown';

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
