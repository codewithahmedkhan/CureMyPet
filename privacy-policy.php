<?php
session_start();
include 'admin_login_check.php'; // Optional: remove if public
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - CureMyPet</title>
    <?php include 'headlink.php'?>
    <style>
        :root {
            --primary-orange: #e97140;
            --primary-orange-dark: #d6612d;
            --teal-color: #007582;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        body {
            background: var(--gray-50);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--teal-color) 0%, #16a085 100%);
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
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
            font-size: 1.2rem;
            opacity: 0.95;
            margin: 0;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Content Section */
        .content-section {
            padding: 80px 0;
        }

        .content-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 25px;
            padding: 60px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.1);
            border-top: 5px solid var(--teal-color);
        }

        .content-wrapper h2 {
            color: var(--gray-800);
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 40px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--gray-200);
            position: relative;
        }

        .content-wrapper h2::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--teal-color);
        }

        .content-wrapper h2:first-of-type {
            margin-top: 0;
        }

        .content-wrapper p {
            color: var(--gray-600);
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .content-wrapper ul {
            color: var(--gray-600);
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 20px;
            padding-left: 0;
        }

        .content-wrapper li {
            margin-bottom: 8px;
            padding-left: 30px;
            position: relative;
        }

        .content-wrapper li::before {
            content: '🔒';
            position: absolute;
            left: 0;
            top: 0;
        }

        .intro-text {
            font-size: 1.2rem;
            color: var(--gray-700);
            background: var(--gray-50);
            padding: 30px;
            border-radius: 15px;
            border-left: 4px solid var(--primary-orange);
            margin-bottom: 40px;
        }

        .contact-info {
            background: linear-gradient(135deg, var(--teal-color) 0%, #16a085 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
        }

        .contact-info h2 {
            color: white;
            border-bottom: 2px solid rgba(255,255,255,0.3);
            margin-top: 0;
        }

        .contact-info h2::before {
            background: white;
        }

        .contact-info p {
            color: rgba(255,255,255,0.95);
            margin-bottom: 15px;
        }

        .last-updated {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--gray-200);
            color: var(--gray-500);
            font-style: italic;
        }

        .privacy-highlight {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid #a7f3d0;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .privacy-highlight .icon {
            font-size: 2rem;
            color: #059669;
        }

        .privacy-highlight .content {
            flex: 1;
        }

        .privacy-highlight h3 {
            color: #065f46;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .privacy-highlight p {
            color: #047857;
            margin: 0;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .content-wrapper {
                padding: 40px 30px;
                margin: 0 20px;
            }
            
            .hero-content p {
                font-size: 1rem;
            }

            .privacy-highlight {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-content">
                        <h1>Privacy Policy</h1>
                        <p>Your privacy matters to us. Learn how we collect, use, and protect your personal information.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="content-wrapper">
                <div class="intro-text">
                    Welcome to CureMyPet's online pet appointment system. Your privacy is very important to us. This Privacy Policy explains how we collect, use, and protect your information when using our website and services.
                </div>

                <div class="privacy-highlight">
                    <div class="icon">🛡️</div>
                    <div class="content">
                        <h3>Your Data is Safe</h3>
                        <p>We use industry-standard encryption and security measures to protect your personal information and ensure your privacy.</p>
                    </div>
                </div>

                <h2>1. Information We Collect</h2>
                <p>We may collect the following types of information:</p>
                <ul>
                    <li>Personal information: Name, contact details, email, address</li>
                    <li>Pet information: Name, breed, medical details</li>
                    <li>Technical data: IP address, browser type, usage data</li>
                </ul>

                <h2>2. How We Use Your Information</h2>
                <p>Your data is used to manage appointments, send reminders, improve our services, and comply with legal obligations. We process your information to provide you with the best possible pet care experience.</p>

                <h2>3. Data Sharing</h2>
                <p>We do not sell your data. We only share it with veterinarians and necessary service providers under strict confidentiality agreements. Your information is shared only when required to provide you with our services.</p>

                <h2>4. Data Security</h2>
                <p>We use encryption, secure servers, and limited access protocols to protect your information. Our security measures are regularly updated to ensure the highest level of protection for your data.</p>

                <h2>5. Cookies</h2>
                <p>We use cookies to personalize your experience and analyze traffic. You can disable cookies in your browser settings, though this may affect some functionality of our website.</p>

                <h2>6. Your Rights</h2>
                <p>You have the right to:</p>
                <ul>
                    <li>Request access to your personal data</li>
                    <li>Request correction of inaccurate data</li>
                    <li>Request deletion of your data</li>
                    <li>Request data portability</li>
                </ul>

                <h2>7. Policy Updates</h2>
                <p>This Privacy Policy may change from time to time. Updates will be posted here with the latest revision date. We encourage you to review this policy regularly.</p>

                <div class="contact-info">
                    <h2>8. Contact Us</h2>
                    <p>If you have any questions about this Privacy Policy, please contact us at:</p>
                    <p><strong>Email:</strong> privacy@curemypet.site<br><strong>Phone:</strong> +971 55 2834004</p>
                </div>

                <div class="last-updated">
                    <strong>Last updated:</strong> January 8, 2025
                </div>
            </div>
        </div>
    </section>

 <?php include "footer.php"?>

    <!-- JS here -->
        <?php include 'footerlink.php'?>

        <!--<script src="//code.tidio.co/95fdjazoyvznbcbfdqyxwtoxaicvq7ae.js" async></script>-->
</body>
</html>
