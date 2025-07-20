<?php
session_start();
include 'admin_login_check.php';
include 'connection.php';

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = $_GET['id'];
$order_query = mysqli_query($con, "SELECT * FROM orders WHERE id = $order_id");
$order = mysqli_fetch_assoc($order_query);

if (!$order) {
    header("Location: orders.php");
    exit();
}

// Update order status
if (isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($con, $_POST['status']);
    $update_query = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Order status updated successfully!'); window.location.href='view_order.php?id=$order_id';</script>";
    } else {
        echo "<script>alert('Error updating order status!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update Order #<?php echo $order_id; ?></title>
    <?php include 'headlink.php'?>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'?>
        <?php include 'nav.php';?>
        
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Update Order Status</h1>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order #<?php echo $order_id; ?></h6>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Current Status</label>
                            <p class="form-control-static">
                                <span class="badge badge-<?php 
                                    switch($order['status']) {
                                        case 'Pending': echo 'warning'; break;
                                        case 'Processing': echo 'info'; break;
                                        case 'Completed': echo 'success'; break;
                                        case 'Cancelled': echo 'danger'; break;
                                        case 'Shipped': echo 'primary'; break;
                                        default: echo 'secondary';
                                    }
                                ?>">
                                    <?php echo $order['status']; ?>
                                </span>
                            </p>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Update Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Pending" <?php echo ($order['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?php echo ($order['status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                <option value="Shipped" <?php echo ($order['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Completed" <?php echo ($order['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                <option value="Cancelled" <?php echo ($order['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                        
                        <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                        <a href="view_order.php?id=<?php echo $order_id; ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footerlink.php'?>
</body>
</html>