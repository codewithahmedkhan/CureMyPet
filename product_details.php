<?php
session_start();
include "connection.php";

// 🚫 Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ Validate product ID and fetch product
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input
    $query = mysqli_query($con, "SELECT * FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($query);
    
    if (!$product) {
        header("Location: products.php");
        exit();
    }
} else {
    header("Location: products.php");
    exit();
}
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= htmlspecialchars($product['name']); ?> - CureMyPet</title>
    <meta name="description" content="<?= htmlspecialchars(substr($product['description'], 0, 160)); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'; ?>
    <style>
        :root {
            --primary-orange: #e97140;
            --primary-orange-dark: #d6612d;
            --teal-color: #007582;
            --success-green: #10b981;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        body {
            background: var(--gray-50);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 120px 0 80px;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="30" r="1" fill="white" opacity="0.05"/><circle cx="80" cy="60" r="1" fill="white" opacity="0.08"/><circle cx="30" cy="80" r="1" fill="white" opacity="0.06"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 4px 8px rgba(0,0,0,0.2);
            color: white;
        }

        .breadcrumb-nav {
            position: relative;
            z-index: 2;
            text-align: center;
            margin-top: 20px;
        }

        .breadcrumb-nav a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-nav a:hover {
            color: white;
        }

        .breadcrumb-nav span {
            color: rgba(255,255,255,0.6);
            margin: 0 10px;
        }

        /* Product Section */
        .product-section {
            padding: 80px 0;
        }

        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .product-card {
            background: white;
            border-radius: 25px;
            padding: 50px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.15);
            border-top: 5px solid var(--primary-orange);
        }

        .product-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .product-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .stock-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--success-green);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stock-badge.out-of-stock {
            background: #ef4444;
        }

        .product-details {
            padding-left: 30px;
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-orange);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .currency-symbol {
            font-size: 1.5rem;
            color: var(--gray-600);
        }

        .product-description {
            font-size: 1.1rem;
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .product-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        .meta-item {
            background: var(--gray-100);
            padding: 20px;
            border-radius: 15px;
            border-left: 4px solid var(--teal-color);
        }

        .meta-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .meta-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .quantity-section {
            background: var(--gray-100);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
        }

        .quantity-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 15px;
            display: block;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .quantity-btn {
            background: var(--primary-orange);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background: var(--primary-orange-dark);
            transform: translateY(-2px);
        }

        .quantity-input {
            width: 80px;
            padding: 12px;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            background: white;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 4px rgba(233, 113, 64, 0.15);
        }

        .stock-info {
            font-size: 0.9rem;
            color: var(--gray-500);
        }

        .add-to-cart-btn {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 18px 40px;
            font-size: 1.2rem;
            font-weight: 700;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 12px 35px rgba(233, 113, 64, 0.3);
        }

        .add-to-cart-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 45px rgba(233, 113, 64, 0.4);
            background: linear-gradient(135deg, var(--primary-orange-dark) 0%, #ea580c 100%);
        }

        .add-to-cart-btn:disabled {
            background: var(--gray-400);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .out-of-stock-btn {
            background: var(--gray-400);
            color: white;
            padding: 18px 40px;
            font-size: 1.2rem;
            font-weight: 700;
            border: none;
            border-radius: 15px;
            cursor: not-allowed;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .features-section {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-top: 40px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
        }

        .features-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 25px;
            text-align: center;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
        }

        .feature-item {
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            background: var(--gray-50);
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--teal-color);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 1.5rem;
        }

        .feature-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .product-card {
                padding: 30px 20px;
            }
            
            .product-details {
                padding-left: 0;
                margin-top: 30px;
            }
            
            .product-title {
                font-size: 2rem;
            }
            
            .product-price {
                font-size: 1.5rem;
            }
            
            .product-meta {
                grid-template-columns: 1fr;
            }
            
            .quantity-controls {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-content">
                            <h1><?= htmlspecialchars($product['name']); ?></h1>
                            <div class="breadcrumb-nav">
                                <a href="index.php">Home</a>
                                <span>•</span>
                                <a href="products.php">Products</a>
                                <span>•</span>
                                <span style="color: white;"><?= htmlspecialchars($product['name']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Product Details Section -->
        <section class="product-section">
            <div class="product-container">
                <div class="product-card">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-image-container">
                                <img src="dashboard/product_images/<?= htmlspecialchars($product['image']); ?>" 
                                     class="product-image" 
                                     alt="<?= htmlspecialchars($product['name']); ?>">
                                <div class="stock-badge <?= ($product['stock_quantity'] <= 0) ? 'out-of-stock' : ''; ?>">
                                    <?= ($product['stock_quantity'] > 0) ? 'In Stock' : 'Out of Stock'; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="product-details">
                                <h1 class="product-title"><?= htmlspecialchars($product['name']); ?></h1>
                                
                                <div class="product-price">
                                    <span class="currency-symbol">AED</span>
                                    <?= number_format($product['price'] * 0.74, 2); ?>
                                </div>
                                
                                <div class="product-description">
                                    <?= nl2br(htmlspecialchars($product['description'])); ?>
                                </div>
                                
                                <div class="product-meta">
                                    <div class="meta-item">
                                        <div class="meta-label">Category</div>
                                        <div class="meta-value"><?= htmlspecialchars($product['category']); ?></div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Stock Available</div>
                                        <div class="meta-value"><?= $product['stock_quantity']; ?> units</div>
                                    </div>
                                </div>
                                
                                <?php if ($product['stock_quantity'] > 0) { ?>
                                    <form method="post" action="cart.php?action=add&id=<?= $product['id']; ?>" id="addToCartForm">
                                        <div class="quantity-section">
                                            <label class="quantity-label">Quantity:</label>
                                            <div class="quantity-controls">
                                                <button type="button" class="quantity-btn" onclick="decreaseQuantity()">-</button>
                                                <input type="number" class="quantity-input" id="quantity" name="quantity" 
                                                       value="1" min="1" max="<?= $product['stock_quantity']; ?>" readonly>
                                                <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                                            </div>
                                            <div class="stock-info">
                                                <?= $product['stock_quantity']; ?> items available
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fas fa-shopping-cart"></i>
                                            Add to Cart
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <button class="out-of-stock-btn" disabled>
                                        <i class="fas fa-times"></i>
                                        Out of Stock
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Features Section -->
                <div class="features-section">
                    <h2 class="features-title">Why Choose CureMyPet Products?</h2>
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="ti-shield"></i>
                            </div>
                            <div class="feature-text">Vet Approved Quality</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="ti-truck"></i>
                            </div>
                            <div class="feature-text">Fast UAE Delivery</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="ti-star"></i>
                            </div>
                            <div class="feature-text">Premium Brands</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="ti-headphone-alt"></i>
                            </div>
                            <div class="feature-text">24/7 Pet Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <?php include 'footer.php'; ?>
    <?php include 'footerlink.php'; ?>

    <script>
        const maxQuantity = <?= $product['stock_quantity']; ?>;
        
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            
            if (currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
            }
        }
        
        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        // Add to cart with loading state
        document.getElementById('addToCartForm')?.addEventListener('submit', function() {
            const submitBtn = document.querySelector('.add-to-cart-btn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding to Cart...';
            submitBtn.disabled = true;
        });

        // Image zoom effect
        const productImage = document.querySelector('.product-image');
        productImage.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        productImage.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    </script>
</body>
</html>
