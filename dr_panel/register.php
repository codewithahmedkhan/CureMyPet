<?php
session_start();
include 'connection.php';

$message = '';
$showAlert = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check_stmt = $con->prepare("SELECT id FROM doctor WHERE dremail = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $message = "Email already exists! Please use another.";
        $showAlert = true;
    } else {
        // Insert into DB (fixed password column name)
        $insert_stmt = $con->prepare("INSERT INTO doctor (drname, dremail, `password`) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($insert_stmt->execute()) {
            echo "<script>
                alert('Registration successful!');
                window.location.href = 'login.php';
            </script>";
            exit();
        } else {
            $message = "Error creating account. Please try again.";
            $showAlert = true;
        }
        $insert_stmt->close();
    }
    $check_stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Registration </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #e97140, #007482);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-wrapper {
            max-width: 550px;
            margin: 7rem auto;
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .register-wrapper h2 {
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .register-wrapper .form-control {
            border-radius: 6px;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .btn-register {
            background-color: #007482;
            color: white;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 6px;
            width: 100%;
            transition: 0.3s ease;
        }
        .btn-register:hover {
            background-color: #005f6a;
        }
        .logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 80px;
        }
        .text-center a {
            color: #007482;
        }
        @media (max-width: 576px) {
            .register-wrapper {
                margin: 3rem 1rem;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-wrapper">
        <img src="../assets/img/logo.png" alt="Logo" class="logo">
        <h2>Doctor Registration</h2>

        <?php if ($showAlert && $message): ?>
            <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" class="form-control" placeholder="Enter Your Name" name="name" required>
            <input type="email" class="form-control" placeholder="Enter Your Email" name="email" required>
            <input type="password" class="form-control" placeholder="Create Password" name="password" required>
            <button type="submit" name="btn" class="btn-register">Register Account</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php">Already have an account? Login</a>
        </div>
    </div>
</div>

<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
