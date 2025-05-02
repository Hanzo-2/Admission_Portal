<?php
session_start();

header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

if (isset($_SESSION['google_id'])) {
    $_SESSION['last_activity'] = time();
    echo json_encode(['status' => 'refreshed']);
} else {
    echo json_encode(['status' => 'no session']);
}