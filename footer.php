



<style>
    li a, li {
        font-size: 20px;
        line-height: 35px;
    }

    ul {
        margin-top: 20px;
    }

    #scrollUp, #back-top {
        background: #007482;
    }

    .subscribe-box input {
        border-radius: 4px;
        border: none;
    }

    .subscribe-box input:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
    }

    .subscribe-box .form-control {
        padding: 10px;
        font-size: 14px;
    }

    .subscribe-box button {
        font-weight: bold;
    }
</style>

<footer>
    <!-- Footer Start -->
    <div class="footer-area footer-padding" style="background: linear-gradient(to right,#e97140 ,rgb(226, 147, 115)); color: #fff;">
        <div class="container">
            <div class="row">
                <!-- Logo & About -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="footer-logo mb-3">
                        <a href="index.php">
                            <img src="assets/img/logo/logo2_footer.png" alt="Logo" width="160">
                        </a>
                    </div>
                    <p style="color: #e0e0e0;">Your trusted partner for accessible, efficient, and sustainable veterinary care. Book appointments, manage pet health, and shop for pet supplies—all in one platform. Revolutionizing pet care with convenience and care, one click at a time.</p>
                </div>

                <!-- Company Links -->
                <div class="col-md-6 col-lg-2 mb-4">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" style="color: #f8f9fa;">Home</a></li>
                        <li><a href="about.php" style="color: #f8f9fa;">About Us</a></li>
                        <li><a href="services.php" style="color: #f8f9fa;">Services</a></li>
                        <li><a href="products.php" style="color: #f8f9fa;">Products</a></li>
                        <li><a href="contact.php" style="color: #f8f9fa;">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="terms-&-condition.php" style="color: #f8f9fa;">Terms & Conditions</a></li>
                        <li><a href="privacy-policy.php" style="color: #f8f9fa;">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact Info + Subscribe -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <h5>Get in Touch</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone-alt me-2"></i>+971552834004</li>
                        <li><i class="fas fa-envelope me-2"></i>AK2805@live.mdx.ac.uk</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Dubai, UAE</li>
                    </ul>

                    <!-- Subscribe Box -->
                    <div class="subscribe-box p-3 mt-3" style="background-color: #007482; border-radius: 8px;">
                        <h6 class="text-white mb-3">Subscribe Now</h6>
                        <form action="subscribe.php" method="POST">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control mb-2" placeholder="Enter your email" required>
                            </div>
                            <button type="submit" name="subscribe" class="btn btn-light btn-sm btn-block font-weight-bold">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div style="background: linear-gradient(to right,#e97140 ,rgb(226, 147, 115)); color: #fff;" class="text-center py-3">
        <div class="container">
            <p class="mb-0" style="color:white">
                &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | Developed by Ahmed
            </p>
        </div>
    </div>

    <!-- Back to Top -->
    <div id="back-top">
        <a href="#" title="Back to Top" style="color: #fff;"><i class="fas fa-chevron-up"></i></a>
    </div>
</footer>

<!-- BotPress Integration -->
<?php 
// Include BotPress configuration
include_once 'botpress-config.php';

// Initialize BotPress on all pages
addBotPressToPage();
?>
