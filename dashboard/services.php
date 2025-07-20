<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

// Handle search functionality
$search_term = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($con, $_GET['search']);
    $query = "SELECT * FROM services WHERE 
              servicename LIKE '%$search_term%' OR 
              servicedesc LIKE '%$search_term%'";
} else {
    $query = "SELECT * FROM services";
}
$qu = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Services Management</title>

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
        
        .btn-primary.mb-3 {
            border-radius: 8px;
            margin-bottom: 1.5rem !important;
        }
        
        .service-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: white;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(233, 113, 64, 0.15);
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
        
        .card-header h5 {
            color: #e97140;
            font-weight: 700;
            margin: 0;
        }
        
        .card-body {
            padding: 1.5rem;
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
        
        .custom-search-container {
            margin-bottom: 2rem;
        }
        
        .add-service-btn {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(233, 113, 64, 0.2);
            margin-bottom: 1.5rem;
        }
        
        .add-service-btn:hover {
            background: linear-gradient(135deg, #d6612d 0%, #ea580c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(233, 113, 64, 0.3);
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
                    <h1>Services Management</h1>
                </div>
                <div>
                    <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">
                        <?php echo date('l, F j, Y'); ?>
                    </span>
                </div>
            </div>
            
            <a href="addservice.php" class="btn btn-primary add-service-btn">
                <i class="fas fa-plus-circle"></i> Add New Service
            </a>

            <!-- Search Form -->
            <div class="custom-search-container">
                <form method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control custom-search-box" 
                               placeholder="Search services by name or description..." 
                               value="<?php echo htmlspecialchars($search_term); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <!-- Services Cards -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="container mt-4">
                        <div class="row row-cols-1 row-cols-md-3 g-4 align-items-stretch text-center">
                            <?php while ($res = mysqli_fetch_array($qu)) { ?>
                            <div class="col">
                                <div class="card shadow-sm h-100 d-flex flex-column service-card">
                                    <img src="./service_image/<?php echo htmlspecialchars($res['img']); ?>" 
                                         class="card-img-top img-fluid rounded" 
                                         style="height: 150px; object-fit: cover;" 
                                         alt="Service Image">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <strong><?php echo htmlspecialchars($res['servicename']); ?></strong>
                                        </h5>
                                        <p class="card-text">
                                            <?php echo htmlspecialchars($res['servicedesc']); ?>
                                        </p>
                                        <div class="mt-auto">
                                            <a href="delete_service.php?id=<?php echo $res['id']; ?>" 
                                               onclick="return confirm('Are you sure you want to delete this service?');"
                                               class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                            <a href="update_service.php?id=<?php echo $res['id']; ?>" 
                                               class="btn btn-sm btn-primary ml-2">
                                                <i class="fas fa-edit"></i> Update
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


    <?php include 'footerlink.php'?>

</body>
</html>