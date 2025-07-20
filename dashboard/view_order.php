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

// Get order items
$items_query = mysqli_query($con, "SELECT oi.*, p.name, p.image 
                                  FROM order_items oi 
                                  JOIN products p ON oi.product_id = p.id 
                                  WHERE oi.order_id = $order_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Order #<?php echo $order_id; ?></title>
    <?php include 'headlink.php'?>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'?>
        <?php include 'nav.php';?>
        
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Order Details</h1>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
                            <p><strong>Order Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></p>
                            <p><strong>Status:</strong> 
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
                            <p><strong>Payment Method:</strong> <?php echo $order['payment_method']; ?></p>
                            <p><strong>Total Amount: $</strong> <?php echo number_format($order['total_amount'], 2); ?></p>
                        </div>
                    </div>
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <?php echo $order['customer_name']; ?></p>
                            <p><strong>Email:</strong> <?php echo $order['customer_email']; ?></p>
                            <p><strong>Phone:</strong> <?php echo $order['customer_phone']; ?></p>
                            <p><strong>Address:</strong> 
                                <br><?php echo nl2br($order['customer_address']); ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        while ($item = mysqli_fetch_assoc($items_query)) {
                                            echo "<tr>
                                                    <td>
                                                        <img src='product_images/{$item['image']}' width='50' class='mr-2'>
                                                        {$item['name']}
                                                    </td>
                                                    <td>".number_format($item['price'], 2)."</td>
                                                    <td>{$item['quantity']}</td>
                                                    <td>$".number_format($item['price'] * $item['quantity'], 2)."</td>
                                                </tr>";
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">Subtotal:</th>
                                            <th>$<?php echo number_format($order['total_amount'], 2); ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">Shipping:</th>
                                            <th>0.00</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">Grand Total:</th>
                                            <th>$<?php echo number_format($order['total_amount'], 2); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
        </div>
    </div>
    <?php include 'footerlink.php'?>
</body>
</html>