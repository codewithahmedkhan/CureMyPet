<?php
// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Include preloader
include 'preloader.php';
?>

<style>
/* Modern Header Styles */
.header-area {
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 999;
    transition: all 0.3s ease;
}

.header-area .main-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 5px 0;
    transition: all 0.3s ease;
}

.header-area.header-sticky.sticky-bar {
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Navigation Links */
.main-menu ul li a {
    color: var(--gray-700);
    font-weight: 500;
    font-size: 16px;
    padding: 8px 20px;
    transition: all 0.3s ease;
    position: relative;
    font-family: 'Inter', sans-serif;
}

.main-menu ul li a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    width: 0;
    height: 3px;
    background: var(--primary-orange);
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.main-menu ul li a:hover::after,
.main-menu ul li.active a::after {
    width: 60%;
}

.main-menu ul li a:hover {
    color: var(--primary-orange);
}

/* Search Toggle */
.search-toggle img {
    transition: all 0.3s ease;
}

.search-toggle:hover img {
    transform: scale(1.1);
}

/* Header Button */
.header-btn {
    background: linear-gradient(135deg, var(--primary-orange) 0%, #ea580c 100%);
    color: white !important;
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(249, 115, 22, 0.3);
}

.header-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(249, 115, 22, 0.3);
}

/* Search Popup */
#search-popup {
    backdrop-filter: blur(8px);
}

#search-popup > div {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#search-input {
    font-size: 18px;
    padding: 15px;
    border: 2px solid var(--gray-300);
    transition: all 0.3s ease;
}

#search-input:focus {
    outline: none;
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
}

/* Mobile Styles */
@media (max-width: 768px) {
    .header-area .main-header .row {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 0px;
    }
    
    .mobile_menu .slicknav_menu .slicknav_nav {
        margin-top: 15px !important;
        width: 250px;
        z-index: 208999990 !important;
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .logo, .mobile_menu {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .mobile_menu .slicknav_menu {
        text-align: right !important;
        margin-top: 0px !important;
    }

    .slicknav_btn {
        float: none !important;
        margin: 0 auto;
    }

    .header-right-btn img {
        vertical-align: middle;
    }
    
    .header-area .main-header {
        padding: 5px 0;
    }
}

.logo_img {
    width: 150px;
    height: auto;
    max-height: 120px;
    object-fit: contain;
    transition: all 0.3s ease;
}

.logo_img:hover {
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .logo_img {
        width: 100px !important;
        max-height: 100px !important;
    }
}

@media (max-width: 575px) {
    .header-area .main-header {
        padding: 3px 0px;
    }
}
</style>

<!-- Header Start -->
<header>
    <!-- Search Popup -->
    <div id="search-popup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#000000c0; z-index:9999;">
        <div style="position:relative; top:20%; margin:auto; width:90%; max-width:500px; background:white; padding:20px; border-radius:10px;">
            <button id="close-search" style="float:right; border:none; background:none; font-size:20px; color: #000;">&times;</button>
            <input type="text" id="search-input" placeholder="Search products..." style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
            <div id="search-results" style="margin-top:15px;"></div>
        </div>
    </div>

    <div class="header-area header-transparent">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-between">

                    <!-- Logo (All devices) -->
                    <div class="col-6 col-lg-2 d-flex align-items-center">
                        <div class="logo">
                            <a href="index.php">
                                <img src="assets/img/logo/logo.png" class="logo_img" alt="Logo">
                            </a>
                        </div>
                    </div>

                    <div class="col-3 d-block d-lg-none text-right" style="top:20px">
                        <div class="mobile_menu"></div>
                    </div>

                    <!-- Mobile Search Icon -->
                    <div class="col-3 d-block d-lg-none text-left">
                        <a href="#" class="search-toggle"><img src="assets/img/search.png" width="28" /></a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="col-lg-8 d-none d-lg-block">
                        <div class="menu-main d-flex align-items-center justify-content-center">
                            <div class="main-menu">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="about.php">About</a></li>
                                        <li><a href="services.php">Services</a></li>
                                        <li><a href="products.php">Products</a></li>
                                        <li><a href="education-center.php">Education Center</a></li>
                                        <li><a href="contact.php">Contact</a></li>
                                        <?php 
                                        if (!isset($_SESSION['loginsuccessfull'])) {
                                            echo '<li class="d-block d-lg-none"><a href="login.php">Login</a></li>';
                                        } else {
                                            echo '<li class="d-block d-lg-none"><a href="userprofile.php">My Account</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Search & Login -->
                    <div class="col-lg-2 d-none d-lg-block text-right">
                        <div class="header-right-btn d-flex align-items-center justify-content-end gap-4">
                            <a href="#" class="search-toggle" style="margin-right: 15px;"><img src="assets/img/search.png" width="30"/></a>
                            <?php 
                            if (isset($_SESSION['loginsuccessfull'])) {
                                echo '<a href="userprofile.php" class="header-btn"><img src="img/user.png" width="20" /></a>';
                            } else {
                                echo '<a href="login.php" class="header-btn">Login Now</a>';
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.search-toggle').click(function(e){
        e.preventDefault();
        $('#search-popup').fadeIn();
    });

    $('#close-search').click(function(){
        $('#search-popup').fadeOut();
        $('#search-input').val('');
        $('#search-results').html('');
    });

    $('#search-input').on('input', function(){
        var query = $(this).val();
        if(query.length > 1){
            $.ajax({
                url: 'search_products.php',
                type: 'POST',
                data: {query: query},
                success: function(data){
                    $('#search-results').html(data);
                }
            });
        } else {
            $('#search-results').html('');
        }
    });

    $(document).on('keyup', function(e) {
        if (e.key === "Escape") {
            $('#search-popup').fadeOut();
            $('#search-input').val('');
            $('#search-results').html('');
        }
    });
});
</script>
