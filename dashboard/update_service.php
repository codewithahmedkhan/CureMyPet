<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['adminloginsuccessfull'])) {
    echo "<script>alert('You are not logged In'); window.location.href='LOGIN.PHP';</script>";
    exit();
}

include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM services WHERE id = $id";
    $result = mysqli_query($con, $query);
    $service = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $servicename = $_POST['servicename'];
    $servicedesc = $_POST['servicedesc'];
    $old_image = $service['img'];

    if ($_FILES['img']['name'] != '') {
        $image_name = time() . '_' . $_FILES['img']['name'];
        $target_directory = "service_image/";
        $target_file = $target_directory . $image_name;

        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
            if (file_exists($target_directory . $old_image)) {
                unlink($target_directory . $old_image);
            }
        } else {
            echo "<script>alert('Error uploading image');</script>";
            $image_name = $old_image;
        }
    } else {
        $image_name = $old_image;
    }

    $updateQuery = "UPDATE services SET servicename = '$servicename', servicedesc = '$servicedesc', img = '$image_name' WHERE id = $id";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Service updated successfully!'); window.location.href='services.php';</script>";
    } else {
        echo "<script>alert('Failed to update service!'); window.location.href='services.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Update Service</title>
    <?php include 'headlink.php'; ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'nav.php'; ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Update Service</h1>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Service Name:</label>
                            <input type="text" name="servicename" class="form-control" value="<?php echo $service['servicename']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Service Description:</label>
                            <textarea name="servicedesc" class="form-control" required><?php echo $service['servicedesc']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Current Image:</label><br>
                            <img src="service_image/<?php echo $service['img']; ?>" width="150" alt="Service Image">
                        </div>

                        <div class="form-group">
                            <label>Upload New Image:</label>
                            <input type="file" name="img" class="form-control">
                        </div>

                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="services.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

            <?php include 'footerlink.php'; ?>
        </div>
    </div>
</body>

</html>
