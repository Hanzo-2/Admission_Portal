<?php
session_start();

if (!isset($_SESSION['google_id'])) {
    echo json_encode(['authenticated' => false]);
} else {
    echo json_encode(['authenticated' => true]);
}
?>