<?php
session_start();
include 'dr_login_check.php';
include 'connection.php';

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get POST data and sanitize
        $appointment_id = mysqli_real_escape_string($con, $_POST['appointment_id']);
        $patient_name = mysqli_real_escape_string($con, $_POST['patient_name']);
        $patient_email = mysqli_real_escape_string($con, $_POST['patient_email']);
        $service = mysqli_real_escape_string($con, $_POST['service']);
        $contact = mysqli_real_escape_string($con, $_POST['contact']);
        $location = mysqli_real_escape_string($con, $_POST['location']);
        
        // Validate email
        if (!filter_var($patient_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address');
        }
        
        // Get doctor information
        $doctor_id = $_SESSION['dr_id'];
        $doctor_query = mysqli_query($con, "SELECT drname FROM doctor WHERE id = '$doctor_id'");
        if (!$doctor_query || mysqli_num_rows($doctor_query) == 0) {
            throw new Exception('Doctor not found');
        }
        $doctor_data = mysqli_fetch_assoc($doctor_query);
        $doctor_name = $doctor_data['drname'];
        
        // Generate email content - Avoid spam trigger words
        $subject = "Your Upcoming Appointment at CureMyPet Clinic";
        $message = generateEmailTemplate($patient_name, $doctor_name, $service, $location, $contact);
        
        // Check if PHPMailer exists
        $phpmailer_loaded = false;
        if (file_exists('../vendor/autoload.php')) {
            require_once '../vendor/autoload.php';
            $phpmailer_loaded = true;
        } elseif (file_exists('PHPMailer/PHPMailerAutoload.php')) {
            require_once 'PHPMailer/PHPMailerAutoload.php';
            $phpmailer_loaded = true;
        }
        
        if ($phpmailer_loaded) {
            // Use PHPMailer with SMTP
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'add yours';
            $mail->Password = 'add yours';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            
            // Recipients and headers
            $mail->setFrom('ahmedkhavn2005@gmail.com', 'CureMyPet Clinic');
            $mail->addAddress($patient_email, $patient_name);
            $mail->addReplyTo('ahmedkhavn2005@gmail.com', 'CureMyPet Clinic');
            
            // Anti-spam headers
            $mail->addCustomHeader('X-Priority', '3');
            $mail->addCustomHeader('X-Mailer', 'CureMyPet Appointment System');
            $mail->addCustomHeader('X-Auto-Response-Suppress', 'All');
            
            // Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Subject = $subject;
            $mail->Body = $message;
            
            if ($mail->send()) {
                // Log the email
                $create_log_table = "CREATE TABLE IF NOT EXISTS email_logs (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    appointment_id INT,
                    patient_email VARCHAR(255),
                    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    sent_by INT,
                    status VARCHAR(50) DEFAULT 'sent'
                )";
                mysqli_query($con, $create_log_table);
                
                $log_query = "INSERT INTO email_logs (appointment_id, patient_email, sent_at, sent_by, status) 
                              VALUES ('$appointment_id', '$patient_email', NOW(), '$doctor_id', 'sent_smtp')";
                mysqli_query($con, $log_query);
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Reminder email sent successfully to ' . $patient_email . '!'
                ]);
            } else {
                throw new Exception('Mailer Error: ' . $mail->ErrorInfo);
            }
            
        } else {
            // Fallback to mail() function with anti-spam headers
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: CureMyPet Clinic <ahmedkhavn2005@gmail.com>\r\n";
            $headers .= "Reply-To: ahmedkhavn2005@gmail.com\r\n";
            $headers .= "Return-Path: ahmedkhavn2005@gmail.com\r\n";
            $headers .= "X-Mailer: CureMyPet Appointment System\r\n";
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Auto-Response-Suppress: All\r\n";
            
            $email_sent = mail($patient_email, $subject, $message, $headers);
            
            if ($email_sent) {
                // Log the email
                $create_log_table = "CREATE TABLE IF NOT EXISTS email_logs (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    appointment_id INT,
                    patient_email VARCHAR(255),
                    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    sent_by INT,
                    status VARCHAR(50) DEFAULT 'sent'
                )";
                mysqli_query($con, $create_log_table);
                
                $log_query = "INSERT INTO email_logs (appointment_id, patient_email, sent_at, sent_by, status) 
                              VALUES ('$appointment_id', '$patient_email', NOW(), '$doctor_id', 'sent_mail')";
                mysqli_query($con, $log_query);
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Reminder email sent successfully to ' . $patient_email . '!'
                ]);
            } else {
                throw new Exception('Failed to send email. Please install PHPMailer for better reliability.');
            }
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

function generateEmailTemplate($patient_name, $doctor_name, $service, $location, $contact) {
    $current_date = date('l, F j, Y');
    $current_time = date('g:i A');
    
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Appointment Reminder - CureMyPet</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .header {
                background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
                color: white;
                padding: 30px;
                text-align: center;
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
                font-weight: bold;
            }
            .content {
                padding: 40px 30px;
            }
            .greeting {
                font-size: 18px;
                color: #e97140;
                margin-bottom: 20px;
                font-weight: bold;
            }
            .reminder-box {
                background: linear-gradient(135deg, #fff5f0 0%, #fef2f2 100%);
                border-left: 5px solid #e97140;
                padding: 25px;
                margin: 25px 0;
                border-radius: 5px;
            }
            .appointment-details {
                background: #f8fafc;
                padding: 20px;
                border-radius: 8px;
                margin: 20px 0;
            }
            .detail-row {
                margin-bottom: 10px;
                padding: 8px 0;
                border-bottom: 1px solid #e5e7eb;
            }
            .detail-label {
                font-weight: bold;
                color: #374151;
                display: inline-block;
                width: 100px;
            }
            .detail-value {
                color: #6b7280;
            }
            .footer {
                background: #374151;
                color: white;
                padding: 30px;
                text-align: center;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>CureMyPet Veterinary Clinic</h1>
                <p>Professional Pet Care Services</p>
            </div>
            
            <div class="content">
                <div class="greeting">Dear ' . htmlspecialchars($patient_name) . ',</div>
                
                <div class="reminder-box">
                    <h2 style="color: #e97140; margin-top: 0;">&#128276; Appointment Reminder</h2>
                    <p>This is a friendly reminder about your upcoming appointment with our veterinary team.</p>
                </div>
                
                <div class="appointment-details">
                    <h3 style="color: #374151; margin-top: 0;">&#128203; Appointment Details</h3>
                    <div class="detail-row">
                        <span class="detail-label">&#129658; Doctor:</span>
                        <span class="detail-value">Dr. ' . htmlspecialchars($doctor_name) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">&#127973; Service:</span>
                        <span class="detail-value">' . htmlspecialchars($service) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">&#128205; Location:</span>
                        <span class="detail-value">' . htmlspecialchars($location) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">&#128222; Contact:</span>
                        <span class="detail-value">' . htmlspecialchars($contact) . '</span>
                    </div>
                </div>
                
                <p><strong>Warm regards,</strong><br>
                Dr. ' . htmlspecialchars($doctor_name) . ' & The CureMyPet Team</p>
            </div>
            
            <div class="footer">
                <p><strong>CureMyPet Veterinary Clinic</strong></p>
                <p>' . htmlspecialchars($location) . '</p>
                <p>&#128222; ' . htmlspecialchars($contact) . ' | &#128231; ahmedkhavn2005@gmail.com</p>
                <p style="font-size: 12px; margin-top: 20px;">
                    © ' . date('Y') . ' CureMyPet Veterinary Clinic. All rights reserved.
                </p>
            </div>
        </div>
    </body>
    </html>';
}
?>
