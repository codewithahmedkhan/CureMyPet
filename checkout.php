<?php
session_start();
ob_start(); // Start output buffering
include "connection.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Get user info if logged in
$loggedInUser = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = mysqli_prepare($con, "SELECT name, email, contact FROM user WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $loggedInUser = mysqli_fetch_assoc($result);
}

// Process checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'])) {
    echo "<script>console.log('DEBUG: Place order button clicked');</script>";
    
    // First, validate stock for all items in cart
    $stock_errors = [];
    echo "<script>console.log('DEBUG: Starting stock validation for " . count($_SESSION['cart']) . " items');</script>";
    
    foreach ($_SESSION['cart'] as $id => $item) {
        echo "<script>console.log('DEBUG: Checking stock for product ID: $id');</script>";
        
        $stmt = mysqli_prepare($con, "SELECT stock_quantity FROM products WHERE id = ?");
        if (!$stmt) {
            echo "<script>console.log('DEBUG: Failed to prepare stock query: " . mysqli_error($con) . "');</script>";
        }
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $current_stock = (int)$row['stock_quantity'];
            echo "<script>console.log('DEBUG: Product $id stock: $current_stock, requested: {$item['quantity']}');</script>";
            if ($current_stock < $item['quantity']) {
                $stock_errors[] = "'{$item['name']}' - Only {$current_stock} available (you have {$item['quantity']} in cart)";
            }
        } else {
            echo "<script>console.log('DEBUG: Product $id not found in database');</script>";
            $stock_errors[] = "'{$item['name']}' - Product no longer available";
        }
    }
    
    if (!empty($stock_errors)) {
        echo "<script>console.log('DEBUG: Stock validation failed with errors: " . json_encode($stock_errors) . "');</script>";
        $error = "Stock validation failed:\n" . implode("\n", $stock_errors) . "\n\nPlease update your cart and try again.";
    } else {
        echo "<script>console.log('DEBUG: Stock validation passed, calculating total');</script>";
        
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $item) {
            $total += $item['price'] * $item['quantity'];
        }
        echo "<script>console.log('DEBUG: Total calculated: $total');</script>";

    echo "<script>console.log('DEBUG: Processing customer information');</script>";
    if ($loggedInUser) {
        echo "<script>console.log('DEBUG: Using logged in user data');</script>";
        $name = mysqli_real_escape_string($con, $loggedInUser['name']);
        $email = mysqli_real_escape_string($con, $loggedInUser['email']);
        $phone = mysqli_real_escape_string($con, $loggedInUser['contact']);
    } else {
        echo "<script>console.log('DEBUG: Using form data');</script>";
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
    }

    $address = mysqli_real_escape_string($con, $_POST['address']);
    $payment_method = 'Cash on Delivery';
    
    echo "<script>console.log('DEBUG: Customer info - Name: $name, Email: $email, Phone: $phone');</script>";

    // Use prepared statements for order insertion
    echo "<script>console.log('DEBUG: Preparing order insertion query');</script>";
    if ($loggedInUser) {
        $user_id = $_SESSION['user_id'];
        echo "<script>console.log('DEBUG: Inserting order for logged-in user ID: $user_id');</script>";
        $stmt = mysqli_prepare($con, "INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, customer_address, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo "<script>console.log('DEBUG: Failed to prepare logged-in user order query: " . mysqli_error($con) . "');</script>";
        }
        mysqli_stmt_bind_param($stmt, "issssds", $user_id, $name, $email, $phone, $address, $total, $payment_method);
    } else {
        echo "<script>console.log('DEBUG: Inserting order for guest user');</script>";
        $stmt = mysqli_prepare($con, "INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo "<script>console.log('DEBUG: Failed to prepare guest order query: " . mysqli_error($con) . "');</script>";
        }
        mysqli_stmt_bind_param($stmt, "ssssds", $name, $email, $phone, $address, $total, $payment_method);
    }

    echo "<script>console.log('DEBUG: Executing order insertion query');</script>";
    if (mysqli_stmt_execute($stmt)) {
        $order_id = mysqli_insert_id($con);
        echo "<script>console.log('DEBUG: Order inserted successfully with ID: $order_id');</script>";

        // Insert order items using prepared statements (only if order_items table exists)
        $order_items_success = true;
        $check_table = mysqli_query($con, "SHOW TABLES LIKE 'order_items'");
        
        echo "<script>console.log('DEBUG: Checking if order_items table exists');</script>";
        if (mysqli_num_rows($check_table) > 0) {
            echo "<script>console.log('DEBUG: order_items table exists, inserting order items');</script>";
            $item_stmt = mysqli_prepare($con, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            
            foreach ($_SESSION['cart'] as $id => $item) {
                $product_id = $id;
                $quantity = $item['quantity'];
                $price = $item['price'];
                
                echo "<script>console.log('DEBUG: Inserting order item - Product: $product_id, Qty: $quantity, Price: $price');</script>";
                mysqli_stmt_bind_param($item_stmt, "iiid", $order_id, $product_id, $quantity, $price);
                if (!mysqli_stmt_execute($item_stmt)) {
                    echo "<script>console.log('DEBUG: Failed to insert order item: " . mysqli_error($con) . "');</script>";
                    $order_items_success = false;
                    break;
                }
            }
        } else {
            echo "<script>console.log('DEBUG: order_items table does not exist, skipping order items insertion');</script>";
        }
        
        // Update stock quantities
        echo "<script>console.log('DEBUG: Updating stock quantities');</script>";
        $stock_stmt = mysqli_prepare($con, "UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
        foreach ($_SESSION['cart'] as $id => $item) {
            $quantity = $item['quantity'];
            $product_id = $id;
            
            echo "<script>console.log('DEBUG: Updating stock for product $product_id, reducing by $quantity');</script>";
            mysqli_stmt_bind_param($stock_stmt, "ii", $quantity, $product_id);
            if (!mysqli_stmt_execute($stock_stmt)) {
                echo "<script>console.log('DEBUG: Failed to update stock for product $product_id: " . mysqli_error($con) . "');</script>";
            }
        }

        echo "<script>console.log('DEBUG: Clearing cart and redirecting to success page');</script>";
        unset($_SESSION['cart']);
        echo "<script>console.log('DEBUG: About to redirect to order_success.php?order_id=$order_id');</script>";
        ob_end_clean(); // Clear output buffer before redirect
        header("Location: order_success.php?order_id=$order_id");
        exit();
    } else {
        $error = "Error placing order: " . mysqli_error($con);
        echo "<script>console.log('DEBUG: Order insertion failed: " . mysqli_error($con) . "');</script>";
    }
    }
}
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Checkout - CureMyPet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'; ?>
    <style>
        .checkout-section {
            padding: 40px 0;
        }
        
        .checkout-form {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .section-title {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e97140;
            display: inline-block;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #e97140;
            box-shadow: 0 0 0 3px rgba(233, 113, 64, 0.1);
            outline: none;
        }
        
        .form-control[readonly] {
            background-color: #f8fafc;
            color: #6b7280;
        }
        
        .order-summary {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .order-item-details {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }
        
        .order-item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #f1f5f9;
        }
        
        .order-item-info h6 {
            margin: 0;
            font-weight: 600;
            color: #2d3748;
            font-size: 0.95rem;
        }
        
        .order-item-category {
            background: #e97140;
            color: white;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 500;
            margin-top: 3px;
            display: inline-block;
        }
        
        .order-item-quantity {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .order-item-price {
            font-weight: 700;
            color: #e97140;
        }
        
        .summary-totals {
            border-top: 2px solid #f1f5f9;
            padding-top: 20px;
            margin-top: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }
        
        .summary-row.total {
            font-size: 1.25rem;
            font-weight: 700;
            color: #e97140;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
            margin-top: 10px;
        }
        
        .payment-method {
            background: #f8fafc;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .payment-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-option:hover {
            border-color: #e97140;
            background: #fef7f0;
        }
        
        .payment-option input[type="radio"] {
            margin: 0;
        }
        
        .payment-icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
        }
        
        .btn-place-order {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-place-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(233, 113, 64, 0.4);
            color: white;
        }
        
        .security-info {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .progress-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
        }
        
        .progress-step {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
        }
        
        .progress-step.active {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            color: white;
        }
        
        .progress-step.completed {
            background: #10b981;
            color: white;
        }
        
        .progress-step.inactive {
            background: #f1f5f9;
            color: #6b7280;
        }
        
        @media (max-width: 768px) {
            .checkout-form, .order-summary {
                padding: 20px;
            }
            
            .order-item-details {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .progress-steps {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <main>
        <!-- Hero Area Start -->
        <div class="slider-area2 slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center pt-50">
                            <h2>Checkout</h2>
                            <p>Complete your order</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Section -->
        <div class="checkout-section">
            <div class="container">
                <!-- Progress Steps -->
                <div class="progress-steps">
                    <div class="progress-step completed">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Cart</span>
                    </div>
                    <div class="progress-step active">
                        <i class="fas fa-credit-card"></i>
                        <span>Checkout</span>
                    </div>
                    <div class="progress-step inactive">
                        <i class="fas fa-check-circle"></i>
                        <span>Complete</span>
                    </div>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" style="white-space: pre-line; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 10px; padding: 20px;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="post" id="checkoutForm">
                    <div class="row">
                        <!-- Billing Details -->
                        <div class="col-lg-7">
                            <div class="checkout-form">
                                <h3 class="section-title">
                                    <i class="fas fa-user me-2"></i>Billing Details
                                </h3>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name *</label>
                                            <input type="text" 
                                                   id="name"
                                                   name="name" 
                                                   class="form-control" 
                                                   required
                                                   value="<?= $loggedInUser ? htmlspecialchars($loggedInUser['name']) : '' ?>"
                                                   <?= $loggedInUser ? 'readonly' : '' ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address *</label>
                                            <input type="email" 
                                                   id="email"
                                                   name="email" 
                                                   class="form-control" 
                                                   required
                                                   value="<?= $loggedInUser ? htmlspecialchars($loggedInUser['email']) : '' ?>"
                                                   <?= $loggedInUser ? 'readonly' : '' ?>>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" 
                                           id="phone"
                                           name="phone" 
                                           class="form-control" 
                                           required
                                           value="<?= $loggedInUser ? htmlspecialchars($loggedInUser['contact']) : '' ?>"
                                           <?= $loggedInUser ? 'readonly' : '' ?>>
                                </div>
                                
                                <div class="form-group">
                                    <label for="address">Delivery Address *</label>
                                    <textarea name="address" 
                                              id="address"
                                              class="form-control" 
                                              rows="4" 
                                              required
                                              placeholder="Enter your complete delivery address including area, street, building number, and any landmarks"></textarea>
                                </div>

                                <?php if ($loggedInUser): ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Your account information is being used for this order.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="col-lg-5">
                            <div class="order-summary">
                                <h3 class="section-title">
                                    <i class="fas fa-receipt me-2"></i>Your Order
                                </h3>

                                <!-- Order Items -->
                                <?php 
                                $total = 0;
                                foreach ($_SESSION['cart'] as $id => $item): 
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                ?>
                                    <div class="order-item">
                                        <div class="order-item-details">
                                            <img src="dashboard/product_images/<?= htmlspecialchars($item['image']) ?>" 
                                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                                 class="order-item-image">
                                            <div class="order-item-info">
                                                <h6><?= htmlspecialchars($item['name']) ?></h6>
                                                <?php if (!empty($item['category'])): ?>
                                                    <span class="order-item-category"><?= htmlspecialchars(ucfirst($item['category'])) ?></span>
                                                <?php endif; ?>
                                                <div class="order-item-quantity">Qty: <?= $item['quantity'] ?></div>
                                            </div>
                                        </div>
                                        <div class="order-item-price">
                                            AED <?= number_format($subtotal, 2) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Summary Totals -->
                                <div class="summary-totals">
                                    <div class="summary-row">
                                        <span>Subtotal:</span>
                                        <span>AED <?= number_format($total, 2) ?></span>
                                    </div>
                                    <div class="summary-row">
                                        <span>Shipping:</span>
                                        <span style="color: #10b981;">Free</span>
                                    </div>
                                    <div class="summary-row">
                                        <span>Tax:</span>
                                        <span>AED 0.00</span>
                                    </div>
                                    <div class="summary-row total">
                                        <span>Total:</span>
                                        <span>AED <?= number_format($total, 2) ?></span>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="payment-method">
                                    <h5><i class="fas fa-credit-card me-2"></i>Payment Method</h5>
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="cod" value="Cash on Delivery" checked>
                                        <div class="payment-icon">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <div>
                                            <strong>Cash on Delivery</strong>
                                            <div style="font-size: 0.85rem; color: #6b7280;">Pay when your order arrives</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Place Order Button -->
                                <button type="submit" name="place_order" class="btn-place-order">
                                    <i class="fas fa-shopping-bag me-2"></i>Place Order
                                </button>

                                <!-- Security Info -->
                                <div class="security-info">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Your order is secure and your information is protected
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    <?php include 'footerlink.php'; ?>
    
    <script>
        // Form validation
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const address = document.getElementById('address').value.trim();
            
            if (!name || !email || !phone || !address) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
            
            if (address.length < 10) {
                e.preventDefault();
                alert('Please enter a complete delivery address.');
                return false;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('.btn-place-order');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing Order...';
            submitBtn.disabled = true;
        });
        
        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
</body>
</html>