<?php
session_start();
include "connection.php";

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add to cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    // Check if product exists and has stock using prepared statement
    $stmt = mysqli_prepare($con, "SELECT * FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $stock_quantity = isset($product['stock_quantity']) ? (int)$product['stock_quantity'] : 0;
        
        // Check if product is out of stock
        if ($stock_quantity <= 0) {
            $_SESSION['cart_message'] = "Sorry, this product is out of stock!";
            $_SESSION['cart_message_type'] = "error";
            header("Location: products.php");
            exit();
        }
        
        // Check if adding this quantity would exceed stock
        $current_cart_quantity = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id]['quantity'] : 0;
        $total_requested = $current_cart_quantity + $quantity;
        
        if ($total_requested > $stock_quantity) {
            $_SESSION['cart_message'] = "Only $stock_quantity items available in stock!";
            $_SESSION['cart_message_type'] = "error";
            header("Location: products.php");
            exit();
        }
        
        // Check if product already in cart
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = array(
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image'],
                'category' => $product['category'],
                'stock_quantity' => $stock_quantity
            );
        }
        
        $_SESSION['cart_message'] = "Product added to cart successfully!";
        $_SESSION['cart_message_type'] = "success";
        header("Location: cart.php");
        exit();
    }
}

// Remove from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
        $_SESSION['cart_message'] = "Product removed from cart!";
    }
    header("Location: cart.php");
    exit();
}

// Update cart quantities
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if (isset($_SESSION['cart'][$id])) {
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                $_SESSION['cart'][$id]['quantity'] = (int)$quantity;
            }
        }
    }
    $_SESSION['cart_message'] = "Cart updated successfully!";
    header("Location: cart.php");
    exit();
}

