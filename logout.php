<?php
session_start();

// Check if the session is still active
if (isset($_SESSION['user_id'])) {
    // Destroy the session to log out
    session_destroy();

    // Redirect user to login page (or any post-logout destination)
    header('Location: login.php');
    exit();
} else {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}
?>
