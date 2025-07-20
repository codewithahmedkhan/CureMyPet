<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$loggedInUserId = $_SESSION['user_id'];

// Fetch user info
$userResult = mysqli_query($con, "SELECT name, email FROM user WHERE id = '$loggedInUserId'");
$user = mysqli_fetch_assoc($userResult);

$loggedInUsername = $user ? $user['name'] : "Guest";
$loggedInUseremail = $user ? $user['email'] : "guest@example.com";

// Fetch doctors and services
$doctors = mysqli_query($con, "SELECT id, drname FROM doctor");
$services = mysqli_query($con, "SELECT id, servicename FROM services");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<script>console.log('DEBUG: Form submitted via POST');</script>";
    
    // Check if all required fields are present
    if (isset($_POST['drname'], $_POST['servicesname'], $_POST['petdetail'], $_POST['location'], $_POST['contact'], $_POST['message'])) {
        echo "<script>console.log('DEBUG: All required fields are present');</script>";
        
        $drname = $_POST['drname'];
        $servicesname = $_POST['servicesname'];
        $petdetail = $_POST['petdetail'];
        $location = $_POST['location'];
        $contact = $_POST['contact'];
        $message = $_POST['message'];
        
        echo "<script>console.log('DEBUG: Doctor ID: " . $drname . ", Service ID: " . $servicesname . "');</script>";
        
        // Validate that doctor and service IDs are not empty
        if (empty($drname) || empty($servicesname)) {
            echo "<script>alert('Please select both doctor and service.'); console.log('DEBUG: Missing doctor or service selection');</script>";
        } else {
            // Check database connection
            if (!$con) {
                echo "<script>alert('Database connection failed: " . mysqli_connect_error() . "'); console.log('DEBUG: Database connection failed');</script>";
            } else {
                echo "<script>console.log('DEBUG: Database connection successful');</script>";
                
                // Prepare the SQL statement
                $stmt = $con->prepare("INSERT INTO form (drname, servicesname, petdetail, location, contact, message, useremail, uername) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                
                if (!$stmt) {
                    echo "<script>alert('Prepare failed: " . $con->error . "'); console.log('DEBUG: Prepare statement failed');</script>";
                } else {
                    echo "<script>console.log('DEBUG: SQL statement prepared successfully');</script>";
                    
                    // Bind parameters
                    $stmt->bind_param("iissssss", $drname, $servicesname, $petdetail, $location, $contact, $message, $loggedInUseremail, $loggedInUsername);
                    
                    echo "<script>console.log('DEBUG: Parameters bound, executing statement');</script>";
                    
                    // Execute the statement
                    if ($stmt->execute()) {
                        echo "<script>
                            console.log('DEBUG: Data inserted successfully');
                            alert('Your appointment has been sent to the doctor.');
                            window.location.href='thankyou.php';
                        </script>";
                        exit();
                    } else {
                        echo "<script>
                            alert('Database Error: " . $stmt->error . "');
                            console.log('DEBUG: Execute failed - " . $stmt->error . "');
                        </script>";
                    }
                    $stmt->close();
                }
            }
        }
    } else {
        echo "<script>
            alert('Missing required form fields. Please fill all fields.');
            console.log('DEBUG: Missing POST fields');
            console.log('POST data: ', " . json_encode($_POST) . ");
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment - CureMyPet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headlink.php'; ?>
    <style>
        :root {
            --primary-orange: #e97140;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
        }

        body {
            background-color: var(--gray-50);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 100px 0 60px;
            margin-top: 80px;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }

        .hero-content p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 500px;
            margin: 0 auto;
            color: white;
        }

        /* Form Section */
        .form-section {
            padding: 60px 0;
        }

        .form-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-top: 4px solid var(--primary-orange);
        }

        .form-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 30px;
        }

        .user-info {
            background: var(--gray-100);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid var(--primary-orange);
        }

        .user-info h4 {
            margin: 0 0 10px 0;
            color: var(--gray-800);
            font-weight: 600;
        }

        .user-info p {
            margin: 5px 0;
            color: var(--gray-600);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 8px;
            display: block;
        }

        .required {
            color: #ef4444;
        }

        /* Fixed Form Controls */
        .form-control {
            width: 100%;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            box-sizing: border-box;
            line-height: 1.4;
            vertical-align: middle;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(233, 113, 64, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        /* Specific styling for select elements */
        select.form-control {
            height: 48px;
            padding: 0 40px 0 15px;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }

        /* Option text alignment */
        select.form-control option {
            padding: 8px 12px;
            line-height: 1.4;
        }

        /* Input fields styling */
        input.form-control {
            height: 48px;
            padding: 12px 15px;
        }

        /* Textarea specific styling */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            padding: 12px 15px;
            line-height: 1.5;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #f97316 100%);
            color: white;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(233, 113, 64, 0.3);
        }

        .security-note {
            text-align: center;
            margin-top: 20px;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.2rem;
            }
            
            .form-card {
                padding: 30px 20px;
                margin: 0 15px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>Book an Appointment</h1>
            <p>Schedule a consultation with our expert veterinarians for your beloved pet</p>
        </div>
    </div>
</section>

<section class="form-section">
    <div class="form-container">
        <div class="form-card">
            <h2 class="form-title">Schedule Your Pet's Appointment</h2>

            <!-- User Information -->
            <div class="user-info">
                <h4>Appointment for:</h4>
                <p><strong>Name:</strong> <?= htmlspecialchars($loggedInUsername) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($loggedInUseremail) ?></p>
            </div>

            <form method="POST" action="" id="appointmentForm">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            Doctor Name <span class="required">*</span>
                        </label>
                        <select name="drname" class="form-control" required>
                            <option value="">-- Select Doctor --</option>
                            <?php while ($row = mysqli_fetch_assoc($doctors)) { ?>
                                <option value="<?= htmlspecialchars($row['id']) ?>">
                                    Dr. <?= htmlspecialchars($row['drname']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Service Type <span class="required">*</span>
                        </label>
                        <select name="servicesname" class="form-control" required>
                            <option value="">-- Select Service --</option>
                            <?php while ($row = mysqli_fetch_assoc($services)) { ?>
                                <option value="<?= htmlspecialchars($row['id']) ?>">
                                    <?= htmlspecialchars($row['servicename']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            Pet Details <span class="required">*</span>
                        </label>
                        <input type="text" name="petdetail" class="form-control" 
                               placeholder="e.g., Golden Retriever, 3 years old, Male" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Contact Number <span class="required">*</span>
                        </label>
                        <input type="tel" name="contact" class="form-control" 
                               placeholder="+971 50 123 4567" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Location/Address <span class="required">*</span>
                    </label>
                    <input type="text" name="location" class="form-control" 
                           placeholder="Enter your address or preferred clinic location" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Message <span class="required">*</span>
                    </label>
                    <textarea name="message" class="form-control" rows="4" maxlength="200" 
                              placeholder="Please describe your pet's condition or any specific concerns..." required></textarea>
                    <small style="color: var(--gray-600); font-size: 0.85rem;">Maximum 200 characters</small>
                </div>

                <button type="submit" name="submit" class="btn-submit">
                    <i class="fas fa-calendar-check"></i>
                    Book Appointment
                </button>

                <div class="security-note">
                    <i class="fas fa-shield-alt"></i>
                    Your information is secure and will only be used for appointment scheduling
                </div>
            </form>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
<?php include 'footerlink.php'; ?>

<script>
// Enhanced form validation and debugging
document.getElementById('appointmentForm').addEventListener('submit', function(e) {
    console.log('DEBUG: Form submit event triggered');
    
    const doctor = document.querySelector('select[name="drname"]').value;
    const service = document.querySelector('select[name="servicesname"]').value;
    const petDetail = document.querySelector('input[name="petdetail"]').value.trim();
    const location = document.querySelector('input[name="location"]').value.trim();
    const contact = document.querySelector('input[name="contact"]').value.trim();
    const message = document.querySelector('textarea[name="message"]').value.trim();
    
    console.log('DEBUG: Form data:', {
        doctor: doctor,
        service: service,
        petDetail: petDetail,
        location: location,
        contact: contact,
        message: message
    });
    
    if (!doctor || !service || !petDetail || !location || !contact || !message) {
        e.preventDefault();
        console.log('DEBUG: Validation failed - missing fields');
        alert('Please fill in all required fields.');
        return false;
    }
    
    if (petDetail.length < 5) {
        e.preventDefault();
        console.log('DEBUG: Validation failed - pet detail too short');
        alert('Please provide more detailed information about your pet.');
        return false;
    }
    
    if (location.length < 10) {
        e.preventDefault();
        console.log('DEBUG: Validation failed - location too short');
        alert('Please provide a complete address or location.');
        return false;
    }
    
    if (message.length < 10) {
        e.preventDefault();
        console.log('DEBUG: Validation failed - message too short');
        alert('Please provide more details about your pet\'s condition.');
        return false;
    }
    
    console.log('DEBUG: All validations passed, submitting form');
    
    // Show loading state
    const submitBtn = document.querySelector('.btn-submit');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Booking Appointment...';
    submitBtn.disabled = true;
    
    // Allow form to submit normally
    return true;
});

// Phone number formatting
document.querySelector('input[name="contact"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    // UAE phone number format
    if (value.startsWith('971')) {
        value = '+971 ' + value.substring(3, 5) + ' ' + value.substring(5, 8) + ' ' + value.substring(8, 12);
    } else if (value.startsWith('0')) {
        value = '+971 ' + value.substring(1, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6, 10);
    }
    
    e.target.value = value;
});

// Character counter for message
const messageTextarea = document.querySelector('textarea[name="message"]');
messageTextarea.addEventListener('input', function() {
    const remaining = 200 - this.value.length;
    const small = this.parentNode.querySelector('small');
    
    if (remaining < 20) {
        small.style.color = '#ef4444';
        small.textContent = `${remaining} characters remaining`;
    } else {
        small.style.color = 'var(--gray-600)';
        small.textContent = 'Maximum 200 characters';
    }
});
</script>

</body>
</html>