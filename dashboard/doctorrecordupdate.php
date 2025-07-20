<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

$id = $_GET['id'];
$recordQuery = mysqli_query($con, "SELECT * FROM record WHERE id = $id");
$data = mysqli_fetch_assoc($recordQuery);

// Fetch services
$services = mysqli_query($con, "SELECT id, servicename FROM services");

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $drname = $_POST['drname'];
    $servicesname = $_POST['servicesname'];
    $record = $_POST['record'];
    $bill = $_POST['bill'];
    $prescription = $_POST['prescription'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];
    $petdetail = $_POST['petdetail'];
    $useremail = $_POST['useremail'];

    $update = "UPDATE record SET 
        username='$username',
        drname='$drname',
        servicesname='$servicesname',
        record='$record',
        bill='$bill',
        prescription='$prescription',
        location='$location',
        contact='$contact',
        petdetail='$petdetail',
        useremail='$useremail'
        WHERE id = $id";

    if (mysqli_query($con, $update)) {
        echo "<script>alert('Reacord Updated successfully!'); window.location.href='doctorrecord.php';</script>";// Change to your read page
        exit;
    } else {
        echo "Update failed: " . mysqli_error($con);
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
    <h2>Record Update</h2>
    <form method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="<?= $data['username']; ?>" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Doctor Name</label>
                    <input type="text" name="drname" value="<?= $data['drname']; ?>" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Service</label>
                    <select name="servicesname" class="form-select" required>
                        <?php while ($s = mysqli_fetch_assoc($services)) { ?>
                            <option value="<?= $s['id']; ?>" <?= $s['id'] == $data['servicesname'] ? 'selected' : ''; ?>>
                                <?= $s['servicename']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Record</label>
                    <input type="text" name="record" value="<?= $data['record']; ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bill</label>
                    <input type="text" name="bill" value="<?= $data['bill']; ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Prescription</label>
                    <input type="text" name="prescription" value="<?= $data['prescription']; ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="<?= $data['location']; ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Contact</label>
                    <input type="text" name="contact" value="<?= $data['contact']; ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pet Detail</label>
                    <input type="text" name="petdetail" value="<?= $data['petdetail']; ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">User Email</label>
                    <input type="email" name="useremail" value="<?= $data['useremail']; ?>" class="form-control">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" name="update" class="btn btn-primary">Update Record</button>
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


