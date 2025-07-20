<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

// Build the base query
$sql = "SELECT * FROM products WHERE 1=1";

// Add search condition if search term exists
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($con, $_GET['search']);
    $sql .= " AND (
        id LIKE '%$search_term%' OR 
        name LIKE '%$search_term%' OR 
        category LIKE '%$search_term%' OR 
        description LIKE '%$search_term%'
    )";
}

// Add sorting
$sql .= " ORDER BY id DESC";

// Execute query
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Products</title>
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
        
        .price-cell {
            font-weight: bold;
            color: #e97140;
            background: #fff5f0;
            border-radius: 4px;
            padding: 0.25rem 0.5rem;
        }
        
        .img-thumbnail {
            max-width: 80px;
            height: auto;
            border-radius: 8px;
            border: 2px solid #e97140;
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
        
        .btn-primary.mb-4 {
            border-radius: 8px;
            margin-bottom: 1.5rem !important;
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
        
        .add-product-btn {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(233, 113, 64, 0.2);
            margin-bottom: 1.5rem;
        }
        
        .add-product-btn:hover {
            background: linear-gradient(135deg, #d6612d 0%, #ea580c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(233, 113, 64, 0.3);
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'?>
        <?php include 'nav.php';?>
        
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="page-heading">
                <div class="d-flex align-items-center">
                    <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 40px; margin-right: 1rem; filter: brightness(0) invert(1);">
                    <h1>Products Management</h1>
                </div>
                <div>
                    <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">
                        <?php echo date('l, F j, Y'); ?>
                    </span>
                </div>
            </div>
            
            <a href="addproduct.php" class="btn btn-primary add-product-btn">
                <i class="fas fa-plus-circle"></i> Add New Product
            </a>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Product List</h6>
                    <form method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control custom-search-box" 
                                   placeholder="Search products by name, category, or description..." 
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
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $id = htmlspecialchars($row['id']);
                                    $name = htmlspecialchars($row['name']);
                                    $price = '$' . number_format($row['price'], 2);
                                    $category = htmlspecialchars($row['category']);
                                    $stock = htmlspecialchars($row['stock_quantity']);
                                    $image = htmlspecialchars($row['image']);
                                    
                                    $imagePath = 'product_images/' . $image;
                                    if (!file_exists($imagePath)) {
                                        $imagePath = 'product_images/default.png';
                                    }
                                    
                                    $stock_status = $row['stock_quantity'] > 0 ? 
                                        '<span class="badge badge-success">In Stock</span>' : 
                                        '<span class="badge badge-danger">Out of Stock</span>';
                                    
                                    echo "<tr>
                                            <td>{$id}</td>
                                            <td><img src='{$imagePath}' class='img-thumbnail' alt='{$name}'></td>
                                            <td>{$name}</td>
                                            <td class='price-cell'>{$price}</td>
                                            <td><span class='badge badge-info'>{$category}</span></td>
                                            <td>{$stock}</td>
                                            <td>{$stock_status}</td>
                                            <td>
                                                <div class='btn-group' role='group'>
                                                    <a href='editproduct.php?id={$id}' class='btn btn-sm btn-primary' title='Edit'>
                                                        <i class='fas fa-edit'></i>
                                                    </a>
                                                    <a href='deleteproduct.php?id={$id}' class='btn btn-sm btn-danger delete-btn' title='Delete' onclick='return confirm(\"Are you sure you want to delete this product?\")'>
                                                        <i class='fas fa-trash-alt'></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total Products:</th>
                                    <th colspan="5"><?php echo mysqli_num_rows($query); ?></th>
                                </tr>
                            </tfoot>
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
                    "order": [[0, "desc"]],
                    "columnDefs": [
                        { "orderable": false, "targets": [1, 7] } // Disable sorting on image and actions columns
                    ],
                    "dom": '<"top"f>rt<"bottom"lip><"clear">', // Custom layout
                    "language": {
                        "search": "", // Remove default "Search:" label
                        "searchPlaceholder": "Search products..." // Custom placeholder
                    }
                });
            }
            
            // Style the DataTables search box to match our custom search
            $('.dataTables_filter').hide(); // Hide the DataTables search since we have our own
        });
    </script>
</body>
</html>