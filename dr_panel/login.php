<?php
session_start();
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #e97140, #007482);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-wrapper {
            max-width: 500px;
            margin: 7rem auto;
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .login-wrapper h2 {
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .login-wrapper .form-control {
            border-radius: 6px;
            padding: 12px;
            font-size: 16px;
        }

        .btn-login {
            background-color: #007482;
            color: white;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 6px;
            width: 100%;
            transition: 0.3s ease;
        }

        .btn-login:hover {
            background-color: #005f6a;
        }

        .logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 80px;
        }

        @media (max-width: 576px) {
            .login-wrapper {
                margin: 3rem 1rem;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-wrapper">
        <img src="../assets/img/logo.png" alt="Logo" class="logo">
        <h2>Doctor Login</h2>

        <form method="POST" action="login.php">
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
            <button type="submit" name="btn" class="btn-login">Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="register.php">Create an Account</a>
        </div>
    </div>
</div>

<?php
if (isset($_POST['btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($con, "SELECT * FROM doctor WHERE dremail='$email' LIMIT 1");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

        if (password_verify($password, $row['password'])) {
            $_SESSION['dr_id'] = $row['id'];
            $_SESSION['email'] = $email;
            $_SESSION['drname'] = $row['drname'];

           echo "<script>window.location.href = 'index.php';</script>";
exit();
        } else {
            echo "<script>alert('Invalid Email or Password');</script>";
        }
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>

<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
