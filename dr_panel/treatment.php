<?php
session_start();
include 'dr_login_check.php';
include 'connection.php';

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

// Get logged-in doctor ID and name from session
$logged_doctor_id = $_SESSION['dr_id'];
$dr_query = mysqli_query($con, "SELECT drname FROM doctor WHERE id = '$logged_doctor_id'");
$dr_data = mysqli_fetch_assoc($dr_query);
$loggedInDoctorName = $dr_data['drname'];

// Fetch only records that belong to the logged-in doctor
$records = mysqli_query($con, "SELECT * FROM record WHERE drname = '$loggedInDoctorName' ORDER BY id DESC");

// Get treatment statistics for the logged-in doctor
$total_treatments = mysqli_num_rows($records);

// Fetch services for lookup
$serviceLookup = [];
$services = mysqli_query($con, "SELECT id, servicename FROM services");
while ($s = mysqli_fetch_assoc($services)) {
    $serviceLookup[$s['id']] = $s['servicename'];
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

    <title>Doctor Panel - Treatment Records</title>

   <?php include 'headlink.php'?>
   <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #fff5f0 100%);
        }
        
        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(233, 113, 64, 0.1);
            color: white;
        }
        
        .page-heading h1 {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(233, 113, 64, 0.2);
            margin-bottom: 1.5rem;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #d6612d 0%, #ea580c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(233, 113, 64, 0.3);
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: white;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
            border: none;
        }
        
        .table {
            font-size: 0.875rem;
        }
        
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
            color: #4b5563;
            border-top: 1px solid #e5e7eb;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: #f9fafb;
        }
        
        /* Sidebar navigation hover effects */
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            margin: 0 0.5rem;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
       <?php include 'sidebar.php'?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <?php include "nav.php"?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="page-heading">
                        <div class="d-flex align-items-center">
                            <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 40px; margin-right: 1rem; filter: brightness(0) invert(1);">
                            <h1>Treatment Records</h1>
                        </div>
                        <div>
                            <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">
                                <?php echo date('l, F j, Y'); ?>
                            </span>
                        </div>
                    </div>
                    
                    <a href="addrecord.php" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add New Treatment
                    </a>
                 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                  
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered">
                            <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Doctor Name</th>
            <th>Service</th>
            <th>Record</th>
            <th>Bill</th>
            <th>Prescription</th>
            <th>Location</th>
            <th>Contact</th>
            <th>Pet Detail</th>
            <th>User Email</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($records)) : ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['username']; ?></td>
            <td><?= $row['drname']; ?></td>
            <td>
                <?= isset($serviceLookup[$row['servicesname']]) ? $serviceLookup[$row['servicesname']] : 'Unknown'; ?>
            </td>
            <td><?= $row['record']; ?></td>
            <td><?= $row['bill']; ?></td>
            <td><?= $row['prescription']; ?></td>
            <td><?= $row['location']; ?></td>
            <td><?= $row['contact']; ?></td>
            <td><?= $row['petdetail']; ?></td>
            <td><?= $row['useremail']; ?></td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CureMyPet 2025</span>
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

    <!-- Bootstrap core JavaScript-->
   <?php include 'footerlink.php'?>

</body>

</html>