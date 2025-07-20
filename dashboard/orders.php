<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

// Handle order deletion
if (isset($_GET['delete_id'])) {
    $order_id = intval($_GET['delete_id']);
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // First delete all order items
        mysqli_query($con, "DELETE FROM order_items WHERE order_id = $order_id");
        
        // Then delete the order
        mysqli_query($con, "DELETE FROM orders WHERE id = $order_id");
        
        // Commit transaction
        mysqli_commit($con);
        
        $_SESSION['success'] = "Order deleted successfully";
        header("Location: orders.php");
        exit();
    } catch (Exception $e) {
        // Rollback if error occurs
        mysqli_rollback($con);
        $_SESSION['error'] = "Error deleting order: " . mysqli_error($con);
        header("Location: orders.php");
        exit();
    }
}

// Build the base query
$sql = "SELECT * FROM orders WHERE 1=1";

// Add search condition if search term exists
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($con, $_GET['search']);
    $sql .= " AND (
        id LIKE '%$search_term%' OR 
        customer_name LIKE '%$search_term%' OR 
        customer_email LIKE '%$search_term%' OR 
        customer_phone LIKE '%$search_term%' OR 
        payment_method LIKE '%$search_term%' OR 
        status LIKE '%$search_term%'
    )";
}

// Add sorting
$sql .= " ORDER BY order_date DESC";

// Execute query
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Orders Management</title>
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
        
        .card-header {
            background: linear-gradient(135deg, #fff 0%, #fff5f0 100%);
            border-bottom: 2px solid #e97140;
            border-radius: 12px 12px 0 0;
            padding: 1rem;
        }
        
        .card-header h6 {
            color: #e97140;
            font-weight: 700;
            margin: 0;
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
        
        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #047857;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
        }
        
        /* Hide DataTables length menu and default search */
        .dataTables_length, .dataTables_filter {
            display: none;
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'?>
        <?php include 'nav.php';?>
        
        <div class="container-fluid">
            <!-- Success/Error Messages -->
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <!-- Page Heading -->
            <div class="page-heading">
                <div class="d-flex align-items-center">
                    <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 40px; margin-right: 1rem; filter: brightness(0) invert(1);">
                    <h1>Orders Management</h1>
                </div>
                <div>
                    <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">
                        <?php echo date('l, F j, Y'); ?>
                    </span>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">All Orders</h6>
                    <form method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control custom-search-box" 
                                   placeholder="Search orders by ID, customer, or payment method..." 
                                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($order = mysqli_fetch_assoc($query)) {
                                    echo "<tr>
                                            <td>#{$order['id']}</td>
                                            <td>{$order['customer_name']}<br>{$order['customer_email']}</td>
                                            <td>".date('M j, Y', strtotime($order['order_date']))."</td>
                                            <td>$ ".number_format($order['total_amount'], 2)."</td>
                                            <td>{$order['payment_method']}</td>
                                            <td>
                                                <span class='badge badge-".getStatusBadge($order['status'])."'>
                                                    {$order['status']}
                                                </span>
                                            </td>
                                            <td>
                                                <a href='view_order.php?id={$order['id']}' class='btn btn-info btn-sm'>View</a>
                                                <a href='update_order.php?id={$order['id']}' class='btn btn-primary btn-sm'>Update</a>
                                                <a href='orders.php?delete_id={$order['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this order?\");'>Delete</a>
                                            </td>
                                        </tr>";
                                }
                                
                                function getStatusBadge($status) {
                                    switch($status) {
                                        case 'Pending': return 'warning';
                                        case 'Processing': return 'info';
                                        case 'Completed': return 'success';
                                        case 'Cancelled': return 'danger';
                                        case 'Shipped': return 'primary';
                                        default: return 'secondary';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footerlink.php'?>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable only if not already initialized
            if (!$.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable({
                    "order": [[0, "desc"]], // Default sorting by order ID descending
                    "columnDefs": [
                        { "orderable": false, "targets": [6] } // Disable sorting on actions column
                    ],
                    "dom": '<"top"f>rt<"bottom"ip><"clear">', // Custom layout without length menu
                    "language": {
                        "search": "", // Remove default "Search:" label
                        "searchPlaceholder": "Search orders..." // Custom placeholder
                    }
                });
            }
            
            // Hide DataTables default search since we have our own
            $('.dataTables_filter').hide();
        });
    </script>
</body>
</html>