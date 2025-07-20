<?php
session_start();
include 'admin_login_check.php';
include "connection.php";

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

// Handle search functionality
$search_term = '';
$where_clause = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($con, $_GET['search']);
    $where_clause = " WHERE username LIKE '%$search_term%' 
                      OR drname LIKE '%$search_term%'
                      OR record LIKE '%$search_term%'
                      OR bill LIKE '%$search_term%'
                      OR prescription LIKE '%$search_term%'
                      OR location LIKE '%$search_term%'
                      OR contact LIKE '%$search_term%'
                      OR petdetail LIKE '%$search_term%'
                      OR useremail LIKE '%$search_term%'";
}

// Fetch records with search condition
$records = mysqli_query($con, "SELECT * FROM record" . $where_clause);

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

    <title>Records Management</title>

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
        
        .custom-search-container {
            margin-bottom: 2rem;
        }
        
        .custom-search-box {
            width: 400px;
            border: 2px solid #e5e7eb;
            border-radius: 8px 0 0 8px;
            padding: 10px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .custom-search-box:focus {
            outline: none;
            border-color: #e97140;
            box-shadow: 0 0 0 3px rgba(233, 113, 64, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            border-radius: 0 8px 8px 0;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(233, 113, 64, 0.2);
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
        
        .thead-dark th {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
        }
        
        .table {
            font-size: 0.875rem;
        }
        
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
            color: #4b5563;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: #f9fafb;
        }
        
        .action-icons {
            white-space: nowrap;
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 6px;
            margin: 0 2px;
        }
        
        .btn-primary.btn-sm {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            box-shadow: 0 2px 4px rgba(233, 113, 64, 0.2);
        }
        
        .btn-primary.btn-sm:hover {
            background: linear-gradient(135deg, #d6612d 0%, #ea580c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(233, 113, 64, 0.3);
        }
        
        .btn-danger.btn-sm {
            background: #ef4444;
        }
        
        /* Make table more compact */
        .compact-table td, .compact-table th {
            padding: 0.5rem;
        }
        
        /* Limit width for certain columns */
        .limit-width {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Style DataTables elements */
        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin-bottom: 15px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0.5em;
            width: 250px;
        }
        
        .dataTables_wrapper .dataTables_length {
            float: left;
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
        <?php include 'nav.php';?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="page-heading">
                <div class="d-flex align-items-center">
                    <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 40px; margin-right: 1rem; filter: brightness(0) invert(1);">
                    <h1>Records Management</h1>
                </div>
                <div>
                    <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">
                        <?php echo date('l, F j, Y'); ?>
                    </span>
                </div>
            </div>
            
            <!-- Search Form -->
            <div class="custom-search-container">
                <form method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control custom-search-box" 
                               placeholder="Search records by username, doctor, service, or location..." 
                               value="<?php echo htmlspecialchars($search_term); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered compact-table" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Doctor</th>
                                    <th>Service</th>
                                    <th class="limit-width">Record</th>
                                    <th>Bill</th>
                                    <th class="limit-width">Prescription</th>
                                    <th>Location</th>
                                    <th>Contact</th>
                                    <th class="limit-width">Pet Detail</th>
                                    <th class="limit-width">Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($records)) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']); ?></td>
                                    <td><?= htmlspecialchars($row['username']); ?></td>
                                    <td><?= htmlspecialchars($row['drname']); ?></td>
                                    <td>
                                        <?= isset($serviceLookup[$row['servicesname']]) ? 
                                            htmlspecialchars($serviceLookup[$row['servicesname']]) : 'Unknown'; ?>
                                    </td>
                                    <td class="limit-width"><?= htmlspecialchars($row['record']); ?></td>
                                    <td><?= htmlspecialchars($row['bill']); ?></td>
                                    <td class="limit-width"><?= htmlspecialchars($row['prescription']); ?></td>
                                    <td><?= htmlspecialchars($row['location']); ?></td>
                                    <td><?= htmlspecialchars($row['contact']); ?></td>
                                    <td class="limit-width"><?= htmlspecialchars($row['petdetail']); ?></td>
                                    <td class="limit-width"><?= htmlspecialchars($row['useremail']); ?></td>
                                    <td class="action-icons">
                                        <a href="doctorrecordupdate.php?id=<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-primary" title="Update">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="doctorrecorddelete.php?id=<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-danger" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
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

    <?php include 'footerlink.php'?>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable only if not already initialized
            if (!$.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable({
                    "order": [[0, "desc"]], // Sort by ID descending by default
                    "columnDefs": [
                        { "orderable": false, "targets": [11] }, // Disable sorting on actions column
                        { "width": "5%", "targets": [0, 11] }, // Set column widths
                        { "width": "10%", "targets": [1, 2, 3, 5, 7, 8] }
                    ],
                    "scrollX": true // Enable horizontal scrolling
                });
            }
        });
    </script>

</body>
</html>