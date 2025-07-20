<?php
session_start();
include "connection.php"
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CureMyPet </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'headlink.php'?>
  <link rel="stylesheet" href="assets/css/services-style.css">
</head>

<body>
  
    <!-- Header -->
  <?php include 'header.php'?>
    <!-- Header -->
  
    <main> 
<!-- Slider Area Start -->
<div class="jumbotron p-0 m-0" style="margin-top: 100px;">
  <div class="card card-raised card-carousel border-0 rounded-0" style="height: 90vh;">
    <div id="carouselindicators" class="carousel slide" data-ride="carousel" data-interval="8000" style="height: 90vh;">
      <ol class="carousel-indicators">
        <li data-target="#carouselindicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselindicators" data-slide-to="1"></li>
        <li data-target="#carouselindicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" style="height: 90vh;">
        <div class="carousel-item active" style="height: 90vh;">
          <img class="d-block w-100" src="img/slider-img-6.webp" alt="First slide" style="height: 100%; object-fit: cover;">
          <div class="carousel-caption">
            <h4>Book Your Appointment Digitally</h4>
            <p>Easy online booking system for your pet's healthcare needs</p>
            <a href="services.php" class="btn btn-primary-modern mt-3">Book Now</a>
          </div>
        </div>
        <div class="carousel-item" style="height: 90vh;">
          <img class="d-block w-100" src="img/slider-img-8.webp" alt="Second slide" style="height: 100%; object-fit: cover;">
          <div class="carousel-caption">
            <h4>Your Pet Is Our First Priority</h4>
            <p>Professional veterinary care with compassion and expertise</p>
            <a href="about.php" class="btn btn-primary-modern mt-3">Learn More</a>
          </div>
        </div>
        <div class="carousel-item" style="height: 90vh;">
          <img class="d-block w-100" src="img/to-next-level-pet-care.webp" alt="Third slide" style="height: 100%; object-fit: cover;">
          <div class="carousel-caption">
            <h4>Health Is Wealth</h4>
            <p>Quality pet products and healthcare services all in one place</p>
            <a href="products.php" class="btn btn-primary-modern mt-3">Shop Now</a>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselindicators" role="button" data-slide="prev">
        <i class="fa fa-chevron-left"></i>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselindicators" role="button" data-slide="next">
        <i class="fa fa-chevron-right"></i>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</div>
<!-- Slider Area End -->

