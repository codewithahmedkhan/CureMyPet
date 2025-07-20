<?php
session_start();
include 'admin_login_check.php'; // Optional: remove if public
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions - CureMyPet</title>
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
            border-top: 5px solid var(--primary-orange);
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
            background: var(--primary-orange);
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
            content: '✓';
            color: var(--primary-orange);
            font-weight: bold;
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
            border-left: 4px solid var(--teal-color);
            margin-bottom: 40px;
        }

        .contact-info {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
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
                        <h1>Terms and Conditions</h1>
                        <p>Understanding the guidelines that govern our pet care services and your rights as a valued customer.</p>
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
                    Welcome to CureMyPet's Online Pet Appointment System. By accessing or using our website and services, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, please do not use our services.
                </div>

                <h2>1. Introduction</h2>
                <p>These terms govern your use of our online platform. Continued usage indicates your agreement to abide by them fully.</p>

                <h2>2. Eligibility</h2>
                <p>You must be at least 18 years of age to use our services. By using the system, you confirm you meet this requirement.</p>

                <h2>3. Services Provided</h2>
                <p>We offer tools for booking pet appointments, managing pet data, and communicating with veterinary professionals. We do not provide emergency or diagnostic services directly.</p>

                <h2>4. User Responsibilities</h2>
                <p>By using our platform, you agree to:</p>
                <ul>
                    <li>Provide accurate and complete information</li>
                    <li>Use the system lawfully and respectfully</li>
                    <li>Not engage in malicious or harmful behavior</li>
                    <li>Maintain confidentiality of your login credentials</li>
                </ul>

                <h2>5. Appointment Policy</h2>
                <p>All appointments made are subject to availability and confirmation. Users are expected to cancel or reschedule with reasonable notice (ideally 24 hours in advance).</p>

                <h2>6. Payment and Fees</h2>
                <p>Certain services may require fees, which will be disclosed prior to checkout. Payments are processed via trusted third-party providers, and we are not liable for external transaction issues.</p>

                <h2>7. Account Security</h2>
                <p>You are responsible for keeping your account details secure. Any unauthorized use should be reported immediately. We may suspend accounts involved in suspicious or harmful activity.</p>

                <h2>8. Intellectual Property</h2>
                <p>All website content—including text, design, images, and software—is the property of our company or our partners. Unauthorized use is strictly prohibited.</p>

                <h2>9. Limitation of Liability</h2>
                <p>While we strive to keep our system reliable and secure, we are not responsible for interruptions, errors, or losses resulting from your use of the platform.</p>

                <h2>10. Third-Party Links and Services</h2>
                <p>Our system may contain links to external websites. We are not liable for the content or behavior of these third-party services.</p>

                <h2>11. Termination</h2>
                <p>We reserve the right to terminate or suspend user accounts for violations of these terms or for behavior deemed harmful to others or our platform.</p>

                <h2>12. Changes to Terms</h2>
                <p>We may update these terms periodically. Continued use after updates means you accept the revised terms. Please review them regularly.</p>

                <h2>13. Governing Law</h2>
                <p>These Terms and Conditions are governed by the laws of your jurisdiction. Any legal disputes will be resolved in the applicable courts.</p>

                <div class="contact-info">
                    <h2>14. Contact Us</h2>
                    <p>If you have questions regarding these Terms and Conditions, please contact us at:</p>
                    <p><strong>Email:</strong> legal@curemypet.site<br><strong>Phone:</strong> +971 55 2834004</p>
                </div>

                <div class="last-updated">
                    <strong>Last updated:</strong> January 8, 2025
                </div>
            </div>
        </div>
    </section>

    <?php include "footer.php"?>
    <?php include 'footerlink.php'?>

    <!--<script src="//code.tidio.co/95fdjazoyvznbcbfdqyxwtoxaicvq7ae.js" async></script>-->
</body>
</html>
