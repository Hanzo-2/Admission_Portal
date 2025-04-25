<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION['google_id'], $_SESSION['uploaded_docs'][$_SESSION['google_id']]) 
    && is_array($_SESSION['uploaded_docs'][$_SESSION['google_id']])) {

    foreach ($_SESSION['uploaded_docs'][$_SESSION['google_id']] as $doc) {
        if (isset($doc['server_path']) && file_exists($doc['server_path'])) {
                unlink($doc['server_path']); // Delete the file
            }
        }
    }


    $preserve_keys = ['google_id', 'user']; // whatever keys you want to keep
    $preserved = [];
    
    foreach ($preserve_keys as $key) {
        if (isset($_SESSION[$key])) {
            $preserved[$key] = $_SESSION[$key];
        }
    }
    
    // Clear all session data
    session_unset(); // or: $_SESSION = [];
    
    // Restore preserved keys
    foreach ($preserved as $key => $value) {
        $_SESSION[$key] = $value;
    }

    if (isset($_SESSION['google_id'])) {
        header("Location: review_info.php");
        exit();
    } 

}