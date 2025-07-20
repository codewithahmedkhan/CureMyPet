<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

// Handle search functionality
$search_term = '';
$where_clause = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($con, $_GET['search']);
    $where_clause = " WHERE name LIKE '%$search_term%' 
                      OR email LIKE '%$search_term%' 
                      OR contact LIKE '%$search_term%'";
}

$query = "SELECT id, name, email, password, contact FROM user" . $where_clause;
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Management</title>

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
        
        .password-cell {
            font-style: italic;
            color: #6c757d;
            background: #f8fafc;
            border-radius: 4px;
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        
        /* Hide DataTables default search */
        .dataTables_filter {
            display: none;
        }
        
        .custom-search-container {
            margin-bottom: 2rem;
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
                    <h1>User Management</h1>
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
                               placeholder="Search users by name, email, or contact..." 
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
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="password-cell">Encrypted</td>
                                    <td><?php echo htmlspecialchars($row['contact']); ?></td>
                                    <td class="action-icons">
                                        <a href="userupdate.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-sm btn-primary" title="Update">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="userdelete.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-sm btn-danger" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this user?')">
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
                        { "orderable": false, "targets": [5] } // Disable sorting on actions column
                    ],
                    "dom": '<"top"f>rt<"bottom"lip><"clear">', // Custom layout
                    "language": {
                        "search": "", // Remove default "Search:" label
                        "searchPlaceholder": "Search users..." // Custom placeholder
                    }
                });
            }
            
            // Hide DataTables default search since we have our own
            $('.dataTables_filter').hide();
        });
    </script>

</body>
</html>