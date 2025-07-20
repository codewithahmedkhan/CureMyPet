<?php
session_start();
include "connection.php";

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = (int)$_GET['order_id'];

// Use prepared statement for security
$stmt = mysqli_prepare($con, "SELECT * FROM orders WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    header("Location: index.php");
    exit();
}

// Get order items if table exists
$order_items = [];
$check_table = mysqli_query($con, "SHOW TABLES LIKE 'order_items'");
if (mysqli_num_rows($check_table) > 0) {
    $items_stmt = mysqli_prepare($con, "
        SELECT oi.*, p.name as product_name, p.image as product_image 
        FROM order_items oi 
        LEFT JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id = ?
    ");
    mysqli_stmt_bind_param($items_stmt, "i", $order_id);
    mysqli_stmt_execute($items_stmt);
    $items_result = mysqli_stmt_get_result($items_stmt);
    
    while ($item = mysqli_fetch_assoc($items_result)) {
        $order_items[] = $item;
    }
}
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Order Confirmation - CureMyPet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'?>
    <style>
        :root {
            --primary-orange: #e97140;
            --success-green: #10b981;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
        }

        body {
            background-color: var(--gray-50);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--success-green) 0%, #059669 100%);
            color: white;
            padding: 80px 0 60px;
            margin-top: 80px;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: white;
        }

        .hero-content p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 0;
            color: white;
        }

        .success-section {
            padding: 50px 0;
        }

        .success-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .success-header {
            background: linear-gradient(135deg, var(--success-green) 0%, #059669 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
        }

        .success-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .success-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .order-details {
            padding: 40px;
        }

        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .info-item {
            background: var(--gray-50);
            padding: 20px;
            border-radius: 15px;
            border-left: 4px solid var(--primary-orange);
        }

        .info-label {
            font-size: 0.9rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 1.1rem;
            color: var(--gray-800);
            font-weight: 600;
        }

        .order-items-section {
            margin-top: 40px;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .items-list {
            background: var(--gray-50);
            border-radius: 15px;
            padding: 25px;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 5px;
        }

        .item-quantity {
            color: var(--gray-500);
            font-size: 0.9rem;
        }

        .item-price {
            font-weight: 700;
            color: var(--primary-orange);
            font-size: 1.1rem;
        }

        .total-section {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-top: 25px;
            text-align: center;
        }

        .total-amount {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .total-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        .actions-section {
            text-align: center;
            margin-top: 40px;
        }

        .btn-modern {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin: 0 10px;
        }

        .btn-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(233, 113, 64, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: var(--gray-600);
        }

        .btn-secondary:hover {
            background: var(--gray-700);
            box-shadow: 0 10px 25px rgba(107, 114, 128, 0.4);
        }

        .timeline {
            margin-top: 30px;
            padding: 25px;
            background: var(--gray-50);
            border-radius: 15px;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--success-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-title {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 2px;
        }

        .timeline-time {
            color: var(--gray-500);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .order-details {
                padding: 25px;
            }

            .order-info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .actions-section .btn-modern {
                display: block;
                margin: 10px 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'?>
    
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-content text-center">
                            <h1>Order Confirmed!</h1>
                            <p>Your order has been successfully placed</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Success Section -->
        <section class="success-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="success-card">
                            <div class="success-header">
                                <div class="success-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <h2 class="success-title">Thank You for Your Order!</h2>
                                <p class="success-subtitle">We've received your order and will process it shortly</p>
                            </div>
                            
                            <div class="order-details">
                                <div class="order-info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Order Number</div>
                                        <div class="info-value">#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Order Date</div>
                                        <div class="info-value"><?= date('F j, Y', strtotime($order['order_date'])) ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Payment Method</div>
                                        <div class="info-value"><?= htmlspecialchars($order['payment_method']) ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Status</div>
                                        <div class="info-value"><?= htmlspecialchars(ucfirst($order['status'])) ?></div>
                                    </div>
                                </div>

                                <div class="order-info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Customer Name</div>
                                        <div class="info-value"><?= htmlspecialchars($order['customer_name']) ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Email</div>
                                        <div class="info-value"><?= htmlspecialchars($order['customer_email']) ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Phone</div>
                                        <div class="info-value"><?= htmlspecialchars($order['customer_phone']) ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Delivery Address</div>
                                        <div class="info-value"><?= nl2br(htmlspecialchars($order['customer_address'])) ?></div>
                                    </div>
                                </div>

                                <?php if (!empty($order_items)): ?>
                                <div class="order-items-section">
                                    <h3 class="section-title">
                                        <i class="fas fa-shopping-bag"></i>
                                        Order Items
                                    </h3>
                                    
                                    <div class="items-list">
                                        <?php foreach ($order_items as $item): ?>
                                        <div class="order-item">
                                            <?php if (!empty($item['product_image'])): ?>
                                                <img src="dashboard/product_images/<?= htmlspecialchars($item['product_image']) ?>" 
                                                     alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                                     class="item-image">
                                            <?php else: ?>
                                                <div class="item-image" style="background: var(--gray-200); display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-image" style="color: var(--gray-500);"></i>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="item-details">
                                                <div class="item-name"><?= htmlspecialchars($item['product_name'] ?: 'Product') ?></div>
                                                <div class="item-quantity">Quantity: <?= $item['quantity'] ?></div>
                                            </div>
                                            
                                            <div class="item-price">
                                                AED <?= number_format($item['price'] * $item['quantity'], 2) ?>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="total-section">
                                    <div class="total-amount">AED <?= number_format($order['total_amount'], 2) ?></div>
                                    <div class="total-label">Total Amount</div>
                                </div>

                                <div class="timeline">
                                    <h3 class="section-title">
                                        <i class="fas fa-clock"></i>
                                        Order Timeline
                                    </h3>
                                    
                                    <div class="timeline-item">
                                        <div class="timeline-icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Order Confirmed</div>
                                            <div class="timeline-time"><?= date('F j, Y \a\t g:i A', strtotime($order['order_date'])) ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="timeline-item">
                                        <div class="timeline-icon" style="background: var(--gray-300); color: var(--gray-600);">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Preparing Order</div>
                                            <div class="timeline-time">Processing within 24 hours</div>
                                        </div>
                                    </div>
                                    
                                    <div class="timeline-item">
                                        <div class="timeline-icon" style="background: var(--gray-300); color: var(--gray-600);">
                                            <i class="fas fa-truck"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Out for Delivery</div>
                                            <div class="timeline-time">Expected within 2-3 business days</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="actions-section">
                            <a href="products.php" class="btn-modern">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                            <a href="contact.php" class="btn-modern btn-secondary">
                                <i class="fas fa-headset me-2"></i>Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <?php include 'footer.php'?>
    <?php include 'footerlink.php'?>
</body>
</html>