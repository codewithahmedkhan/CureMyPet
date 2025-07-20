<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to login page or homepage
echo "<script>window.location.href='login.php';</script>";
exit();
?>