<?php
session_start();
include "connection.php";

// Get filter parameters
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$search_filter = isset($_GET['search']) ? $_GET['search'] : '';
$price_sort = isset($_GET['price_sort']) ? $_GET['price_sort'] : '';

// Build query with filters
$query = "SELECT * FROM products WHERE 1=1";
$params = [];
$types = "";

if (!empty($category_filter)) {
    $query .= " AND category = ?";
    $params[] = $category_filter;
    $types .= "s";
}

if (!empty($search_filter)) {
    $query .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = "%$search_filter%";
    $params[] = "%$search_filter%";
    $types .= "ss";
}

// Add sorting
if ($price_sort == 'low_to_high') {
    $query .= " ORDER BY price ASC";
} elseif ($price_sort == 'high_to_low') {
    $query .= " ORDER BY price DESC";
} else {
    $query .= " ORDER BY name ASC";
}

// Execute query
if (!empty($params)) {
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($con, $query);
}

// Get all categories for filter dropdown
$categories_query = mysqli_query($con, "SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Our Products - CureMyPet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'; ?>
    <style>
        :root {
            --primary-orange: #e97140;
            --primary-orange-dark: #d6612d;
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
            background-color: var(--gray-50);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 80px 0 60px;
            margin-top: 80px;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            color: white;
        }

        .hero-content p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 0;
            color: white;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            padding: 25px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-bottom: 1px solid var(--gray-200);
        }

        .filter-container {
            background: var(--gray-50);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid var(--gray-200);
        }

        .filter-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 8px;
            display: block;
        }

        .form-control, .form-select {
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 15px;
            background: white;
            transition: all 0.3s ease;
            color: var(--gray-800);
            font-weight: 500;
            line-height: 1.5;
            min-height: 48px;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23374151' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px 12px;
            padding-right: 40px;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(233, 113, 64, 0.1);
        }

        /* Fix for select option styling */
        .form-select option {
            color: var(--gray-800);
            background: white;
            padding: 8px 12px;
            font-weight: 500;
            font-size: 15px;
        }

        .form-select option:hover {
            background: var(--gray-100);
        }

        .form-select option:checked,
        .form-select option:selected {
            background: var(--primary-orange);
            color: white;
            font-weight: 600;
        }

        /* Ensure selected value is properly displayed */
        .form-select:valid {
            color: var(--gray-800);
        }

        .form-select[data-selected="true"] {
            color: var(--gray-800);
            font-weight: 600;
        }

        /* Placeholder styling for search input */
        .form-control::placeholder {
            color: var(--gray-400);
            font-weight: 400;
            opacity: 1;
        }

        /* Custom styling for empty select */
        .form-select:invalid {
            color: var(--gray-500);
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233, 113, 64, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary-modern {
            background: var(--gray-500);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary-modern:hover {
            background: var(--gray-600);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        /* Products Section */
        .products-section {
            padding: 40px 0;
        }

        .product-count {
            font-size: 1rem;
            color: var(--gray-600);
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Product Cards */
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 25px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .product-image-container {
            position: relative;
            height: 280px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .stock-badge {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .product-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .product-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .product-title a:hover {
            color: var(--primary-orange);
            text-decoration: none;
        }

        .product-description {
            color: var(--gray-600);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .product-price-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-orange);
        }

        .product-rating {
            display: flex;
            gap: 2px;
        }

        .product-rating i {
            color: #fbbf24;
            font-size: 0.9rem;
        }

        .product-actions {
            margin-top: auto;
        }

        .stock-info {
            text-align: center;
            margin-top: 10px;
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        .out-of-stock-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            cursor: not-allowed;
            opacity: 0.8;
        }

        .out-of-stock-image {
            filter: grayscale(100%) opacity(0.6);
        }

        /* Empty State */
        .empty-products {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.08);
        }

        .empty-products i {
            font-size: 5rem;
            color: var(--gray-300);
            margin-bottom: 25px;
        }

        .empty-products h3 {
            font-size: 1.5rem;
            color: var(--gray-700);
            margin-bottom: 15px;
        }

        .empty-products p {
            color: var(--gray-500);
            font-size: 1rem;
            margin-bottom: 30px;
        }

        /* Alert Messages */
        .alert-modern {
            border: none;
            border-radius: 15px;
            padding: 20px 25px;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .hero-content p {
                font-size: 1.1rem;
            }
            
            .filter-container {
                padding: 20px;
            }
            
            .product-image-container {
                height: 240px;
            }
            
            .product-content {
                padding: 20px;
            }
            
            .product-title {
                font-size: 1.1rem;
            }
            
            .product-price {
                font-size: 1.3rem;
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
                        <div class="hero-content text-center">
                            <h1>Our Products</h1>
                            <p>Find the best products for your beloved pets</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="filter-section">
            <div class="container">
                <div class="filter-container">
                    <form method="GET" action="products.php" id="filterForm">
                        <div class="row align-items-end">
                            <!-- Search -->
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="filter-title">Search Products</label>
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Search for products..." 
                                       value="<?= htmlspecialchars($search_filter) ?>">
                            </div>
                            
                            <!-- Category Filter -->
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-title">Category</label>
                                <select name="category" class="form-select" <?= !empty($category_filter) ? 'data-selected="true"' : '' ?>>
                                    <option value="" <?= empty($category_filter) ? 'selected' : '' ?>>All Categories</option>
                                    <?php 
                                    $categories_query = mysqli_query($con, "SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
                                    while ($cat_row = mysqli_fetch_assoc($categories_query)) { ?>
                                        <option value="<?= htmlspecialchars($cat_row['category']) ?>" 
                                                <?= ($category_filter == $cat_row['category']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars(ucfirst($cat_row['category'])) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <!-- Sort -->
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-title">Sort by Price</label>
                                <select name="price_sort" class="form-select" <?= !empty($price_sort) ? 'data-selected="true"' : '' ?>>
                                    <option value="" <?= empty($price_sort) ? 'selected' : '' ?>>Default</option>
                                    <option value="low_to_high" <?= ($price_sort == 'low_to_high') ? 'selected' : '' ?>>Low to High</option>
                                    <option value="high_to_low" <?= ($price_sort == 'high_to_low') ? 'selected' : '' ?>>High to Low</option>
                                </select>
                            </div>
                            
                            <!-- Buttons -->
                            <div class="col-lg-2 col-md-6 mb-3">
                                <button type="submit" class="btn btn-primary-modern w-100 mb-2">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                                <a href="products.php" class="btn btn-secondary-modern w-100">
                                    <i class="fas fa-times me-2"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section class="products-section">
            <div class="container">
                <!-- Alert Messages -->
                <?php if (isset($_SESSION['cart_message'])): ?>
                    <div class="alert-modern <?php echo (isset($_SESSION['cart_message_type']) && $_SESSION['cart_message_type'] == 'error') ? 'alert-danger' : 'alert-success'; ?>">
                        <i class="fas <?php echo (isset($_SESSION['cart_message_type']) && $_SESSION['cart_message_type'] == 'error') ? 'fa-exclamation-triangle' : 'fa-check-circle'; ?> me-2"></i>
                        <?php 
                        echo $_SESSION['cart_message']; 
                        unset($_SESSION['cart_message']);
                        unset($_SESSION['cart_message_type']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <!-- Product Count -->
                <div class="product-count">
                    <?php 
                    $total_products = mysqli_num_rows($result);
                    echo "Showing $total_products product(s)";
                    if (!empty($category_filter)) {
                        echo " in '" . htmlspecialchars(ucfirst($category_filter)) . "'";
                    }
                    if (!empty($search_filter)) {
                        echo " for '" . htmlspecialchars($search_filter) . "'";
                    }
                    ?>
                </div>

                <!-- Products Grid -->
                <div class="row">
                    <?php if ($total_products > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php $stock_quantity = isset($row['stock_quantity']) ? (int)$row['stock_quantity'] : 0; ?>
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image-container">
                                        <a href="product_details.php?id=<?= $row['id'] ?>">
                                            <img src="dashboard/product_images/<?= htmlspecialchars($row['image']) ?>" 
                                                 alt="<?= htmlspecialchars($row['name']) ?>" 
                                                 class="product-image <?= ($stock_quantity <= 0) ? 'out-of-stock-image' : '' ?>">
                                        </a>
                                        
                                        <?php if (!empty($row['category'])): ?>
                                            <div class="category-badge">
                                                <?= htmlspecialchars(ucfirst($row['category'])) ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($stock_quantity <= 0): ?>
                                            <div class="stock-overlay">
                                                <div class="stock-badge">
                                                    <i class="fas fa-times-circle me-2"></i>Out of Stock
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="product-content">
                                        <h3 class="product-title">
                                            <a href="product_details.php?id=<?= $row['id'] ?>">
                                                <?= htmlspecialchars($row['name']) ?>
                                            </a>
                                        </h3>
                                        
                                        <p class="product-description">
                                            <?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...
                                        </p>
                                        
                                        <div class="product-price-section">
                                            <div class="product-price">
                                                AED <?= number_format($row['price'], 2) ?>
                                            </div>
                                            <div class="product-rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                        
                                        <div class="product-actions">
                                            <?php if ($stock_quantity <= 0): ?>
                                                <button class="out-of-stock-btn" disabled>
                                                    <i class="fas fa-times-circle me-2"></i>Out of Stock
                                                </button>
                                            <?php else: ?>
                                                <?php if (isset($_SESSION['user_id'])): ?>
                                                    <form method="post" action="cart.php?action=add&id=<?= $row['id'] ?>">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="btn btn-primary-modern w-100">
                                                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                                        </button>
                                                    </form>
                                                    <div class="stock-info">
                                                        <i class="fas fa-box me-1"></i>
                                                        <?= $stock_quantity ?> in stock
                                                    </div>
                                                <?php else: ?>
                                                    <a href="login.php" class="btn btn-secondary-modern w-100">
                                                        <i class="fas fa-sign-in-alt me-2"></i>Login to Shop
                                                    </a>
                                                    <div class="stock-info">
                                                        <i class="fas fa-box me-1"></i>
                                                        <?= $stock_quantity ?> in stock
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="empty-products">
                                <i class="fas fa-search"></i>
                                <h3>No products found</h3>
                                <p>Try adjusting your search criteria or browse all products.</p>
                                <a href="products.php" class="btn btn-primary-modern">
                                    <i class="fas fa-th-large me-2"></i>View All Products
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    
    <?php include 'footer.php'; ?>
    <?php include 'footerlink.php'; ?>
    
    <script>
        // Auto-submit form on category/sort change
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.querySelector('select[name="category"]');
            const sortSelect = document.querySelector('select[name="price_sort"]');
            
            // Update data-selected attribute when selection changes
            function updateSelectState(select) {
                if (select.value && select.value !== '') {
                    select.setAttribute('data-selected', 'true');
                } else {
                    select.removeAttribute('data-selected');
                }
            }
            
            if (categorySelect) {
                updateSelectState(categorySelect);
                categorySelect.addEventListener('change', function() {
                    updateSelectState(this);
                    document.getElementById('filterForm').submit();
                });
            }
            
            if (sortSelect) {
                updateSelectState(sortSelect);
                sortSelect.addEventListener('change', function() {
                    updateSelectState(this);
                    document.getElementById('filterForm').submit();
                });
            }
        });
    </script>
</body>
</html>