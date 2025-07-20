<?php
include 'connection.php';

$id = $_GET['id'];

$query = "DELETE FROM form WHERE id = $id";

if (mysqli_query($con, $query)) {
    echo "Appointment deleted.";
    echo "<script>alert('Appointment Deleted Successfully!'); window.location.href='index.php';</script>"; // Replace with actual page name
    exit;
} else {
    echo "Error deleting: " . mysqli_error($con);
}
?>