<?php
session_start();
include 'connection.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Education Center - CureMyPet</title>
    <meta name="description" content="Learn about pet health and care through our educational videos and articles">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <?php include 'headlink.php'; ?>
    
    <style>
        :root {
            --primary-orange: #e97140;
            --gray-700: #374151;
            --gray-300: #d1d5db;
        }
        
        .education-hero {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 180px 0 100px;
            margin-top: 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .education-hero::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,213.3C1248,235,1344,213,1392,202.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') repeat-x;
            bottom: -1px;
            left: 0;
            animation: wave 20s linear infinite;
        }
        
        @keyframes wave {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        .education-hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease;
            color: white;
        }
        
        .education-hero p {
            font-size: 1.3rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto 2rem;
            animation: fadeInUp 1s ease 0.2s both;
            color: white;
        }
        
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
            animation: fadeInUp 1.2s ease 0.4s both;
        }
        
        .hero-stat {
            text-align: center;
        }
        
        .hero-stat h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }
        
        .hero-stat p {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
            color: white;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .section-padding {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--gray-700);
            margin-bottom: 1rem;
        }
        
        .section-title p {
            font-size: 1.1rem;
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .education-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 30px;
            position: relative;
        }
        
        .education-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-orange), #f97316);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }
        
        .education-card:hover::before {
            transform: scaleX(1);
        }
        
        .education-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 40px rgba(233, 113, 64, 0.15);
        }
        
        .education-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .education-card:hover img {
            transform: scale(1.1);
        }
        
        .education-card-content {
            padding: 30px;
        }
        
        .education-card h3 {
            font-size: 1.4rem;
            color: var(--gray-700);
            margin-bottom: 15px;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .education-card:hover h3 {
            color: var(--primary-orange);
        }
        
        .education-card p {
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 20px;
        }
        
        .read-more-btn {
            color: var(--primary-orange);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: gap 0.3s ease;
        }
        
        .read-more-btn:hover {
            gap: 10px;
        }
        
        .read-more-btn::after {
            content: '→';
            font-size: 1.2rem;
        }
        
        .education-badge {
            display: inline-block;
            background: var(--primary-orange);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .video-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
        }
        
        .video-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .video-card:hover::before {
            background: rgba(0, 0, 0, 0.1);
        }
        
        .video-play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 70px;
            height: 70px;
            background: var(--primary-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .video-play-btn:hover {
            transform: translate(-50%, -50%) scale(1.1);
        }
        
        .video-play-btn::after {
            content: '';
            width: 0;
            height: 0;
            border-left: 15px solid white;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            margin-left: 3px;
        }
        
        .category-filter {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .filter-btn {
            background: white;
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
            padding: 12px 30px;
            border-radius: 30px;
            margin: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .filter-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: var(--primary-orange);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.5s ease;
        }
        
        .filter-btn:hover::before,
        .filter-btn.active::before {
            width: 300px;
            height: 300px;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            color: white;
            border-color: var(--primary-orange);
            position: relative;
            z-index: 1;
        }
        
        .filter-btn span {
            position: relative;
            z-index: 2;
        }
        
        .search-section {
            background: linear-gradient(135deg, #f8fafc 0%, #fff5f0 100%);
            padding: 40px 0;
            margin-bottom: 60px;
            border-radius: 20px;
        }
        
        .search-box {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 20px 60px 20px 25px;
            border: 2px solid transparent;
            border-radius: 15px;
            font-size: 1.1rem;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 5px 30px rgba(233, 113, 64, 0.1);
        }
        
        .search-box button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-orange);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-box button:hover {
            background: #d6612d;
        }
        
        .featured-section {
            background: white;
            padding: 80px 0;
            position: relative;
        }
        
        .featured-badge {
            background: #10b981;
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .featured-content {
            background: linear-gradient(135deg, #f8fafc 0%, #fff5f0 100%);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .newsletter-section {
            background: linear-gradient(135deg, #f8fafc 0%, #fff5f0 100%);
            padding: 60px 0;
            text-align: center;
        }
        
        .newsletter-form {
            max-width: 400px;
            margin: 0 auto;
            display: flex;
            gap: 10px;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 15px;
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .newsletter-form button {
            background: var(--primary-orange);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .newsletter-form button:hover {
            background: #d6612d;
        }
        
        @media (max-width: 768px) {
            .education-hero {
                padding: 150px 0 80px;
                margin-top: 70px;
            }
            
            .education-hero h1 {
                font-size: 2.2rem;
            }
            
            .hero-stats {
                gap: 2rem;
                flex-wrap: wrap;
            }
            
            .hero-stat h3 {
                font-size: 2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .newsletter-form {
                flex-direction: column;
                gap: 15px;
            }
            
            .category-filter {
                text-align: left;
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 10px;
            }
            
            .filter-btn {
                display: inline-block;
                margin: 5px 8px 5px 0;
            }
            
            .search-box input {
                padding: 18px 55px 18px 20px;
                font-size: 1rem;
            }
            
            .featured-content {
                padding: 30px 25px;
            }
            
            .education-card-content {
                padding: 25px 20px;
            }
            
            .accordion-button {
                padding: 15px 20px !important;
                font-size: 0.95rem;
            }
            
            .accordion-body {
                padding: 15px 20px !important;
            }
        }
        
        @media (max-width: 576px) {
            .education-hero {
                padding: 130px 0 60px;
                margin-top: 60px;
            }
            
            .education-hero h1 {
                font-size: 1.8rem;
            }
            
            .education-hero p {
                font-size: 1.1rem;
            }
            
            .hero-stats {
                gap: 1.5rem;
            }
            
            .hero-stat h3 {
                font-size: 1.8rem;
            }
            
            .search-section {
                padding: 30px 15px;
            }
            
            .filter-btn span {
                font-size: 0.85rem;
            }
        }

        /* FAQ Section Styles */
        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background: white;
            border-radius: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 15px 45px rgba(0,0,0,0.15);
            transform: translateY(-5px);
        }

        .faq-question {
            padding: 25px 30px;
            display: flex;
            align-items: center;
            cursor: pointer;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            background: #f8fafc;
        }

        .faq-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .faq-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .faq-question h3 {
            flex: 1;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
        }

        .faq-toggle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .faq-toggle i {
            color: #6b7280;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .faq-item.active .faq-toggle {
            background: #e97140;
            transform: rotate(45deg);
        }

        .faq-item.active .faq-toggle i {
            color: white;
        }

        .faq-answer {
            padding: 0 30px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
            padding: 0 30px 25px 30px;
        }

        .faq-answer p {
            margin: 0;
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .faq-question {
                padding: 20px;
            }
            
            .faq-icon {
                width: 40px;
                height: 40px;
                margin-right: 15px;
            }
            
            .faq-question h3 {
                font-size: 1.1rem;
            }
            
            .faq-item.active .faq-answer {
                padding: 0 20px 20px 20px;
            }
        }
        
        /* Video Modal Styles */
        .video-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .video-modal.active {
            display: flex;
        }
        
        .video-modal-content {
            position: relative;
            width: 90%;
            max-width: 900px;
            background: #000;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .video-modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: none;
            border: none;
            padding: 10px;
            z-index: 10;
        }
        
        .video-modal-close:hover {
            color: var(--primary-orange);
        }
        
        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
        }
        
        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Education Hero Section -->
    <section class="education-hero">
        <div class="container">
            <h1>Pet Care Education Center</h1>
            <p>Empowering pet owners with expert knowledge, practical tips, and comprehensive guides to ensure the health and happiness of your beloved companions.</p>
            
            <div class="hero-stats">
                <div class="hero-stat">
                    <h3>50+</h3>
                    <p>Expert Articles</p>
                </div>
                <div class="hero-stat">
                    <h3>30+</h3>
                    <p>Video Tutorials</p>
                </div>
                <div class="hero-stat">
                    <h3>15+</h3>
                    <p>Care Guides</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="section-padding">
        <div class="container">
            <div class="search-section">
                <h2 style="text-align: center; color: var(--gray-700); margin-bottom: 2rem;">What would you like to learn today?</h2>
                <div class="search-box">
                    <input type="text" placeholder="Search for pet care topics, health tips, or guides...">
                    <button><i class="fas fa-search"></i></button>
                </div>
            </div>
            
            <div class="category-filter">
                <button class="filter-btn active" data-category="all"><span>All Topics</span></button>
                <button class="filter-btn" data-category="health"><span>🏥 Pet Health</span></button>
                <button class="filter-btn" data-category="nutrition"><span>🥘 Nutrition</span></button>
                <button class="filter-btn" data-category="behavior"><span>🐕 Behavior</span></button>
                <button class="filter-btn" data-category="grooming"><span>✂️ Grooming</span></button>
                <button class="filter-btn" data-category="emergency"><span>🚨 Emergency Care</span></button>
            </div>

            <!-- Educational Videos Section -->
            <div class="section-title">
                <h2>Educational Videos</h2>
                <p>Watch our expert veterinarians share valuable insights about pet care</p>
            </div>

            <!-- Featured Content -->
            <div class="featured-section" style="margin: 60px 0;">
                <div class="featured-content">
                    <span class="featured-badge">🌟 Featured Guide</span>
                    <h2 style="color: var(--gray-700); margin-bottom: 1rem;">Complete Pet Vaccination Schedule</h2>
                    <p style="color: #6b7280; margin-bottom: 2rem;">Understanding when and why your pet needs vaccinations is crucial for their long-term health. This comprehensive guide covers everything you need to know.</p>
                    <a href="#" class="read-more-btn">Read Complete Guide</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6" data-category="health">
                    <div class="education-card">
                        <div class="video-card" data-video-id="1MzSR1IeJ3g">
                            <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=400&h=220&fit=crop" alt="Pet Health Basics">
                            <div class="video-play-btn"></div>
                        </div>
                        <div class="education-card-content">
                            <span class="education-badge">Health</span>
                            <h3>Essential Pet Health Checkups</h3>
                            <p>Learn about routine health checkups and what to expect during your pet's veterinary visits.</p>
                            <a href="#" class="read-more-btn play-video-btn" data-video-id="1MzSR1IeJ3g">Watch Video</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-category="nutrition">
                    <div class="education-card">
                        <div class="video-card" data-video-id="-QrxnA7dQ3k">
                            <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=400&h=220&fit=crop" alt="Pet Nutrition">
                            <div class="video-play-btn"></div>
                        </div>
                        <div class="education-card-content">
                            <span class="education-badge">Nutrition</span>
                            <h3>Proper Pet Nutrition Guide</h3>
                            <p>Discover the right nutrition for your pet's age, size, and health condition.</p>
                            <a href="#" class="read-more-btn play-video-btn" data-video-id="-QrxnA7dQ3k">Watch Video</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-category="emergency">
                    <div class="education-card">
                        <div class="video-card" data-video-id="eOY_qUSw2WA">
                            <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=400&h=220&fit=crop" alt="Emergency Care">
                            <div class="video-play-btn"></div>
                        </div>
                        <div class="education-card-content">
                            <span class="education-badge">Emergency</span>
                            <h3>Pet First Aid Basics</h3>
                            <p>Essential first aid techniques every pet owner should know for emergency situations.</p>
                            <a href="#" class="read-more-btn play-video-btn" data-video-id="eOY_qUSw2WA">Watch Video</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Educational Articles Section -->
    <section class="section-padding" style="background: #f8fafc;">
        <div class="container">
            <div class="section-title">
                <h2>Health & Care Articles</h2>
                <p>Read comprehensive guides written by our veterinary experts</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6" data-category="behavior">
                    <div class="education-card">
                        <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=400&h=200&fit=crop" alt="Pet Behavior">
                        <div class="education-card-content">
                            <span class="education-badge">Behavior</span>
                            <h3>Understanding Pet Behavior</h3>
                            <p>Learn to read your pet's body language and understand common behavioral patterns and what they mean.</p>
                            <a href="#" class="read-more-btn">Read Article</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-category="grooming">
                    <div class="education-card">
                        <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=400&h=200&fit=crop" alt="Pet Grooming">
                        <div class="education-card-content">
                            <span class="education-badge">Grooming</span>
                            <h3>Home Grooming Tips</h3>
                            <p>Step-by-step guide to grooming your pet at home, including brushing, bathing, and nail care.</p>
                            <a href="#" class="read-more-btn">Read Article</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-category="health">
                    <div class="education-card">
                        <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400&h=200&fit=crop" alt="Preventive Care">
                        <div class="education-card-content">
                            <span class="education-badge">Health</span>
                            <h3>Preventive Care Guidelines</h3>
                            <p>Essential preventive care measures to keep your pet healthy and prevent common diseases.</p>
                            <a href="#" class="read-more-btn">Read Article</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-category="nutrition">
                    <div class="education-card">
                        <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=400&h=200&fit=crop" alt="Pet Diet">
                        <div class="education-card-content">
                            <span class="education-badge">Nutrition</span>
                            <h3>Age-Appropriate Diets</h3>
                            <p>Nutritional needs change as pets age. Learn what to feed your pet at different life stages.</p>
                            <a href="#" class="read-more-btn">Read Article</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-category="health">
                    <div class="education-card">
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=400&h=200&fit=crop" alt="Vaccination">
                        <div class="education-card-content">
                            <span class="education-badge">Health</span>
                            <h3>Vaccination Schedule</h3>
                            <p>Complete guide to pet vaccinations and why they're crucial for your pet's health.</p>
                            <a href="#" class="read-more-btn">Read Article</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-category="emergency">
                    <div class="education-card">
                        <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=400&h=200&fit=crop" alt="Emergency Signs">
                        <div class="education-card-content">
                            <span class="education-badge">Emergency</span>
                            <h3>Warning Signs to Watch</h3>
                            <p>Recognize early warning signs that indicate your pet needs immediate veterinary attention.</p>
                            <a href="#" class="read-more-btn">Read Article</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section" style="padding: 80px 0; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container">
            <div class="section-title text-center" style="margin-bottom: 60px;">
                <div style="color: #e97140; font-weight: 600; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Got Questions?</div>
                <h2 style="font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 20px;">Frequently Asked Questions</h2>
                <p style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">Find answers to common pet care questions from our expert veterinary team</p>
            </div>
            
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="faq-container">
                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <h3>How often should I take my pet to the vet?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>Adult pets should visit the vet at least once a year for routine checkups. Puppies and kittens need more frequent visits for vaccinations and monitoring. Senior pets (7+ years) should visit twice yearly to catch age-related health issues early.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h3>What vaccinations does my pet need?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>Core vaccines for dogs include DHPP (distemper, hepatitis, parainfluenza, parvovirus) and rabies. Cats need FVRCP (feline viral rhinotracheitis, calicivirus, panleukopenia) and rabies. Your vet may recommend additional vaccines based on your pet's lifestyle and risk factors.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <h3>How can I tell if my pet is in pain?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>Signs of pain include changes in behavior, decreased appetite, limping, excessive grooming of one area, whimpering or crying, aggression, and reluctance to move or play. Pets are good at hiding pain, so subtle changes in behavior are important to notice.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-icon">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <h3>What should I feed my puppy/kitten?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>Young pets need specially formulated food for their age. Feed puppy/kitten food until they're 12-18 months old. Look for high-quality brands with proper protein, fat, and nutrient ratios. Always transition foods gradually over 7-10 days to avoid digestive upset.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-icon">
                                    <i class="fas fa-paw"></i>
                                </div>
                                <h3>How often should I groom my pet?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>Brushing frequency depends on coat type: daily for long-haired breeds, 2-3 times weekly for medium coats, and weekly for short-haired pets. Baths should be given monthly or as needed. Trim nails every 2-3 weeks and clean ears regularly.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <h3>When is it an emergency?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>Seek immediate veterinary care for: difficulty breathing, seizures, loss of consciousness, severe bleeding, suspected poisoning, inability to urinate/defecate, severe vomiting/diarrhea, or trauma from accidents. When in doubt, call your vet.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-icon">
                                    <i class="fas fa-medkit"></i>
                                </div>
                                <h3>Can I give my pet human medication?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>Never give human medications to pets without veterinary approval. Many human drugs are toxic to animals. Common medications like ibuprofen, acetaminophen, and aspirin can be dangerous or fatal. Always consult your vet before giving any medication.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question">
                                <div class="faq-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <h3>How do I pet-proof my home?</h3>
                                <div class="faq-toggle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>Remove toxic plants, secure chemicals and medications, cover electrical cords, install baby gates, secure windows and balconies, and remove small objects that could be swallowed. Create a safe space where your pet can retreat and feel secure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 style="color: var(--gray-700); margin-bottom: 1rem;">Join Our Pet Care Community</h2>
                    <p style="color: #6b7280; margin-bottom: 0;">Get weekly tips, exclusive guides, and the latest updates on pet health delivered straight to your inbox.</p>
                </div>
                <div class="col-lg-6">
                    <form class="newsletter-form" style="max-width: none;">
                        <input type="email" placeholder="Enter your email address" required>
                        <button type="submit">Subscribe Now</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div class="video-modal" id="videoModal">
        <div class="video-modal-content">
            <button class="video-modal-close">&times;</button>
            <div class="video-wrapper">
                <iframe id="videoFrame" src="" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <?php include 'footerlink.php'; ?>
    
    <script>
        $(document).ready(function() {
            // Category filter functionality
            $('.filter-btn').click(function() {
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');
                
                const category = $(this).data('category');
                
                // Hide all cards first
                $('.education-card').parent().hide();
                
                if (category === 'all') {
                    // Show all cards
                    $('.education-card').parent().fadeIn(300);
                } else {
                    // Show only cards with matching category
                    $('.education-card').each(function() {
                        const cardCategory = $(this).parent().data('category');
                        if (cardCategory === category) {
                            $(this).parent().fadeIn(300);
                        }
                    });
                }
                
                // Trigger animations for visible cards
                setTimeout(function() {
                    $('.education-card:visible').addClass('animate-in');
                }, 100);
                
                // Show message if no results
                const visibleCards = $('.education-card:visible').length;
                if (visibleCards === 0) {
                    if ($('#no-results').length === 0) {
                        $('.row').append('<div id="no-results" class="col-12 text-center py-5"><h3>No content found for this category</h3></div>');
                    }
                } else {
                    $('#no-results').remove();
                }
            });

            // Video play functionality
            function playVideo(videoId) {
                const modal = $('#videoModal');
                const iframe = $('#videoFrame');
                
                // Set the YouTube embed URL
                iframe.attr('src', `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`);
                
                // Show modal
                modal.addClass('active');
                
                // Prevent body scroll
                $('body').css('overflow', 'hidden');
            }
            
            // Close video modal
            function closeVideoModal() {
                const modal = $('#videoModal');
                const iframe = $('#videoFrame');
                
                // Hide modal
                modal.removeClass('active');
                
                // Clear iframe src to stop video
                iframe.attr('src', '');
                
                // Restore body scroll
                $('body').css('overflow', 'auto');
            }
            
            // Video card click handler
            $('.video-card').click(function() {
                const videoId = $(this).data('video-id');
                if (videoId) {
                    playVideo(videoId);
                }
            });
            
            // Play video button click handler
            $('.play-video-btn').click(function(e) {
                e.preventDefault();
                const videoId = $(this).data('video-id');
                if (videoId) {
                    playVideo(videoId);
                }
            });
            
            // Close modal handlers
            $('.video-modal-close').click(function() {
                closeVideoModal();
            });
            
            $('#videoModal').click(function(e) {
                if (e.target === this) {
                    closeVideoModal();
                }
            });
            
            // Close on escape key
            $(document).keydown(function(e) {
                if (e.key === 'Escape' && $('#videoModal').hasClass('active')) {
                    closeVideoModal();
                }
            });

            // Newsletter form submission
            $('.newsletter-form').submit(function(e) {
                e.preventDefault();
                const email = $(this).find('input[type="email"]').val();
                
                // Add your newsletter subscription logic here
                alert('Thank you for subscribing! You will receive pet care tips at: ' + email);
                $(this).find('input[type="email"]').val('');
            });

            // Search functionality
            $('.search-box input').on('input', function() {
                const searchTerm = $(this).val().toLowerCase().trim();
                
                // Clear any existing no-results message
                $('#no-results').remove();
                
                if (searchTerm.length > 0) {
                    // Reset all filters when searching
                    $('.filter-btn').removeClass('active');
                    $('.filter-btn[data-category="all"]').addClass('active');
                    
                    let visibleCount = 0;
                    
                    $('.education-card').each(function() {
                        const title = $(this).find('h3').text().toLowerCase();
                        const content = $(this).find('p').text().toLowerCase();
                        const badge = $(this).find('.education-badge').text().toLowerCase();
                        
                        if (title.includes(searchTerm) || content.includes(searchTerm) || badge.includes(searchTerm)) {
                            $(this).parent().fadeIn(300);
                            visibleCount++;
                            
                            // Highlight search terms
                            highlightSearchTerm($(this), searchTerm);
                        } else {
                            $(this).parent().hide();
                        }
                    });
                    
                    // Show no results message if needed
                    if (visibleCount === 0) {
                        $('.row').last().append(`
                            <div id="no-results" class="col-12 text-center py-5">
                                <i class="fas fa-search" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                                <h3 style="color: #666;">No results found for "${searchTerm}"</h3>
                                <p style="color: #999;">Try searching with different keywords or browse our categories above.</p>
                            </div>
                        `);
                    }
                } else {
                    // Reset to show all content and remove highlights
                    $('.education-card').parent().show();
                    removeHighlights();
                }
            });
            
            // Highlight search terms function
            function highlightSearchTerm(card, term) {
                removeHighlights();
                if (term.length < 2) return;
                
                card.find('h3, p').each(function() {
                    const originalText = $(this).text();
                    const regex = new RegExp(`(${term})`, 'gi');
                    const highlightedText = originalText.replace(regex, '<mark style="background: #fff3cd; padding: 2px 4px; border-radius: 3px;">$1</mark>');
                    if (highlightedText !== originalText) {
                        $(this).html(highlightedText);
                    }
                });
            }
            
            // Remove highlights function
            function removeHighlights() {
                $('.education-card').find('mark').each(function() {
                    $(this).replaceWith($(this).text());
                });
            }
            
            // Search button click
            $('.search-box button').click(function(e) {
                e.preventDefault();
                const searchTerm = $('.search-box input').val();
                if (searchTerm) {
                    $('html, body').animate({
                        scrollTop: $('.education-card:visible').first().offset().top - 100
                    }, 500);
                }
            });
            
            // Smooth scroll animation for cards
            $(window).scroll(function() {
                $('.education-card').each(function() {
                    const cardTop = $(this).offset().top;
                    const cardBottom = cardTop + $(this).outerHeight();
                    const windowTop = $(window).scrollTop();
                    const windowBottom = windowTop + $(window).height();

                    if (cardBottom > windowTop && cardTop < windowBottom) {
                        $(this).addClass('animate-in');
                    }
                });
            });
            
            // Initialize animations on load
            setTimeout(function() {
                $('.education-card:visible').addClass('animate-in');
            }, 300);
            
            // Scroll to top functionality
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#scrollToTop').fadeIn();
                } else {
                    $('#scrollToTop').fadeOut();
                }
            });
            
            $('#scrollToTop').click(function() {
                $('html, body').animate({scrollTop: 0}, 600);
                return false;
            });

            // FAQ Accordion Functionality
            $('.faq-question').click(function() {
                const faqItem = $(this).parent();
                const isActive = faqItem.hasClass('active');
                
                // Close all other FAQ items
                $('.faq-item').removeClass('active');
                
                // Toggle current item
                if (!isActive) {
                    faqItem.addClass('active');
                }
            });
        });
    </script>

    <style>
        .education-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .education-card.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</body>
</html>