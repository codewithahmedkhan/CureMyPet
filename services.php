<?php
session_start();
include "connection.php"
?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Our Services - CureMyPet</title>
    <meta name="description" content="Professional pet care services including veterinary care, grooming, boarding, and more. Quality care for your beloved pets.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'?>
    <link rel="stylesheet" href="assets/css/services-style.css">
    <style>
        body {
            background-color: var(--gray-50);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 100px 0 80px;
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
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            color: white;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Call to Action Section */
        .cta-section {
            background: #007582;
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        }

        .cta-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .cta-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .cta-description {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-primary-cta {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .btn-primary-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(233, 113, 64, 0.4);
            color: white;
            text-decoration: none;
        }

        .phone-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }

        .phone-info a {
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 600;
        }

        .phone-info a:hover {
            color: #f97316;
        }

        /* Emergency Banner */
        .emergency-banner {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white;
            padding: 20px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .emergency-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .emergency-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            font-weight: 600;
        }

        .emergency-icon {
            font-size: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content p {
                font-size: 1.1rem;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: 30px;
            }
            
            .cta-buttons {
                flex-direction: column;
                gap: 15px;
            }
            
            .emergency-content {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .cta-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'?>
    
    <main> 
       
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-content text-center">
                            <h1>Our Professional Services</h1>
                            <p>Comprehensive pet care services designed to keep your beloved companions healthy, happy, and thriving throughout their lives.</p>
                            
                            <div class="hero-stats">
                                <div class="stat-item">
                                    <span class="stat-number">500+</span>
                                    <span class="stat-label">Happy Pets</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">50+</span>
                                    <span class="stat-label">Expert Staff</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">24/7</span>
                                    <span class="stat-label">Emergency Care</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-subtitle">What We Offer</div>
                    <h2 class="section-title">Best Pet Care Services</h2>
                    <p class="section-description">From routine check-ups to emergency care, we provide comprehensive veterinary services to ensure your pet's optimal health and wellbeing.</p>
                </div>

                <?php
                include 'connection.php';
                $query = mysqli_query($con, "SELECT * FROM services");
                ?>

                <div class="row services-row">
                    <?php 
                    $serviceIcons = [
                        'fas fa-stethoscope',
                        'fas fa-cut',
                        'fas fa-home',
                        'fas fa-syringe',
                        'fas fa-tooth',
                        'fas fa-paw',
                        'fas fa-heart',
                        'fas fa-shield-alt',
                        'fas fa-user-md'
                    ];
                    $iconIndex = 0;
                    
                    while ($row = mysqli_fetch_assoc($query)) { 
                        $currentIcon = $serviceIcons[$iconIndex % count($serviceIcons)];
                        $iconIndex++;
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 service-col">
                            <div class="service-card">
                                <div class="service-image-container">
                                    <?php
                                    $imagePath = 'dashboard/service_image/'.$row['img'];
                                    if (!empty($row['img']) && file_exists($imagePath)) {
                                        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['servicename']) . '" class="service-image">';
                                    } else {
                                        echo '<div class="service-image" style="background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%); display: flex; align-items: center; justify-content: center; color: var(--gray-500); font-size: 3rem;"><i class="fas fa-image"></i></div>';
                                    }
                                    ?>
                                    <div class="service-overlay">
                                        <i class="<?php echo $currentIcon; ?> service-icon"></i>
                                    </div>
                                </div>
                                
                                <div class="service-content">
                                    <h3 class="service-title">
                                        <a href="form.php"><?php echo htmlspecialchars($row['servicename']); ?></a>
                                    </h3>
                                    
                                    <p class="service-description">
                                        <?php 
                                        $description = htmlspecialchars($row['servicedesc']);
                                        echo strlen($description) > 80 ? substr($description, 0, 80) . '...' : $description;
                                        ?>
                                    </p>

                                    <ul class="service-features">
                                        <li><i class="fas fa-check"></i> Professional Care</li>
                                        <li><i class="fas fa-check"></i> Experienced Staff</li>
                                        <li><i class="fas fa-check"></i> Modern Equipment</li>
                                    </ul>

                                    <a href="form.php" class="service-cta">
                                        <i class="fas fa-calendar-alt"></i>
                                        Book Appointment
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php if (mysqli_num_rows($query) == 0): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center" style="padding: 60px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
                                <i class="fas fa-info-circle" style="font-size: 4rem; color: var(--gray-400); margin-bottom: 20px;"></i>
                                <h3 style="color: var(--gray-600); margin-bottom: 15px;">No Services Available</h3>
                                <p style="color: var(--gray-500);">We're currently updating our services. Please check back soon or contact us for more information.</p>
                                <a href="contact.php" class="btn-primary-cta" style="margin-top: 20px;">
                                    <i class="fas fa-phone"></i>
                                    Contact Us
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2 class="cta-title">Ready to Give Your Pet the Best Care?</h2>
                    <p class="cta-description">Our experienced veterinary team is here to provide exceptional care for your beloved companions. Contact us today to schedule an appointment or learn more about our services.</p>
                    
                    <div class="cta-buttons">
                        <a href="form.php" class="btn-primary-cta">
                            <i class="fas fa-calendar-check"></i>
                            Schedule Appointment
                        </a>
                        
                        <div class="phone-info">
                            <span>Or call us at</span>
                            <a href="tel:+971552834004">+971552834004</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
    <?php include 'footerlink.php'; ?>
        
</body>
</html>