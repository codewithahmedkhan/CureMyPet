<?php
session_start(); // Start session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to login page or index
header("Location: login.php");
exit();
?>