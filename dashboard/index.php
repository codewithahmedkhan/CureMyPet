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
    $where_clause = " WHERE f.petdetail LIKE '%$search_term%' 
                      OR f.location LIKE '%$search_term%'
                      OR f.contact LIKE '%$search_term%'
                      OR f.message LIKE '%$search_term%'
                      OR f.useremail LIKE '%$search_term%'
                      OR f.uername LIKE '%$search_term%'
                      OR d.drname LIKE '%$search_term%'
                      OR s.servicename LIKE '%$search_term%'";
}

// Fetch form submissions with joins for doctor and service names
$formDataQuery = "SELECT f.*, d.drname, s.servicename 
                 FROM form f
                 LEFT JOIN doctor d ON f.drname = d.id
                 LEFT JOIN services s ON f.servicesname = s.id" 
                 . $where_clause . " ORDER BY f.id DESC";
$formDataResult = mysqli_query($con, $formDataQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Appointment Management</title>

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
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card.primary { border-left-color: #e97140; background: linear-gradient(135deg, #fff 0%, #fff5f0 100%); }
        .stat-card.success { border-left-color: #e97140; background: linear-gradient(135deg, #fff 0%, #f0fff4 100%); }
        .stat-card.warning { border-left-color: #e97140; background: linear-gradient(135deg, #fff 0%, #fffbeb 100%); }
        .stat-card.danger { border-left-color: #e97140; background: linear-gradient(135deg, #fff 0%, #fef2f2 100%); }
        
        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: #111827;
        }
        
        .stat-card p {
            margin: 0;
            color: #6b7280;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 2px solid #f3f4f6;
            padding: 1.5rem;
            border-radius: 12px 12px 0 0;
        }
        
        .card-header h6 {
            margin: 0;
            font-weight: 700;
            color: #111827;
        }
        
        .table {
            font-size: 0.875rem;
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
            background: #3b82f6;
        }
        
        .btn-danger.btn-sm {
            background: #ef4444;
        }
        
        /* Limit width for certain columns */
        .limit-width {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Hide DataTables elements */
        .dataTables_length, .dataTables_filter {
            display: none;
        }
        
        /* Custom scrollbar */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 4px;
        }
        
        .table-responsive::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
        
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Enhanced UI Improvements */
        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #e97140, #f97316);
        }

        .stat-card h3 {
            background: linear-gradient(135deg, #e97140, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-header {
            background: linear-gradient(135deg, #fff 0%, #fff5f0 100%);
            border-bottom: 2px solid #e97140;
        }

        .card-header h6 {
            color: #e97140;
            font-weight: 700;
        }

        /* Custom button styles */
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
        <?php include 'nav.php';?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="page-heading">
                <div class="d-flex align-items-center">
                    <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 50px; margin-right: 1rem; filter: brightness(0) invert(1);">
                    <h1>Appointment Management</h1>
                </div>
                <div>
                    <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">
                        <?php echo date('l, F j, Y'); ?>
                    </span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-cards">
                <?php
                // Get statistics
                $total_appointments = mysqli_num_rows(mysqli_query($con, "SELECT id FROM form"));
                $today_appointments = mysqli_num_rows(mysqli_query($con, "SELECT id FROM form WHERE DATE(created_at) = CURDATE()"));
                $total_users = mysqli_num_rows(mysqli_query($con, "SELECT id FROM user"));
                $total_products = mysqli_num_rows(mysqli_query($con, "SELECT id FROM products"));
                ?>
                
                <div class="stat-card primary">
                    <h3><?= $total_appointments ?></h3>
                    <p>Total Appointments</p>
                </div>
                
                <div class="stat-card success">
                    <h3><?= $today_appointments ?></h3>
                    <p>Today's Appointments</p>
                </div>
                
                <div class="stat-card warning">
                    <h3><?= $total_users ?></h3>
                    <p>Registered Users</p>
                </div>
                
                <div class="stat-card danger">
                    <h3><?= $total_products ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
            
            <!-- Search Form -->
            <div class="custom-search-container">
                <form method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control custom-search-box" 
                               placeholder="Search appointments..." 
                               value="<?php echo htmlspecialchars($search_term); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Search
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
                                    <th>Doctor</th>
                                    <th>Service</th>
                                    <th>Pet Details</th>
                                    <th>Location</th>
                                    <th>Contact</th>
                                    <th class="limit-width">Message</th>
                                    <th>User Email</th>
                                    <th>Username</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($formDataResult)) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']); ?></td>
                                    <td><?= htmlspecialchars($row['drname'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($row['servicename'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($row['petdetail']); ?></td>
                                    <td><?= htmlspecialchars($row['location']); ?></td>
                                    <td><?= htmlspecialchars($row['contact']); ?></td>
                                    <td class="limit-width"><?= htmlspecialchars($row['message']); ?></td>
                                    <td><?= htmlspecialchars($row['useremail']); ?></td>
                                    <td><?= htmlspecialchars($row['uername']); ?></td>
                                    <td class="action-icons">
                                        <a href="appointmentupdate.php?id=<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-primary" title="Update">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="appointmentdelete.php?id=<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-danger" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this appointment?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
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
                        { "orderable": false, "targets": [9] } // Disable sorting on actions column
                    ],
                    "scrollX": true, // Enable horizontal scrolling
                    "dom": '<"top"i>rt<"bottom"lp><"clear">' // Layout without search box
                });
            }
        });
    </script>

</body>
</html>