<?php
session_start();
// Delete all uploaded files in session
if (isset($_SESSION['uploaded_docs']) && is_array($_SESSION['uploaded_docs'])) {
    foreach ($_SESSION['uploaded_docs'] as $doc) {
        if (isset($doc['path']) && file_exists($doc['path'])) {
            unlink($doc['path']); // Delete the file
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
?>