<?php
session_start();
include "connection.php";


if (!isset($_SESSION['user_id']) && !isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Thank You - CureMyPet</title>
    <meta name="description" content="Thank you for booking your appointment with CureMyPet. We'll contact you soon to confirm your booking.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo.png">

    <?php include 'headlink.php'?>
    <style>
        :root {
            --primary-orange: #e97140;
            --success-green: #10b981;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
        }

        body {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Main Section */
        .thank-you-section {
            padding: 120px 0;
            min-height: 70vh;
            display: flex;
            align-items: center;
            margin-top: 80px;
        }

        .thank-you-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--success-green) 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 40px;
            animation: successPulse 2s ease-in-out infinite;
            box-shadow: 0 20px 60px rgba(16, 185, 129, 0.3);
        }

        .success-icon i {
            font-size: 4rem;
            color: white;
        }

        @keyframes successPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 20px 60px rgba(16, 185, 129, 0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 25px 80px rgba(16, 185, 129, 0.4);
            }
        }

        .thank-you-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .thank-you-subtitle {
            font-size: 1.3rem;
            color: var(--success-green);
            font-weight: 600;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .thank-you-message {
            font-size: 1.2rem;
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 50px 0;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 4px solid var(--primary-orange);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        .info-card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .info-card-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .info-card h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 15px;
        }

        .info-card p {
            color: var(--gray-600);
            line-height: 1.5;
            margin: 0;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(233, 113, 64, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: white;
            color: var(--gray-700);
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 1rem;
            border: 2px solid var(--gray-100);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            color: var(--gray-700);
            text-decoration: none;
            border-color: var(--gray-200);
        }

        .contact-emergency {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 40px;
            text-align: center;
        }

        .contact-emergency h5 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: white;
        }

        .contact-emergency p {
            margin: 0;
            color: rgba(255,255,255,0.9);
        }

        .contact-emergency a {
            color: white;
            text-decoration: underline;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .thank-you-section {
                padding: 80px 20px;
            }
            
            .thank-you-title {
                font-size: 2.2rem;
            }
            
            .success-icon {
                width: 100px;
                height: 100px;
            }
            
            .success-icon i {
                font-size: 3rem;
            }
            
            .info-cards {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
        }

        /* Animation for content */
        .thank-you-container > * {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        .thank-you-container > *:nth-child(1) { animation-delay: 0.1s; }
        .thank-you-container > *:nth-child(2) { animation-delay: 0.2s; }
        .thank-you-container > *:nth-child(3) { animation-delay: 0.3s; }
        .thank-you-container > *:nth-child(4) { animation-delay: 0.4s; }
        .thank-you-container > *:nth-child(5) { animation-delay: 0.5s; }
        .thank-you-container > *:nth-child(6) { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'?>

    <main>
        <section class="thank-you-section">
            <div class="container">
                <div class="thank-you-container">
                    <!-- Success Icon -->
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>

                    <!-- Main Message -->
                    <div class="thank-you-subtitle">Appointment Requested</div>
                    <h1 class="thank-you-title">Thank You!</h1>
                    <p class="thank-you-message">
                        Your appointment request has been successfully submitted. Our veterinary team will review your request and contact you shortly to confirm the appointment details and schedule.
                    </p>

                    <!-- Information Cards -->
                    <div class="info-cards">
                        <div class="info-card">
                            <div class="info-card-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4>Response Time</h4>
                            <p>We'll contact you within 2-4 hours during business hours to confirm your appointment.</p>
                        </div>

                        <div class="info-card">
                            <div class="info-card-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h4>Confirmation Call</h4>
                            <p>Our team will call you on the provided number to discuss appointment details and timing.</p>
                        </div>

                        <div class="info-card">
                            <div class="info-card-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h4>Appointment Prep</h4>
                            <p>Please have your pet's medical history ready and arrive 10 minutes early for your visit.</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="index.php" class="btn-primary">
                            <i class="fas fa-home"></i>
                            Back to Home
                        </a>
                        <a href="services.php" class="btn-secondary">
                            <i class="fas fa-stethoscope"></i>
                            View Our Services
                        </a>
                        <a href="form.php" class="btn-secondary">
                            <i class="fas fa-plus"></i>
                            Book Another Appointment
                        </a>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="contact-emergency">
                        <h5><i class="fas fa-exclamation-triangle"></i> Need Emergency Care?</h5>
                        <p>For urgent pet emergencies, call our 24/7 hotline: <a href="tel:+971552834004">+971 55 2834004</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
    <?php include 'footerlink.php'?>

    <script>
        // Add confetti effect on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Simple confetti-like effect
            setTimeout(function() {
                const colors = ['#e97140', '#10b981', '#f97316', '#059669'];
                
                for (let i = 0; i < 50; i++) {
                    createConfetti(colors[Math.floor(Math.random() * colors.length)]);
                }
            }, 500);
        });

        function createConfetti(color) {
            const confetti = document.createElement('div');
            confetti.style.cssText = `
                position: fixed;
                width: 10px;
                height: 10px;
                background: ${color};
                top: -10px;
                left: ${Math.random() * 100}vw;
                border-radius: 50%;
                pointer-events: none;
                z-index: 1000;
                animation: confettiFall ${Math.random() * 3 + 2}s linear forwards;
            `;
            
            document.body.appendChild(confetti);
            
            // Remove confetti after animation
            setTimeout(() => {
                if (confetti.parentNode) {
                    confetti.parentNode.removeChild(confetti);
                }
            }, 5000);
        }

        // Add CSS animation for confetti
        const style = document.createElement('style');
        style.textContent = `
            @keyframes confettiFall {
                to {
                    transform: translateY(100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>