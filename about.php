<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>About Us - CureMyPet</title>
    <meta name="description" content="Learn about CureMyPet's mission, vision, and commitment to providing exceptional veterinary care for your beloved pets.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php include 'headlink.php'?>
    <!-- Ensure FontAwesome is loaded -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-orange: #e97140;
            --primary-orange-dark: #d6612d;
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
            background-color: var(--gray-50);
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
        }

        .hero-content p {
            font-size: 1.3rem;
            opacity: 0.95;
            margin-bottom: 0;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Mission & Vision Section */
        .mission-vision-section {
            padding: 80px 0;
            background: white;
        }

        .content-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-bottom: 40px;
            border-left: 5px solid var(--primary-orange);
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        }

        .content-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .content-card h3 i {
            color: var(--primary-orange);
            font-size: 2.5rem;
        }

        .content-card p {
            color: var(--gray-600);
            line-height: 1.8;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        /* Stats Section */
        .stats-section {
            background: #007582;
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        }

        .stats-content {
            position: relative;
            z-index: 2;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-icon {
            font-size: 4rem;
            color: var(--primary-orange);
            margin-bottom: 20px;
            display: block;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: white;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 500;
        }

        /* Commitment Section */
        .commitment-section {
            padding: 80px 0;
            background: var(--gray-50);
        }

        .commitment-content {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
        }

        .commitment-header {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 50px;
            text-align: center;
        }

        .commitment-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .commitment-header p {
            font-size: 1.2rem;
            opacity: 0.95;
            margin: 0;
        }

        .commitment-body {
            padding: 50px;
        }

        .commitment-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
            padding: 25px;
            background: var(--gray-50);
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .commitment-item:hover {
            transform: translateX(10px);
            background: #fef7f0;
        }

        .commitment-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white !important;
            flex-shrink: 0;
            min-width: 60px;
        }

        .commitment-icon i {
            color: white !important;
            font-size: 1.5rem;
            display: block;
        }

        .commitment-text h4 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 10px;
        }

        .commitment-text p {
            color: var(--gray-600);
            line-height: 1.6;
            margin: 0;
        }

        /* Team Section */
        .team-section {
            padding: 80px 0;
            background: white;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-subtitle {
            color: var(--primary-orange);
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .team-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            margin-bottom: 30px;
            border-top: 4px solid var(--primary-orange);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        }

        .team-image {
            height: 350px;
            overflow: hidden;
            position: relative;
            background: var(--gray-100);
            border-radius: 20px 20px 0 0;
        }

        .team-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            transition: transform 0.4s ease;
            display: block;
        }

        .team-card:hover .team-image img {
            transform: scale(1.05);
        }

        .team-content {
            padding: 30px 25px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .team-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .team-role {
            color: var(--primary-orange);
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        /* CTA Section */
        .cta-section {
            background: #007582;
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .cta-description {
            font-size: 1.2rem;
            opacity: 0.95;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-modern {
            background: white;
            color: var(--primary-orange);
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            margin: 0 10px;
        }

        .btn-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
            color: var(--primary-orange);
            text-decoration: none;
        }

        .btn-modern.secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-modern.secondary:hover {
            background: white;
            color: var(--primary-orange);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content p {
                font-size: 1.1rem;
            }
            
            .content-card {
                padding: 30px 25px;
            }
            
            .content-card h3 {
                font-size: 1.6rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .commitment-header {
                padding: 40px 30px;
            }
            
            .commitment-body {
                padding: 40px 30px;
            }
            
            .commitment-item {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .team-image {
                height: 300px;
            }
            
            .team-content {
                padding: 25px 20px;
            }
            
            .team-name {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .content-card h3 {
                flex-direction: column;
                gap: 10px;
            }
            
            .stat-card {
                padding: 30px 20px;
            }
            
            .cta-title {
                font-size: 2rem;
            }
            
            .team-image {
                height: 250px;
            }
            
            .team-content {
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>

<!-- Header -->
<?php include 'header.php' ?>
<!-- Header -->
    <main> 
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-content">
                            <h1 style="color: white;">About CureMyPet</h1>
                            <p style="color: white;">Your trusted partner in providing exceptional veterinary care and support for every pet and wildlife species we serve.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision Section -->
        <section class="mission-vision-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="content-card">
                            <h3><i class="fas fa-bullseye"></i>Our Mission</h3>
                            <p>To provide exceptional veterinary care and support, ensuring the health and well-being of every pet and wildlife species we serve. We focus on delivering high-quality care that addresses the individual needs of each animal, from routine check-ups to emergency treatments.</p>
                            <p>We are committed to offering compassionate, professional services, fostering a trusting relationship with our clients. Our team strives to create an environment where pets and wildlife receive the best possible care and attention.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="content-card">
                            <h3><i class="fas fa-eye"></i>Our Vision</h3>
                            <p>Our vision is to be a leading provider of innovative veterinary care, dedicated to advancing the health and well-being of pets and wildlife. We aim to integrate cutting-edge treatments and compassionate care into everything we do, ensuring the best outcomes for the animals we serve.</p>
                            <p>We strive to create a healthier future for all species through continuous learning, community engagement, and a commitment to excellence in veterinary practices. Our goal is to set new standards in the industry and be recognized as a trusted partner in animal healthcare.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="stats-content">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="stat-card">
                                <i class="fas fa-heart stat-icon"></i>
                                <div class="stat-number">500+</div>
                                <div class="stat-label">Happy Pets</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="stat-card">
                                <i class="fas fa-stethoscope stat-icon"></i>
                                <div class="stat-number">354</div>
                                <div class="stat-label">Successful Treatments</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="stat-card">
                                <i class="fas fa-user-md stat-icon"></i>
                                <div class="stat-number">25+</div>
                                <div class="stat-label">Expert Veterinarians</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="stat-card">
                                <i class="fas fa-clock stat-icon"></i>
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Emergency Care</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Commitment Section -->
        <section class="commitment-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="commitment-content">
                            <div class="commitment-header">
                                <h2 style="color: white;">We are committed to better service</h2>
                                <p style="color: white;">Our dedication to exceptional pet care drives everything we do, ensuring your beloved companions receive the highest quality treatment and attention.</p>
                            </div>
                            <div class="commitment-body">
                                <div class="commitment-item">
                                    <div class="commitment-icon">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <div class="commitment-text">
                                        <h4>Excellence in Care</h4>
                                        <p>We are committed to providing better service by ensuring the highest standards of care and attention. Our team strives to deliver exceptional results, offering tailored solutions to meet your needs with professionalism and dedication.</p>
                                    </div>
                                </div>
                                <div class="commitment-item">
                                    <div class="commitment-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="commitment-text">
                                        <h4>Compassionate Service</h4>
                                        <p>We continuously aim for excellence in every aspect of our service, ensuring that each client receives top-notch care and support. Our goal is to create lasting relationships built on trust and exceptional care.</p>
                                    </div>
                                </div>
                                <div class="commitment-item">
                                    <div class="commitment-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="commitment-text">
                                        <h4>Trusted Partnership</h4>
                                        <p>Your pet's health and happiness are our top priorities. We work closely with you to develop personalized care plans that ensure your companion receives the best possible treatment and attention.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team Section -->
        <section class="team-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-subtitle">Meet Our Experts</div>
                    <h2 class="section-title">Our Professional Team</h2>
                    <p class="section-description">Dedicated veterinary professionals committed to providing exceptional care for your beloved pets.</p>
                </div>
                
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="team-card">
                            <div class="team-image">
                                <img src="assets/img/gallery/doctor 1.png" alt="Dr. Mike Janathon">
                            </div>
                            <div class="team-content">
                                <h4 class="team-name">Dr. Mike Janathon</h4>
                                <p class="team-role">Senior Veterinarian</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="team-card">
                            <div class="team-image">
                                <img src="assets/img/gallery/doctor 2.png" alt="Dr. Mike J Smith">
                            </div>
                            <div class="team-content">
                                <h4 class="team-name">Dr. Mike J Smith</h4>
                                <p class="team-role">Emergency Care Specialist</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="team-card">
                            <div class="team-image">
                                <img src="assets/img/gallery/doctor 3.png" alt="Dr. Sarah Johnson">
                            </div>
                            <div class="team-content">
                                <h4 class="team-name">Dr. Sarah Johnson</h4>
                                <p class="team-role">Surgery Specialist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h2 class="cta-title">Ready to Give Your Pet the Best Care?</h2>
                            <p class="cta-description">Contact us today to schedule an appointment or learn more about our comprehensive veterinary services. Your pet's health and happiness are our top priorities.</p>
                            
                            <div style="display: flex; justify-content: center; gap: 20px; align-items: center; flex-wrap: wrap; margin-top: 40px;">
                                <a href="form.php" class="btn-modern">
                                    <i class="fas fa-calendar-check"></i>
                                    Schedule Appointment
                                </a>
                                
                                <a href="services.php" class="btn-modern secondary">
                                    <i class="fas fa-eye"></i>
                                    View Our Services
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
include 'footer.php';
?>
    
    <?php include 'footerlink.php'?>
        
    </body>
</html>