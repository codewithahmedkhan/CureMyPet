<?php
session_start();
include 'connection.php'; // Ensure this file contains a valid database connection

// Check if admin is logged in
if (!isset($_SESSION['adminloginsuccessfull'])) {
    echo "<script>alert('You are not logged In'); window.location.href='LOGIN.PHP';</script>";
    exit();
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

    <title>SB Admin 2 - Tables</title>

   <?php include 'headlink.php'?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
       <?php include 'sidebar.php'?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <?php include 'nav.php';?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                   <a href="addservice.php">Add Service</a>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>


                        <div class="container mt-5">
    <h2>Appointment Update</h2>
    <?php

$id = $_GET['id'];
$query = mysqli_query($con, "SELECT * FROM form WHERE id = $id");
$data = mysqli_fetch_assoc($query);

// Fetch doctors and services for dropdowns
$doctors = mysqli_query($con, "SELECT id, drname FROM doctor");
$services = mysqli_query($con, "SELECT id, servicename FROM services");

if (isset($_POST['update'])) {
    $drname = $_POST['drname'];
    $servicesname = $_POST['servicesname'];
    $petdetail = $_POST['petdetail'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];
    $message = $_POST['message'];
    $useremail = $_POST['useremail'];
    $uername = $_POST['uername'];

    $updateQuery = "UPDATE form SET 
        drname = '$drname', 
        servicesname = '$servicesname', 
        petdetail = '$petdetail',
        location = '$location',
        contact = '$contact',
        message = '$message',
        useremail = '$useremail',
        uername = '$uername'
        WHERE id = $id";

    if (mysqli_query($con, $updateQuery)) {
        echo "Updated successfully.";
        echo "<script>alert('Appointment Updated Succesfully!'); window.location.href='index.php';</script>"; // redirect back to view
        exit;
    } else {
        echo "Update failed: " . mysqli_error($con);
    }
}
?>

<!-- Update form -->
<form method="POST">
            <div class="row g-3">
                <!-- Doctor -->
                <div class="col-md-6">
                    <label for="drname" class="form-label">Doctor</label>
                    <select name="drname" class="form-select" required>
                        <?php while ($dr = mysqli_fetch_assoc($doctors)) { ?>
                            <option value="<?= $dr['id']; ?>" <?= $dr['id'] == $data['drname'] ? 'selected' : ''; ?>>
                                <?= $dr['drname']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Service -->
                <div class="col-md-6">
                    <label for="servicesname" class="form-label">Service</label>
                    <select name="servicesname" class="form-select" required>
                        <?php while ($srv = mysqli_fetch_assoc($services)) { ?>
                            <option value="<?= $srv['id']; ?>" <?= $srv['id'] == $data['servicesname'] ? 'selected' : ''; ?>>
                                <?= $srv['servicename']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Pet Detail -->
                <div class="col-md-6">
                    <label class="form-label">Pet Detail</label>
                    <input type="text" name="petdetail" value="<?= $data['petdetail']; ?>" class="form-control" required>
                </div>

                <!-- Location -->
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="<?= $data['location']; ?>" class="form-control" required>
                </div>

                <!-- Contact -->
                <div class="col-md-6">
                    <label class="form-label">Contact</label>
                    <input type="text" name="contact" value="<?= $data['contact']; ?>" class="form-control" required>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label">User Email</label>
                    <input type="email" name="useremail" value="<?= $data['useremail']; ?>" class="form-control" required>
                </div>

                <!-- Username -->
                <div class="col-md-6">
                    <label class="form-label">User Name</label>
                    <input type="text" name="uername" value="<?= $data['uername']; ?>" class="form-control" required>
                </div>

                <!-- Message -->
                <div class="col-md-12">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="3"><?= $data['message']; ?></textarea>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-end">
                    <button type="submit" name="update" class="btn btn-primary px-4">Update</button>
                </div>
            </div>
        </form>

</div>




            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
   <?php include 'footerlink.php'?>

</body>

</html>



</div>




            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
   <?php include 'footerlink.php'?>

</body>

</html>


