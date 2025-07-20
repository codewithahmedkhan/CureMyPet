<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

$id = $_GET['id'];

$delete = "DELETE FROM record WHERE id = $id";

if (mysqli_query($con, $delete)) {
    echo "<script>alert('Record has been Deleted!'); window.location.href='doctorrecord.php';</script>"; // Replace with your actual view page
    exit;
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
?>