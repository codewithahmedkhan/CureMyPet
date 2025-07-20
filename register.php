<?php
session_start();
include 'connection.php';

$message = '';
$showAlert = false;

if (isset($_POST['btn'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $password = trim($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $check_stmt = $con->prepare("SELECT id FROM user WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $message = "Email already exists! Please use a different email.";
        $showAlert = true;
    } else {
        $insert_stmt = $con->prepare("INSERT INTO user (name, email, password, contact) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("ssss", $name, $email, $hashed_password, $contact);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Account created successfully!'); window.location.href='login.php';</script>";
            exit();
        } else {
            $message = "Something went wrong while creating your account.";
            $showAlert = true;
        }
    }

    $check_stmt->close();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'; ?>
    <style>
        :root {
            --primary-orange: #e97140;
            --primary-orange-dark: #d6612d;
            --gray-50: #f9fafb;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
        }

        body { background: var(--gray-50); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .hero-section { background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%); color: white; padding: 120px 0 80px; margin-top: 80px; }
        .hero-content { text-align: center; }
        .hero-content h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 1.5rem; text-shadow: 0 4px 8px rgba(0,0,0,0.2); color: white; }
        .contact-section { padding: 80px 0; }
        .form-wrapper { max-width: 500px; margin: 0 auto; padding: 50px; background: white; border-radius: 25px; box-shadow: 0 25px 80px rgba(0,0,0,0.15); border-top: 5px solid var(--primary-orange); }
        .form-title { text-align: center; font-size: 2.5rem; font-weight: 800; color: var(--gray-800); margin-bottom: 15px; }
        .form-subtitle { text-align: center; color: var(--gray-600); font-size: 1.1rem; margin-bottom: 40px; }
        .form-group { margin-bottom: 25px; position: relative; }
        .form-label { font-weight: 600; color: var(--gray-700); margin-bottom: 10px; display: block; }
        .form-control { width: 100%; padding: 18px 25px; border: 2px solid var(--gray-200); border-radius: 15px; font-size: 16px; transition: all 0.3s ease; background: white; box-sizing: border-box; margin-bottom: 5px; }
        .form-control:focus { outline: none; border-color: var(--primary-orange); box-shadow: 0 0 0 4px rgba(233, 113, 64, 0.15); transform: translateY(-2px); }
        .form-control::placeholder { color: #9ca3af; }
        .form-control.error { border-color: #dc2626; box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.15); }
        .form-control.success { border-color: #16a34a; box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.15); }
        .password-wrapper { position: relative; }
        .password-toggle { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--gray-600); font-size: 18px; padding: 5px; }
        .password-toggle:hover { color: var(--primary-orange); }
        .btn-submit { background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%); color: white; padding: 18px 40px; font-size: 1.1rem; font-weight: 700; border: none; border-radius: 15px; cursor: pointer; transition: all 0.3s ease; width: 100%; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 12px 35px rgba(233, 113, 64, 0.3); margin-top: 20px; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 18px 45px rgba(233, 113, 64, 0.4); background: linear-gradient(135deg, var(--primary-orange-dark) 0%, #ea580c 100%); }
        .btn-submit:disabled { background: #d1d5db; cursor: not-allowed; transform: none; box-shadow: none; }
        .login-link { display: block; margin-top: 25px; text-align: center; color: var(--primary-orange); text-decoration: none; font-weight: 600; }
        .login-link:hover { color: var(--primary-orange-dark); text-decoration: underline; }
        .error-message { background: #fee2e2; color: #dc2626; padding: 8px 12px; border-radius: 8px; margin-bottom: 15px; font-size: 0.875rem; border: 1px solid #fecaca; display: none; }
        .success-message { background: #dcfce7; color: #16a34a; padding: 8px 12px; border-radius: 8px; margin-bottom: 15px; font-size: 0.875rem; border: 1px solid #bbf7d0; display: none; }
        .error-message.show, .success-message.show { display: block; }

        @media (max-width: 768px) {
            .hero-content h1 { font-size: 2.5rem; }
            .form-wrapper { margin: 0 15px; padding: 30px 25px; }
            .form-title { font-size: 2rem; }
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>

<main>
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-content">
                        <h1>Register</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <?php if ($showAlert && $message): ?>
                <script>alert("<?= $message ?>");</script>
            <?php endif; ?>

            <div class="form-wrapper">
                <div class="form-title">Create Your Account</div>
                <p class="form-subtitle">Join CureMyPet to book appointments and manage your pet's health</p>
                
                <form method="POST" action="register.php" id="registrationForm" novalidate>
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input class="form-control" name="name" id="name" type="text" placeholder="Enter your name" required>
                        <div class="error-message" id="nameError"></div>
                        <div class="success-message" id="nameSuccess"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input class="form-control" name="email" id="email" type="email" placeholder="Enter your email" required>
                        <div class="error-message" id="emailError"></div>
                        <div class="success-message" id="emailSuccess"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input class="form-control" name="contact" id="contact" type="text" placeholder="Enter your phone number" required>
                        <div class="error-message" id="contactError"></div>
                        <div class="success-message" id="contactSuccess"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input class="form-control" name="password" id="password" type="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="passwordToggle">👁️</button>
                        </div>
                        <div class="error-message" id="passwordError"></div>
                        <div class="success-message" id="passwordSuccess"></div>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit" name="btn" class="btn-submit" id="submitBtn">Register</button>
                    </div>
                </form>

                <a href="login.php" class="login-link">Already have an account? Login here</a>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
<?php include 'footerlink.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fields = { name: /^[a-zA-Z\s]{2,50}$/, email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, contact: /^[0-9+\-\s()]{10,15}$/, password: /.{8,}/ };
    const messages = { 
        name: { error: 'Name should only contain letters and spaces (2-50 characters)', success: 'Valid name' },
        email: { error: 'Please enter a valid email address', success: 'Valid email' },
        contact: { error: 'Phone number should be 10-15 digits with +, -, spaces, or parentheses', success: 'Valid phone number' },
        password: { error: 'Password must be at least 8 characters long', success: 'Valid password' }
    };

    function validate(field, value) {
        if (field === 'contact') value = value.replace(/[^0-9]/g, '');
        return fields[field].test(value);
    }

    function showMessage(field, isValid) {
        const input = document.getElementById(field);
        const errorEl = document.getElementById(field + 'Error');
        const successEl = document.getElementById(field + 'Success');
        
        input.className = 'form-control ' + (isValid ? 'success' : 'error');
        errorEl.className = 'error-message ' + (!isValid ? 'show' : '');
        successEl.className = 'success-message ' + (isValid ? 'show' : '');
        errorEl.textContent = messages[field].error;
        successEl.textContent = messages[field].success;
    }

    function checkForm() {
        const isValid = Object.keys(fields).every(field => validate(field, document.getElementById(field).value));
        document.getElementById('submitBtn').disabled = !isValid;
    }

    Object.keys(fields).forEach(field => {
        document.getElementById(field).addEventListener('input', function() {
            const isValid = validate(field, this.value);
            showMessage(field, isValid);
            checkForm();
        });
    });

    document.getElementById('passwordToggle').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        this.textContent = type === 'password' ? '👁️' : '🙈';
    });

    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        const isValid = Object.keys(fields).every(field => {
            const valid = validate(field, document.getElementById(field).value);
            showMessage(field, valid);
            return valid;
        });
        if (!isValid) e.preventDefault();
    });

    checkForm();
});
</script>

</body>
</html>