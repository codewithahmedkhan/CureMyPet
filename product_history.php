<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle deletion of a specific product from history
if (isset($_POST['delete_item']) && isset($_POST['order_id']) && isset($_POST['product_id'])) {
    $order_id = intval($_POST['order_id']);
    $product_id = intval($_POST['product_id']);

    // Delete the item
    $delete = "DELETE FROM order_items WHERE order_id = '$order_id' AND product_id = '$product_id' LIMIT 1";
    mysqli_query($con, $delete);

    // Optional: Delete order if no items remain
    $check = mysqli_query($con, "SELECT COUNT(*) as count FROM order_items WHERE order_id = '$order_id'");
    $row = mysqli_fetch_assoc($check);
    if ($row['count'] == 0) {
        mysqli_query($con, "DELETE FROM orders WHERE id = '$order_id'");
    }

    // Redirect to avoid form resubmission
    header("Location: product_history.php");
    exit();
}

// Fetch user purchase history
$query = "
    SELECT p.name AS product_name, p.image, p.price, oi.quantity, o.order_date, o.id AS order_id, p.id AS product_id
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = '$user_id'
    ORDER BY o.order_date DESC
";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | CureMyPet</title>
    <?php include 'headlink.php'; ?>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e5e7eb 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .history-container {
            padding: 120px 0 80px;
            min-height: 100vh;
        }

        .history-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .history-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .history-header h1 {
            font-size: 2.5rem;
            margin: 0 0 0.5rem;
            color: #1e293b;
            font-weight: 700;
        }

        .history-header p {
            margin: 0;
            color: #6b7280;
            font-size: 1.1rem;
        }

        .order-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #f97316;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .orders-list {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .orders-header h2 {
            font-size: 1.75rem;
            margin: 0;
            color: #1e293b;
            font-weight: 700;
        }

        .product-item {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .product-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .product_img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 12px;
            margin-right: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-content {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-info h5 {
            margin: 0 0 0.5rem;
            font-size: 1.25rem;
            color: #1e293b;
            font-weight: 600;
        }

        .product-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .product-date i {
            color: #f97316;
        }

        .product-meta {
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .quantity-badge {
            background: linear-gradient(135deg, #14b8a6 0%, #0891b2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-block;
        }

        .price-tag {
            font-size: 1.5rem;
            font-weight: 700;
            color: #f97316;
        }

        .total-amount {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .shop-button {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(249, 115, 22, 0.3);
        }

        .shop-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(249, 115, 22, 0.3);
            text-decoration: none;
            color: white;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            color: #f97316;
            transform: translateX(-5px);
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .history-container {
                padding: 100px 15px 60px;
            }

            .history-header h1 {
                font-size: 2rem;
            }

            .history-header p {
                font-size: 1rem;
            }

            .order-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .orders-list {
                padding: 1.5rem;
            }

            .orders-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .product-item {
                flex-direction: column;
                text-align: center;
                padding: 1.25rem;
            }

            .product_img {
                margin: 0 0 1rem 0;
                width: 120px;
                height: 120px;
            }

            .product-content {
                flex-direction: column;
                width: 100%;
            }

            .product-info {
                text-align: center;
                margin-bottom: 1rem;
            }

            .product-meta {
                text-align: center;
                width: 100%;
            }

            .quantity-badge {
                margin: 0 auto;
            }
        }

        @media (max-width: 480px) {
            .history-header h1 {
                font-size: 1.75rem;
            }

            .history-header {
                padding: 1.5rem;
            }

            .stat-number {
                font-size: 1.75rem;
            }

            .orders-list {
                padding: 1.25rem;
            }

            .product-item {
                padding: 1rem;
            }

            .product_img {
                width: 100px;
                height: 100px;
            }

            .product-info h5 {
                font-size: 1.125rem;
            }

            .price-tag {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="history-container">
    <div class="history-wrapper">
     

        <!-- History Header -->
        <div class="history-header">
            <h1>Order History</h1>
            <p>Track all your product purchases and order details</p>
        </div>
           
        <!-- Back Button -->
        <a href="userprofile.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>

        <!-- Order Statistics -->
        <?php
        // Calculate statistics
        $total_orders_query = mysqli_query($con, "SELECT COUNT(DISTINCT o.id) as count FROM orders o WHERE o.user_id = '$user_id'");
        $total_orders = mysqli_fetch_assoc($total_orders_query)['count'];
        
        $total_items_query = mysqli_query($con, "SELECT SUM(oi.quantity) as total FROM orders o JOIN order_items oi ON o.id = oi.order_id WHERE o.user_id = '$user_id'");
        $total_items = mysqli_fetch_assoc($total_items_query)['total'] ?? 0;
        
        $total_spent_query = mysqli_query($con, "SELECT SUM(p.price * oi.quantity) as total FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = '$user_id'");
        $total_spent = mysqli_fetch_assoc($total_spent_query)['total'] ?? 0;
        ?>
        
        <div class="order-stats">
            <div class="stat-card">
                <div class="stat-number"><?= $total_orders ?></div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $total_items ?></div>
                <div class="stat-label">Items Purchased</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$<?= number_format($total_spent, 2) ?></div>
                <div class="stat-label">Total Spent</div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="orders-list">
            <div class="orders-header">
                <h2>Recent Orders</h2>
            </div>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)) {
                    $imagePath = 'dashboard/product_images/' . str_replace('\\', '/', $row['image']);
                    $imagePath = file_exists($imagePath) ? $imagePath : 'default-product.png';
                    $item_total = $row['price'] * $row['quantity'];
                ?>
                    <div class="product-item">
                        <img class="product_img" src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>">
                        <div class="product-content">
                            <div class="product-info">
                                <h5><?= htmlspecialchars($row['product_name']) ?></h5>
                                <div class="product-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Ordered on <?= date('d M Y', strtotime($row['order_date'])) ?></span>
                                </div>
                            </div>
                            <div class="product-meta">
                                <span class="quantity-badge">Qty: <?= $row['quantity'] ?></span>
                                <span class="price-tag">$<?= number_format($row['price'], 2) ?></span>
                                <span class="total-amount">Total: $<?= number_format($item_total, 2) ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3>No Orders Yet</h3>
                    <p>You haven't made any purchases yet. Start shopping for your pet's needs!</p>
                    <a href="products.php" class="shop-button">
                        <i class="fas fa-shopping-cart"></i> Start Shopping
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'footerlink.php'; ?>

</body>
</html>
