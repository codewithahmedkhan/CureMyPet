<?php
include "connection.php";

if (isset($_POST['query'])) {
    $search = mysqli_real_escape_string($con, $_POST['query']);
    $query = mysqli_query($con, "SELECT * FROM products WHERE name LIKE '%$search%' LIMIT 5");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo '
            <div style="display:flex; align-items:center; gap:15px; padding:10px; margin-bottom:10px; border:1px solid #ccc; border-radius:5px;">
                <img src="dashboard/product_images/' . $row['image'] . '" style="width:60px; height:60px; object-fit:cover; border-radius:5px;">
                <div>
                    <a href="product_details.php?id=' . $row['id'] . '" style="color:#000; font-weight:bold; text-decoration:none;">' . $row['name'] . '</a><br>
                    <small style="color:#333;">' . number_format($row['price'], 2) . ' AED</small>
                </div>
            </div>';
        }
    } else {
        echo "<p style='color:#000;'>No products found.</p>";
    }
}
?>
