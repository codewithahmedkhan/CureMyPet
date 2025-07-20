<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM contact WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('User deleted successfully!'); window.location.href='contact.php';</script>";
    } else {
        echo "<script>alert('Failed to delete User!'); window.location.href='contact.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='contact.php';</script>";
}
?>