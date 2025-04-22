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

        if ($action === 'upload' && isset($_FILES)) {
            foreach ($_FILES as $key => $file) {
                $index = (int) str_replace('file_', '', $key);
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    echo json_encode(['success' => false, 'error' => 'File upload error.']);
                    exit;
                }

                $validTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                if (!in_array($file['type'], $validTypes)) {
                    echo json_encode(['success' => false, 'error' => 'Invalid file type.']);
                    exit;
                }

                if ($file['size'] > 1024 * 1024) {
                    echo json_encode(['success' => false, 'error' => 'File must be under 1MB.']);
                    exit;
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $name = pathinfo($file['name'], PATHINFO_FILENAME);
                $newName = 'Document_' . $index . '_' . $name . '.' . $ext;
                $uploadPath = '../../uploads-req-docs/' . $newName;
                $relativePath = '../uploads-req-docs/' . $newName;

                if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    echo json_encode(['success' => false, 'error' => 'Failed to move file.']);
                    exit;
                }

                $_SESSION['uploaded_docs']['file_' . $index] = [
                    'name' => $file['name'],
                    'path' => $uploadPath,
                    'status' => 'success'
                ];

                echo json_encode(['success' => true, 'path' => $relativePath]);
                exit;
            }

        } elseif ($action === 'remove' && isset($_POST['file_index'])) {
            $index = (int) $_POST['file_index'];
            $key = 'file_' . $index;
            if (isset($_SESSION['uploaded_docs'][$key])) {
                $path = $_SESSION['uploaded_docs'][$key]['path'];
                if (file_exists($path)) {
                    unlink($path);
                }
                unset($_SESSION['uploaded_docs'][$key]);
                echo json_encode(['success' => true]);
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => 'File not found in session.']);
                exit;
            }

        } elseif ($action === 'validate') {
            if (isset($_SESSION['uploaded_docs']['file_1'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'FORM 138 is required.']);
            }
            exit;
        }
    }
    // If no valid `action` was matched
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
    exit;
}