<style>
  :root {
    --primary-orange: #e97140;
  }

  /* Modern Carousel Styles */
  #carouselindicators,
  .carousel-inner,
  .carousel-item {
    height: 90vh;
  }

  .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    background: #f8f9fa;
  }

  /* Caption Styling */
  .carousel-caption {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 10;
  }

  .carousel-caption h4 {
    color: white;
    font-size: 3rem;
    font-weight: 700;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    font-family: 'Poppins', sans-serif;
    letter-spacing: -0.02em;
    margin-bottom: 1rem;
    animation: fadeInUp 0.8s ease;
  }

  .carousel-caption p {
    color: white;
    font-size: 1.25rem;
    font-weight: 400;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    animation: fadeInUp 0.8s ease 0.2s;
    animation-fill-mode: both;
  }

  /* Simple Button Styling */
  .btn-primary-modern {
    background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
    border: none;
    color: white;
    padding: 12px 25px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(233, 113, 64, 0.3);
    text-decoration: none;
    display: inline-block;
  }

  .btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(233, 113, 64, 0.4);
    background: linear-gradient(135deg, #d6612d 0%, #ea580c 100%);
    color: white;
    text-decoration: none;
  }

  /* Simple Carousel Indicators */
  .carousel-indicators li {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 5px;
    background-color: rgba(255, 255, 255, 0.5);
    border: none;
    transition: all 0.3s ease;
  }

  .carousel-indicators .active {
    background-color: var(--primary-orange);
    transform: scale(1.2);
  }

  /* Simple Carousel Controls */
  .carousel-control-prev,
  .carousel-control-next {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.8;
    transition: all 0.3s ease;
  }

  .carousel-control-prev:hover,
  .carousel-control-next:hover {
    background: rgba(255, 255, 255, 0.2);
    opacity: 1;
  }

  .carousel-control-prev {
    left: 30px;
  }

  .carousel-control-next {
    right: 30px;
  }

  .carousel-control-prev i,
  .carousel-control-next i {
    font-size: 20px;
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

  @media (max-width: 768px) {
    .carousel-caption h4 {
      font-size: 2rem;
    }
    .carousel-caption p {
      font-size: 1rem;
    }
  }

  .section-padding30 {
    padding-top: 4rem;
  }

  /* Enhanced Team Section Styles */
  .team-area {
    background: var(--gray-50);
    padding: 80px 0;
  }

  .team-area .section-tittle {
    margin-bottom: 60px;
  }

  .team-area .section-tittle span {
    color: var(--primary-orange);
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
    display: block;
  }

  .team-area .section-tittle h2 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--gray-800);
    margin: 0;
  }

  .team-area .single-team {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
    margin-bottom: 30px;
    border-top: 4px solid var(--primary-orange);
  }

  .team-area .single-team:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.15);
  }

  .team-area .single-team .team-img {
    position: relative;
    overflow: hidden;
    height: 350px;
    background: var(--gray-100);
  }

  .team-area .single-team .team-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transition: transform 0.4s ease;
    display: block;
  }

  .team-area .single-team:hover .team-img img {
    transform: scale(1.05);
  }

  .team-area .single-team .team-caption {
    padding: 30px 25px;
    text-align: center;
    background: white;
    transition: all 0.3s ease;
  }

  .team-area .single-team:hover .team-caption {
    background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
  }

  .team-area .single-team .team-caption span {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--gray-800);
    display: block;
    margin-bottom: 8px;
    transition: color 0.3s ease;
  }

  .team-area .single-team:hover .team-caption span {
    color: white;
  }

  .team-area .single-team .team-caption h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 500;
  }

  .team-area .single-team .team-caption h3 a {
    color: var(--primary-orange);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
  }

  .team-area .single-team:hover .team-caption h3 a {
    color: white;
  }

  @media (max-width: 768px) {
    .team-area .section-tittle h2 {
      font-size: 2rem;
    }
    
    .team-area .single-team .team-img {
      height: 300px;
    }
    
    .team-area .single-team .team-caption {
      padding: 25px 20px;
    }
  }

  /* Enhanced Testimonial Section Styles */
  .testimonial-area {
    position: relative;
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
  }

  .testimonial-area::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #007582;
  }

  .testimonial-area .container {
    position: relative;
    z-index: 2;
  }

  .testimonial-area .section-tittle span {
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .testimonial-area .section-tittle h2 {
    text-shadow: 0 4px 8px rgba(0,0,0,0.3);
  }

  .single-testimonial {
    padding: 25px 20px;
    margin: 0 10px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
  }

  .single-testimonial:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
  }

  .testimonial-founder .founder-img {
    position: relative;
  }

  .testimonial-founder .founder-img img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255, 255, 255, 0.3);
    margin: 0 auto;
    display: block;
    transition: all 0.3s ease;
  }

  .single-testimonial:hover .founder-img img {
    border-color: var(--primary-orange);
    transform: scale(1.1);
  }

  .testimonial-founder span {
    color: white;
    font-size: 1.1rem;
    font-weight: 700;
    display: block;
    margin-top: 10px;
    margin-bottom: 3px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .testimonial-founder p {
    color: var(--primary-orange);
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0;
  }

  .testimonial-top-cap {
    margin-top: 15px;
  }

  .testimonial-top-cap p {
    color: rgba(255, 255, 255, 0.95);
    font-size: 0.95rem;
    line-height: 1.5;
    font-style: italic;
    margin: 0;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
  }

  .testimonial-top-cap p::before {
    content: '"';
    font-size: 2rem;
    color: var(--primary-orange);
    position: absolute;
    margin-left: -20px;
    margin-top: -10px;
  }

  .testimonial-top-cap p::after {
    content: '"';
    font-size: 2rem;
    color: var(--primary-orange);
  }

  @media (max-width: 768px) {
    .testimonial-area .section-tittle h2 {
      font-size: 2rem;
    }
    
    .single-testimonial {
      padding: 30px 20px;
      margin: 0 10px;
    }
    
    .testimonial-top-cap p {
      font-size: 1rem;
    }
  }
</style>




        <!-- Services Section -->
        <section class="services-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-subtitle">What We Offer</div>
                    <h2 class="section-title">Best Pet Care Services</h2>
                    <p class="section-description">Professional pet care services designed to keep your beloved companions healthy, happy, and thriving.</p>
                </div>

                <?php
                include 'connection.php';
                $query = mysqli_query($con, "SELECT * FROM services LIMIT 6");
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
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- View All Services Button -->
                <div class="text-center" style="margin-top: 50px;">
                    <a href="services.php" class="service-cta" style="font-size: 1rem; padding: 15px 30px;">
                        <i class="fas fa-eye me-2"></i>
                        View All Services
                    </a>
                </div>
            </div>
        </section>
        <!-- Services End -->
        <!--? About Area Start-->
        <div class="about-area fix">
            <!--Right Contents  -->
            <div class="about-img" style="background-image: url(assets/img/gallery/team-img-10.webp);">
                <div class="info-man text-center">
                <div class="head-cap">
                    <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28px" height="39px">
                        <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                        d="M24.000,19.000 C21.791,19.000 20.000,17.209 20.000,15.000 C20.000,12.790 21.791,11.000 24.000,11.000 C26.209,11.000 28.000,12.790 28.000,15.000 C28.000,17.209 26.209,19.000 24.000,19.000 ZM24.000,8.000 C21.791,8.000 20.000,6.209 20.000,4.000 C20.000,1.790 21.791,-0.001 24.000,-0.001 C26.209,-0.001 28.000,1.790 28.000,4.000 C28.000,6.209 26.209,8.000 24.000,8.000 ZM14.000,38.999 C11.791,38.999 10.000,37.209 10.000,35.000 C10.000,32.791 11.791,31.000 14.000,31.000 C16.209,31.000 18.000,32.791 18.000,35.000 C18.000,37.209 16.209,38.999 14.000,38.999 ZM14.000,29.000 C11.791,29.000 10.000,27.209 10.000,25.000 C10.000,22.791 11.791,21.000 14.000,21.000 C16.209,21.000 18.000,22.791 18.000,25.000 C18.000,27.209 16.209,29.000 14.000,29.000 ZM14.000,19.000 C11.791,19.000 10.000,17.209 10.000,15.000 C10.000,12.790 11.791,11.000 14.000,11.000 C16.209,11.000 18.000,12.790 18.000,15.000 C18.000,17.209 16.209,19.000 14.000,19.000 ZM14.000,8.000 C11.791,8.000 10.000,6.209 10.000,4.000 C10.000,1.790 11.791,-0.001 14.000,-0.001 C16.209,-0.001 18.000,1.790 18.000,4.000 C18.000,6.209 16.209,8.000 14.000,8.000 ZM4.000,29.000 C1.791,29.000 -0.000,27.209 -0.000,25.000 C-0.000,22.791 1.791,21.000 4.000,21.000 C6.209,21.000 8.000,22.791 8.000,25.000 C8.000,27.209 6.209,29.000 4.000,29.000 ZM4.000,19.000 C1.791,19.000 -0.000,17.209 -0.000,15.000 C-0.000,12.790 1.791,11.000 4.000,11.000 C6.209,11.000 8.000,12.790 8.000,15.000 C8.000,17.209 6.209,19.000 4.000,19.000 ZM4.000,8.000 C1.791,8.000 -0.000,6.209 -0.000,4.000 C-0.000,1.790 1.791,-0.001 4.000,-0.001 C6.209,-0.001 8.000,1.790 8.000,4.000 C8.000,6.209 6.209,8.000 4.000,8.000 ZM24.000,21.000 C26.209,21.000 28.000,22.791 28.000,25.000 C28.000,27.209 26.209,29.000 24.000,29.000 C21.791,29.000 20.000,27.209 20.000,25.000 C20.000,22.791 21.791,21.000 24.000,21.000 Z"/>
                    </svg>
                    <h3>354</h3>
                </div>
                    <p>Success<br>Treatment</p>
                </div>
                
            </div>
            <!-- left Contents -->
            <div class="about-details">
                <div class="right-caption">
                    <!-- Section Tittle -->
                    <div class="section-tittle mb-50">
                        <h2>We are commited for<br> better service</h2>
                    </div>
                    <div class="about-more">
                        <p class="pera-top">ensuring the highest standards of care and attention. Our team strives to deliver exceptional results, offering tailored solutions to meet your needs with professionalism and dedication.</p>
                        <p class="mb-65 pera-bottom">We continuously aim for excellence in every aspect of our service, ensuring that each client receives top-notch care and support. Our commitment is reflected in the quality of our services, as we aim to make a positive impact on your experience every time you choose us.</p>
                        <a href="contact.php" class="btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About Area End-->
        <!--? Gallery Area Start -->
        <div class="gallery-area section-padding30">
            <div class="container fix">
                <div class="row justify-content-sm-center">
                    <div class="cl-xl-7 col-lg-8 col-md-10">
                        <!-- Section Tittle -->
                        <div class="section-tittle text-center mb-70">
                            <span>Our Recent Photos</span>
                            <h2>Pets Photo Gallery</h2>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-gallery mb-30">
                            <!-- <a href="assets/img/gallery/gallery1.png" class="img-pop-up">View Project</a> -->
                            <div class="gallery-img size-img" style="background-image: url(assets/img/gallery/gallery1.png);"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-6">
                        <div class="single-gallery mb-30">
                            <div class="gallery-img size-img" style="background-image: url(assets/img/gallery/gallery2.png);"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-6">
                        <div class="single-gallery mb-30">
                            <div class="gallery-img size-img" style="background-image: url(assets/img/gallery/gallery3.png);"></div>
                        </div>
                    </div>
                    <div class="col-lg-4  col-md-6 col-sm-6">
                        <div class="single-gallery mb-30">
                            <div class="gallery-img size-img" style="background-image: url(assets/img/gallery/gallery4.png);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery Area End -->
        <!--? Contact form Start -->
        
            <!-- contact left Img-->
        <!-- Contact form End -->
        <!--? Team Start -->
        <div class="team-area section-padding30">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="cl-xl-7 col-lg-8 col-md-10">
                        <!-- Section Tittle -->
                        <div class="section-tittle text-center mb-70">
                            <span>Our Professional members </span>
                            <h2>Our Team Members</h2>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <!-- single Team -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/doctor 1.png" alt="Dr. Mike Janathon">
                            </div>
                            <div class="team-caption">
                                <span>Dr. Mike Janathon</span>
                                <h3><a href="#">Senior Veterinarian</a></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/doctor 2.png" alt="Dr. Mike J Smith">
                            </div>
                            <div class="team-caption">
                                <span>Dr. Mike J Smith</span>
                                <h3><a href="#">Emergency Care Specialist</a></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/doctor 3.png" alt="Dr. Sarah Johnson">
                            </div>
                            <div class="team-caption">
                                <span>Dr. Sarah Johnson</span>
                                <h3><a href="#">Surgery Specialist</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->
        <!--? Testimonial Start -->
        <div class="testimonial-area section-bg" data-background="assets/img/gallery/section_bg03.png" style="padding: 40px 0;">
            <div class="container">
                <!-- Section Header -->
                <div class="row justify-content-center mb-30">
                    <div class="col-xl-8 col-lg-8 col-md-10">
                        <div class="section-tittle text-center">
                            <span style="color: var(--primary-orange); font-weight: 600; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; display: block;">Happy Customers</span>
                            <h2 style="font-size: 2rem; font-weight: 800; color: white; margin: 0;">What Our Clients Say</h2>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial contents -->
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-10 col-lg-10 col-md-12">
                        <div class="h1-testimonial-active dot-style">
                            <!-- Single Testimonial -->
                            <div class="single-testimonial text-center">
                                <div class="testimonial-caption ">
                                    <!-- founder -->
                                    <div class="testimonial-founder">
                                        <div class="founder-img mb-40">
                                            <img src="assets/img/gallery/testi-logo.png" alt="">
                                            <span>James Thompson</span>
                                            <p>Pet Owner</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-top-cap">
                                        <p>"CureMyPet has been absolutely brilliant for my Golden Retriever, Max. The online booking system is quite convenient, and the veterinary care is exceptional. Dr. Mike Janathon was incredibly gentle and thorough during Max's check-up. Couldn't be more pleased with the service!"</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Testimonial -->
                            <div class="single-testimonial text-center">
                                <div class="testimonial-caption ">
                                    <!-- founder -->
                                    <div class="testimonial-founder">
                                        <div class="founder-img mb-40">
                                            <img src="assets/img/gallery/testi2.png" alt="">
                                            <span>Mohammed Ali Khan</span>
                                            <p>Cat Owner</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-top-cap">
                                        <p>"My Persian cat Luna had a serious health issue, and the emergency care team at CureMyPet saved her life. Dr. Sarah Johnson performed the surgery with such expertise. The 24/7 support and fast delivery of medications made all the difference. Alhamdulillah, highly recommended!"</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Testimonial -->
                            <div class="single-testimonial text-center">
                                <div class="testimonial-caption ">
                                    <!-- founder -->
                                    <div class="testimonial-founder">
                                        <div class="founder-img mb-40">
                                            <img src="assets/img/gallery/testi3.png" alt="">
                                            <span>Rajesh Kumar</span>
                                            <p>Dog Owner</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-top-cap">
                                        <p>"As a first-time pet owner in Dubai, I was nervous about finding the right veterinary care. CureMyPet made everything so easy! The staff is very professional, the facility is modern, and my puppy Charlie loves visiting. The premium pet products are also excellent quality. Very satisfied!"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->
        <!--? Blog start -->
        <div class="home_blog-area section-padding30">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="cl-xl-7 col-lg-8 col-md-10">
                        <!-- Section Tittle -->
                        <div class="section-tittle text-center mb-70">
                            <span>Oure recent news</span>
                            <h2>Our Recent Blog</h2>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-blogs mb-30">
                            <div class="blog-img">
                                <img src="assets/img/gallery/blog1.png" alt="">
                            </div>
                            <div class="blogs-cap">
                                <div class="date-info">
                                    <span>Pet food</span>
                                    <p>Nov 30, 2020</p>
                                </div>
                                <h4>Amazing Places To Visit In Summer</h4>
                                <a href="blog_details.html" class="read-more1">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-blogs mb-30">
                            <div class="blog-img">
                                <img src="assets/img/gallery/blog2.png" alt="">
                            </div>
                            <div class="blogs-cap">
                                <div class="date-info">
                                    <span>Pet food</span>
                                    <p>Nov 30, 2020</p>
                                </div>
                                <h4>Developing Creativithout Losing Visual</h4>
                                <a href="blog_details.html" class="read-more1">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-blogs mb-30">
                            <div class="blog-img">
                                <img src="assets/img/gallery/blog3.png" alt="">
                            </div>
                            <div class="blogs-cap">
                                <div class="date-info">
                                    <span>Pet food</span>
                                    <p>Nov 30, 2020</p>
                                </div>
                                <h4>Winter Photography Tips from Glenn</h4>
                                <a href="blog_details.html" class="read-more1">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog End -->
        <!--? contact-animal-owner Start -->
        <div class="contact-animal-owner section-bg" data-background="assets/img/gallery/section_bg04.png">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="contact_text text-center">
                            <div class="section_title text-center">
                                <h3>Any time you can call us!</h3>
                                <p>Because we know that even the best technology is only as good as the people behind it. 24/7 tech support.</p>
                            </div>
                            <div class="contact_btn d-flex align-items-center justify-content-center">
                                <a href="contact.html" class="btn white-btn">Contact Us</a>
                                <p>Or<a href="#"> +971 55 2834004</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- contact-animal-owner End -->
    </main>
<?php include "footer.php"?>

    <!-- JS here -->
        <?php include 'footerlink.php'?>

       
    </body>
</html>
