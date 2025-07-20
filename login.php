<?php
session_start();
include 'connection.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'; ?>

    <style>
        :root {
            --primary-orange: #e97140;
            --primary-orange-dark: #d6612d;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
        }

        body {
            background: var(--gray-50);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 120px 0 80px;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
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

        .contact-section {
            padding: 80px 0;
        }

        .form-wrapper {
            max-width: 500px;
            margin: 0 auto;
            padding: 50px;
            background: white;
            border-radius: 25px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.15);
            border-top: 5px solid var(--primary-orange);
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

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 10px;
            display: block;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 18px 25px;
            border: 2px solid var(--gray-200);
            border-radius: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 4px rgba(233, 113, 64, 0.15);
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
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
            background: linear-gradient(135deg, var(--primary-orange-dark) 0%, #ea580c 100%);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider span {
            background: white;
            padding: 0 20px;
            color: var(--gray-600);
            font-size: 0.9rem;
            position: relative;
            font-weight: 500;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gray-300);
            z-index: -1;
        }

        .register-link {
            display: block;
            margin-top: 25px;
            text-align: center;
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .register-link:hover {
            color: var(--primary-orange-dark);
            text-decoration: underline;
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 8px;
            font-size: 0.875rem;
            border: 1px solid #fecaca;
            display: none;
        }

        .error-message.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        .form-control.error {
            border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.15);
        }

        .form-control.success {
            border-color: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.15);
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .form-wrapper {
                margin: 0 15px;
                padding: 30px 25px;
            }
            
            .form-title {
                font-size: 2rem;
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
                        <h1>Login</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Form -->
    <section class="contact-section">
        <div class="container">
            <div class="form-wrapper">
                <div class="form-title">Welcome Back</div>
                <p class="form-subtitle">Login to access your account</p>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" name="btn" class="btn-submit">Sign In</button>

                    <div class="divider">
                        <span>OR</span>
                    </div>

                    <a href="register.php" class="register-link">Don't have an account? Sign up</a>
                </form>

                <?php
                if (isset($_POST['btn'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $query = mysqli_query($con, "SELECT * FROM user WHERE email='$email' LIMIT 1");

                    if (mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_assoc($query);
                        if (password_verify($password, $row['password'])) {
                            $_SESSION['loginsuccessfull'] = 1;
                            $_SESSION['email'] = $email;
                            $_SESSION['adminname'] = $row['name'];
                            $_SESSION['user_id'] = $row['id'];
                            echo "<script>window.location.href='index.php';</script>";
                            exit();
                        } else {
                            echo "<script>alert('Invalid Email or Password');</script>";
                        }
                    } else {
                        echo "<script>alert('Invalid Email or Password');</script>";
                    }
                }
                ?>
            </div>
        </div>
    </section>
</main>

    <?php include 'footer.php'; ?>
    <?php include 'footerlink.php'; ?>
</body>
</html>
