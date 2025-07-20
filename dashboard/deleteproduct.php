<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // First get the image name to delete it from server
    $query = "SELECT image FROM products WHERE id = $id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $image = $row['image'];
    
    // Delete the product
    $deleteQuery = "DELETE FROM products WHERE id = $id";
    
    if (mysqli_query($con, $deleteQuery)) {
        // Delete the image file
        if (file_exists("product_images/" . $image)) {
            unlink("product_images/" . $image);
        }
        echo "<script>alert('Product deleted successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Error deleting product!'); window.location.href='products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='products.php';</script>";
}
?>