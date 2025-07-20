<?php
if (!isset($_SESSION['dr_id'])) {
    echo "<script>alert('You are not logged In'); window.location.href='login.php';</script>";
    exit(); // Ensure script stops executing after redirection
}
?>