<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

// Enable error reporting (helpful during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    // Handle image upload
    $image = $_FILES['image']['name'];
    $tmpImage = $_FILES['image']['tmp_name'];

    if (empty($name) || empty($description)) {
        $message = "Please fill in all fields.";
    } else {
        $imageName = '';

        if (!empty($image)) {
            $uploadDir = "service_image/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $imageName = time() . "_" . basename($image);
            $uploadPath = $uploadDir . $imageName;

            if (!move_uploaded_file($tmpImage, $uploadPath)) {
                $message = "Image upload failed.";
            }
        }

        // Use correct column names
        $stmt = $con->prepare("INSERT INTO services (servicename, servicedesc, img) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $imageName);

        if ($stmt->execute()) {
            echo "<script>alert('Service added successfully.'); window.location.href='services.php';</script>";
            exit;
        } else {
            $message = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Service | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'; ?>
</head>
<body id="page-top">

<div id="wrapper">
    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include 'nav.php'; ?>

            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">Add a Service</h1>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form class="user" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="name" placeholder="Enter Service Name" required>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="description" rows="5" placeholder="Enter Service Description" required></textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" class="form-control" name="image">
                    </div>

                    <input type="submit" name="btn" value="Add Service" class="btn btn-primary btn-user btn-block">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footerlink.php'; ?>
</body>
</html>
