<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $old_image = $product['image'];

    // Handle image upload
    if ($_FILES['image']['name'] != '') {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $target = "product_images/" . $image_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Delete old image
            if (file_exists("product_images/" . $old_image)) {
                unlink("product_images/" . $old_image);
            }
        } else {
            $image_name = $old_image;
        }
    } else {
        $image_name = $old_image;
    }

    $updateQuery = "UPDATE products SET 
                    name = '$name', 
                    description = '$description', 
                    price = '$price', 
                    image = '$image_name', 
                    category = '$category', 
                    stock_quantity = '$stock' 
                    WHERE id = $id";
    
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Error updating product!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product</title>
    <?php include 'headlink.php'?>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'?>
        <?php include 'nav.php';?>
        
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Edit Product</h1>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $product['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" required><?php echo $product['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" class="form-control" name="category" value="<?php echo $product['category']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" class="form-control" name="stock" value="<?php echo $product['stock_quantity']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Current Image</label><br>
                    <img src="product_images/<?php echo $product['image']; ?>" width="100">
                </div>
                <div class="form-group">
                    <label>New Image (Leave blank to keep current)</label>
                    <input type="file" class="form-control" name="image">
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update Product</button>
                <a href="products.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
    <?php include 'footerlink.php'?>
</body>
</html>