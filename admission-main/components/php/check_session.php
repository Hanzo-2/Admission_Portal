<?php
$timeout_duration = 1800; // in seconds/30 minutes

// Set session parameters before session_start()
ini_set('session.gc_maxlifetime', $timeout_duration);
session_set_cookie_params([
    'lifetime' => $timeout_duration,
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

if (!isset($_SESSION['google_id'])) {
    echo json_encode(['authenticated' => false, 'timeout' => $timeout_duration]);
    exit;
}

if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time(); // Set once
}

$elapsed = time() - $_SESSION['last_activity'];

if ($elapsed > $timeout_duration) {
    session_unset();
    session_destroy();
    echo json_encode(['authenticated' => false, 'timeout' => $timeout_duration]);
    exit;
}

$remaining = $timeout_duration - $elapsed;
echo json_encode([
    'authenticated' => true,
    'remaining' => $remaining,
    'timeout' => $timeout_duration
]);
