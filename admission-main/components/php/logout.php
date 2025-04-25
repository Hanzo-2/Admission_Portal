<?php
session_start();
// Delete all uploaded files in session
if (isset($_SESSION['google_id'], $_SESSION['uploaded_docs'][$_SESSION['google_id']]) 
    && is_array($_SESSION['uploaded_docs'][$_SESSION['google_id']])) {
    
    foreach ($_SESSION['uploaded_docs'][$_SESSION['google_id']] as $doc) {
        if (isset($doc['server_path']) && file_exists($doc['server_path'])) {
            unlink($doc['server_path']); // Delete the file
        }
    }
}
session_unset();
session_destroy();
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Location: ../../index.php');
exit();
