<?php
session_start();
include 'connection.php';

// Error reporting (for debugging, optional — remove on live production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle form submission
if (isset($_POST['btn'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Insert using prepared statement
    $stmt = $con->prepare("INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Thanks for contacting us!";
        header("Location: contact.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: contact.php");
        exit();
    }

    $stmt->close();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Us</title>
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
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0,0,0,0.2);
            color: white;
        }

        .hero-content p {
            font-size: 1.3rem;
            opacity: 0.95;
            margin-bottom: 0;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            color: white;
        }

        /* Contact Section */
        .contact-section {
            padding: 80px 0;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Alert Styling */
        .alert {
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            margin-bottom: 0;
            font-weight: 600;
            text-align: center;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: slideDown 0.5s ease;
        }

        .alert-success {
            background: linear-gradient(135deg, var(--success-green) 0%, #059669 100%);
            color: white;
        }

        .alert-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
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

        /* Form Section */
        .form-card {
            background: white;
            border-radius: 25px;
            padding: 50px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.15);
            border-top: 5px solid var(--primary-orange);
            margin-bottom: 40px;
        }

        .form-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 15px;
        }

        .form-subtitle {
            text-align: center;
            color: var(--gray-600);
            font-size: 1.1rem;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            display: block;
            font-size: 1rem;
        }

        .form-label i {
            color: var(--primary-orange);
            margin-right: 8px;
            width: 16px;
        }

        .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 18px 25px;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            box-sizing: border-box;
            margin-bottom: 25px;
        }

        .form-control:focus {
            outline: none;
            border-color: #e97140;
            box-shadow: 0 0 0 4px rgba(233, 113, 64, 0.15);
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6;
        }

        .btn-submit {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            color: white;
            padding: 18px 40px;
            font-size: 1.1rem;
            font-weight: 700;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 12px 35px rgba(233, 113, 64, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 45px rgba(233, 113, 64, 0.4);
            background: linear-gradient(135deg, #d6612d 0%, #ea580c 100%);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        /* Contact Info Cards */
        .contact-info {
            display: grid;
            gap: 30px;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s ease;
            border-top: 4px solid var(--teal-color);
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 70px rgba(0,0,0,0.15);
        }

        .contact-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--teal-color) 0%, #065f65 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 117, 130, 0.3);
        }

        .contact-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 10px;
        }

        .contact-card p {
            color: var(--gray-600);
            line-height: 1.6;
            margin: 5px 0;
        }

        .contact-card .highlight {
            color: var(--teal-color);
            font-weight: 600;
        }

        /* Emergency Banner */
        .emergency-banner {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 40px;
            text-align: center;
        }

        .emergency-banner h5 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: white;
        }

        .emergency-banner p {
            margin: 0;
            font-size: 1.1rem;
            color: rgba(255,255,255,0.95);
        }

        .emergency-banner a {
            color: white;
            text-decoration: underline;
            font-weight: 700;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content p {
                font-size: 1.1rem;
            }
            
            .form-card {
                padding: 30px 25px;
                margin: 0 15px 40px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .contact-info {
                margin-top: 40px;
            }
        }

        @media (max-width: 576px) {
            .form-title {
                font-size: 2rem;
            }
            
            .contact-section {
                padding: 60px 0;
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
                            <h1>Contact Us</h1>
                            <p>Get in touch with our expert veterinary team for any questions, appointment inquiries, or pet care support. We're here to help you and your beloved pets.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <div class="contact-container">
                <div class="row">
                    <!-- Contact Form -->
                    <div class="col-lg-8">
                        <div class="form-card">
                            <h2 class="form-title">Get in Touch</h2>
                            <p class="form-subtitle">Have a question or need assistance? Fill out the form below and our team will get back to you as soon as possible.</p>

                            <form method="POST" action="">
                                <label class="form-label">Your Message</label>
                                <textarea name="message" rows="5" class="form-control" placeholder="Enter your message" required></textarea>

                                <label class="form-label">Your Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>

                                <label class="form-label">Your Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>

                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" placeholder="Enter subject" required>

                                <div style="text-align: center;">
                                    <button type="submit" name="btn" class="btn-submit">Send</button>
                                </div>
                            </form>

                            <!-- Alert Messages Below Form -->
                            <?php
                            if (isset($_SESSION['success'])) {
                                echo "<div class='alert alert-success'><i class='fas fa-check-circle'></i> {$_SESSION['success']}</div>";
                                unset($_SESSION['success']);
                            } elseif (isset($_SESSION['error'])) {
                                echo "<div class='alert alert-error'><i class='fas fa-exclamation-triangle'></i> {$_SESSION['error']}</div>";
                                unset($_SESSION['error']);
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-lg-4">
                        <div class="contact-info">
                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h4>Our Location</h4>
                                <p class="highlight">Dubai, UAE</p>
                                <p>Cluster C, JLT</p>
                            </div>

                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h4>Call Us</h4>
                                <p class="highlight">+971552834004</p>
                                <p>Mon to Fri 9am to 6pm</p>
                            </div>

                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h4>Email Us</h4>
                                <p class="highlight">support@curemypet.site</p>
                                <p>We'll respond within 24 hours</p>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="emergency-banner">
                            <h5><i class="fas fa-exclamation-triangle"></i> Emergency Care</h5>
                            <p>For urgent pet emergencies, call our 24/7 hotline: <a href="tel:+971552834004">+971 55 2834004</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
    <?php include 'footerlink.php'; ?>

    <script>
        // Form enhancement and validation
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const name = document.querySelector('input[name="name"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();
            const subject = document.querySelector('input[name="subject"]').value.trim();
            const message = document.querySelector('textarea[name="message"]').value.trim();
            
            if (!name || !email || !subject || !message) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
            
            if (name.length < 2) {
                e.preventDefault();
                alert('Please enter your full name.');
                return false;
            }
            
            if (subject.length < 5) {
                e.preventDefault();
                alert('Please provide a more descriptive subject.');
                return false;
            }
            
            if (message.length < 10) {
                e.preventDefault();
                alert('Please provide more details in your message.');
                return false;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('.btn-submit');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending Message...';
            submitBtn.disabled = true;
        });

        // Form field enhancements
        document.querySelectorAll('.form-control').forEach(field => {
            field.addEventListener('focus', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            field.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Character counter for message
        const messageTextarea = document.querySelector('textarea[name="message"]');
        messageTextarea.addEventListener('input', function() {
            const length = this.value.length;
            const maxLength = 1000;
            
            let counter = this.parentNode.querySelector('.char-counter');
            if (!counter) {
                counter = document.createElement('div');
                counter.className = 'char-counter';
                counter.style.cssText = `
                    font-size: 0.85rem;
                    color: var(--gray-500);
                    text-align: right;
                    margin-top: 5px;
                `;
                this.parentNode.appendChild(counter);
            }
            
            counter.textContent = `${length}/${maxLength} characters`;
            
            if (length > maxLength * 0.9) {
                counter.style.color = '#ef4444';
            } else {
                counter.style.color = 'var(--gray-500)';
            }
        });
    </script>
</body>
</html>