// Clear entire cart
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    $_SESSION['cart'] = array();
    $_SESSION['cart_message'] = "Cart cleared successfully!";
    header("Location: cart.php");
    exit();
}
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shopping Cart - CureMyPet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'?>
    <style>
        .cart-section {
            padding: 40px 0;
        }
        
        .cart-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .cart-table th {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            color: white;
            font-weight: 600;
            padding: 20px 15px;
            border: none;
        }
        
        .cart-table td {
            padding: 20px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .cart-table tr:last-child td {
            border-bottom: none;
        }
        
        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #f1f5f9;
        }
        
        .product-details h5 {
            margin: 0;
            font-weight: 600;
            color: #2d3748;
        }
        
        .product-category {
            background: #e97140;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 5px;
            display: inline-block;
        }
        
        .quantity-input {
            width: 80px;
            text-align: center;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px;
            font-weight: 600;
        }
        
        .quantity-input:focus {
            border-color: #e97140;
            box-shadow: 0 0 0 3px rgba(233, 113, 64, 0.1);
        }
        
        .price-text {
            font-weight: 700;
            color: #e97140;
            font-size: 1.1rem;
        }
        
        .btn-remove {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-remove:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            color: white;
        }
        
        .cart-summary {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .summary-row:last-child {
            border-bottom: none;
            font-size: 1.25rem;
            font-weight: 700;
            color: #e97140;
        }
        
        .btn-modern {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233, 113, 64, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary-modern {
            background: #6b7280;
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-modern:hover {
            background: #4b5563;
            transform: translateY(-2px);
            color: white;
        }
        
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .empty-cart i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }
        
        .cart-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .cart-message {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: none;
        }
        
        .cart-message-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }
        
        @media (max-width: 768px) {
            .product-info {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .cart-table {
                font-size: 0.9rem;
            }
            
            .cart-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .cart-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'?>
    
    <main>
        <!-- Hero Area Start -->
        <div class="slider-area2 slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center pt-50">
                            <h2>Shopping Cart</h2>
                            <p>Review your selected items</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cart Section -->
        <div class="cart-section">
            <div class="container">
                <?php if (isset($_SESSION['cart_message'])): ?>
                    <div class="cart-message <?php echo (isset($_SESSION['cart_message_type']) && $_SESSION['cart_message_type'] == 'error') ? 'cart-message-error' : ''; ?>">
                        <i class="fas <?php echo (isset($_SESSION['cart_message_type']) && $_SESSION['cart_message_type'] == 'error') ? 'fa-exclamation-triangle' : 'fa-check-circle'; ?> me-2"></i>
                        <?php 
                        echo $_SESSION['cart_message']; 
                        unset($_SESSION['cart_message']);
                        unset($_SESSION['cart_message_type']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($_SESSION['cart'])): ?>
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added any items to your cart yet.</p>
                        <a href="products.php" class="btn btn-modern mt-3">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                    </div>
                <?php else: ?>
                    <form method="post" action="cart.php">
                        <div class="cart-table">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    foreach ($_SESSION['cart'] as $id => $item): 
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $total += $subtotal;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <img src="dashboard/product_images/<?php echo htmlspecialchars($item['image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                                         class="product-image">
                                                    <div class="product-details">
                                                        <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                                                        <?php if (!empty($item['category'])): ?>
                                                            <span class="product-category"><?php echo htmlspecialchars(ucfirst($item['category'])); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="price-text">AED <?php echo number_format($item['price'], 2); ?></span>
                                            </td>
                                            <td>
                                                <?php 
                                                $max_stock = isset($item['stock_quantity']) ? $item['stock_quantity'] : 999;
                                                ?>
                                                <input type="number" 
                                                       name="quantity[<?php echo $id; ?>]" 
                                                       value="<?php echo $item['quantity']; ?>" 
                                                       min="1" 
                                                       max="<?php echo $max_stock; ?>"
                                                       class="quantity-input"
                                                       data-stock="<?php echo $max_stock; ?>">
                                                <small class="text-muted d-block mt-1">
                                                    <i class="fas fa-box me-1"></i>
                                                    <?php echo $max_stock; ?> available
                                                </small>
                                            </td>
                                            <td>
                                                <span class="price-text">AED <?php echo number_format($subtotal, 2); ?></span>
                                            </td>
                                            <td>
                                                <a href="cart.php?action=remove&id=<?php echo $id; ?>" 
                                                   class="btn btn-remove"
                                                   onclick="return confirm('Are you sure you want to remove this item?')">
                                                    <i class="fas fa-trash me-1"></i>Remove
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="cart-summary">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="cart-actions">
                                        <button type="submit" name="update_cart" class="btn btn-secondary-modern">
                                            <i class="fas fa-sync me-2"></i>Update Cart
                                        </button>
                                        <a href="products.php" class="btn btn-secondary-modern">
                                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                        </a>
                                        <a href="cart.php?action=clear" class="btn btn-remove"
                                           onclick="return confirm('Are you sure you want to clear your entire cart?')">
                                            <i class="fas fa-trash me-2"></i>Clear Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="summary-row">
                                        <span>Subtotal:</span>
                                        <span>AED <?php echo number_format($total, 2); ?></span>
                                    </div>
                                    <div class="summary-row">
                                        <span>Shipping:</span>
                                        <span style="color: #10b981;">Free</span>
                                    </div>
                                    <div class="summary-row">
                                        <span>Total:</span>
                                        <span>AED <?php echo number_format($total, 2); ?></span>
                                    </div>
                                    <div class="mt-3">
                                        <a href="checkout.php" class="btn btn-modern w-100">
                                            <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'?>
    <?php include 'footerlink.php'?>
    
    <script>
        // Auto-update quantities and prices
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            
            quantityInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const maxStock = parseInt(this.getAttribute('data-stock')) || 999;
                    
                    if (this.value < 1) {
                        this.value = 1;
                    }
                    if (this.value > maxStock) {
                        this.value = maxStock;
                        showStockAlert(maxStock);
                    }
                    updateCartPrices();
                });
                
                input.addEventListener('change', function() {
                    const maxStock = parseInt(this.getAttribute('data-stock')) || 999;
                    
                    if (this.value < 1) {
                        this.value = 1;
                    }
                    if (this.value > maxStock) {
                        this.value = maxStock;
                        showStockAlert(maxStock);
                    }
                    updateCartPrices();
                    // Auto-save to session
                    autoUpdateCart();
                });
            });
        });

        function updateCartPrices() {
            let total = 0;
            
            document.querySelectorAll('.cart-table tbody tr').forEach(row => {
                const quantityInput = row.querySelector('.quantity-input');
                const priceElement = row.querySelector('.price-text');
                const totalElement = row.querySelector('td:nth-child(4) .price-text');
                
                if (quantityInput && priceElement && totalElement) {
                    const quantity = parseInt(quantityInput.value) || 1;
                    const priceText = priceElement.textContent.replace('AED ', '').replace(',', '');
                    const price = parseFloat(priceText);
                    const subtotal = price * quantity;
                    
                    totalElement.textContent = 'AED ' + subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    total += subtotal;
                }
            });
            
            // Update summary totals
            const summarySubtotal = document.querySelector('.summary-row:nth-child(1) span:last-child');
            const summaryTotal = document.querySelector('.summary-row:last-child span:last-child');
            
            if (summarySubtotal && summaryTotal) {
                summarySubtotal.textContent = 'AED ' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                summaryTotal.textContent = 'AED ' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
        }

        function autoUpdateCart() {
            const formData = new FormData();
            formData.append('update_cart', '1');
            
            document.querySelectorAll('.quantity-input').forEach(input => {
                const name = input.getAttribute('name');
                const value = input.value;
                formData.append(name, value);
            });

            fetch('cart.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    console.log('Cart updated successfully');
                }
            }).catch(error => {
                console.error('Error updating cart:', error);
            });
        }

        function showStockAlert(maxStock) {
            // Create temporary alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning';
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i>Only ${maxStock} items available in stock!`;
            
            document.body.appendChild(alertDiv);
            
            // Remove after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 3000);
        }
    </script>
</body>
</html>