<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

if (isset($_POST['btn'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $category = trim($_POST['category']);
    $stock = (int)$_POST['stock'];
    
    // Basic validation
    if (empty($name) || empty($description) || $price <= 0 || empty($category) || $stock < 0) {
        $error = "Please fill all fields with valid data";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = "Please select an image file";
    } else {
        $image = $_FILES['image'];
        $tmpName = $image['tmp_name'];
        $originalName = basename($image['name']);
        
        // Generate safe filename
        $newFilename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\.\-]/', '_', $originalName);
        $uploadPath = 'product_images/' . $newFilename;
        
        if (move_uploaded_file($tmpName, $uploadPath)) {
            $stmt = $con->prepare("INSERT INTO products (name, description, price, image, category, stock_quantity) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssi", $name, $description, $price, $newFilename, $category, $stock);
            
            if ($stmt->execute()) {
                $success = "Product has been added successfully";
                // Clear form
                $_POST = array();
            } else {
                // Delete uploaded file if DB insert failed
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
                $error = "Error saving to database";
            }
            $stmt->close();
        } else {
            $error = "Error uploading file";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Product</title>
    <?php include 'headlink.php'?>
    <style>
        .error-message { color: #dc3545; }
        .success-message { color: #28a745; }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'?>
        <?php include 'nav.php';?>
        
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Add New Product</h1>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form class="user" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" placeholder="Product Name" 
                           name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <textarea class="form-control" cols="10" rows="5" placeholder="Product Description" 
                              name="description" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <input type="number" step="0.01" class="form-control form-control-user" placeholder="Price" 
                           name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required min="0.01">
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" placeholder="Category" 
                           name="category" value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <input type="number" class="form-control form-control-user" placeholder="Stock Quantity" 
                           name="stock" value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : '0'; ?>" required min="0">
                </div>
                
                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" class="form-control-file" name="image" id="image" required>
                </div>
                
                <input type="submit" class="btn btn-primary btn-user btn-block" name="btn" value="Add Product">
            </form>
        </div>
    </div>
    
    <?php include 'footerlink.php'?>
</body>
</html>