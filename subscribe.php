<?php
include 'connection.php'; // Include your DB connection

if (isset($_POST['subscribe'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address'); window.history.back();</script>";
        exit;
    }

    // Check if already subscribed
    $check = mysqli_query($con, "SELECT * FROM subscribers WHERE email='$email'");
    
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('You are already subscribed!'); window.history.back();</script>";
    } else {
        $insert = mysqli_query($con, "INSERT INTO subscribers (email) VALUES ('$email')");
        
        if ($insert) {
            echo "<script>alert('Thank you for subscribing!'); window.history.back();</script>";
        } else {
            echo "<script>alert('Something went wrong. Try again later.'); window.history.back();</script>";
        }
    }
}
?>