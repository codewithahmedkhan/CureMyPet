<?php
session_start();
include 'admin_login_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
<?php include 'headlink.php'?>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-3 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="POST" action="register.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter User Name" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" placeholder="Password" name="password" required>
                                        </div>
                                      
                                        <input type="submit" class="btn btn-primary btn-user btn-block"  name="btn" value="Registerr Account">
                                      
                                       
                                    </form>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block bg-register-image"></div>

                </div>
            </div>
        </div>
        <?php 
include 'connection.php';

if (isset($_POST['btn'])) {

  $name = $_POST['name'];
  $password= $_POST['password'];

  $pass=password_hash($password, PASSWORD_BCRYPT);

  $query = mysqli_query($con,"insert into admin values('','$name','$pass')");

  if ($query) {
	echo	"<script>alert('New Admin Successfully Added');window.location.href='login.php';</script>";

  }
  else {
	  echo "Please fill the Details Properly";
  }
}
?>
    </div>
<?php include 'footerlink.php'?>

</body>

</html>