<?php
session_start();
include "dr_login_check.php";
include "connection.php";

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

// Get the logged-in doctor's ID from session
$logged_doctor_id = $_SESSION['dr_id'];

// Fetch only appointments assigned to the logged-in doctor
$query = "SELECT 
            f.*, 
            d.drname AS doctor_name, 
            s.servicename AS service_name
          FROM form f
          LEFT JOIN doctor d ON f.drname = d.id
          LEFT JOIN services s ON f.servicesname = s.id
          WHERE f.drname = '$logged_doctor_id'
          ORDER BY f.id DESC";

$result = mysqli_query($con, $query);

// Get appointment statistics for the logged-in doctor
$total_appointments = mysqli_num_rows($result);
$today_appointments = mysqli_num_rows(mysqli_query($con, "SELECT id FROM form WHERE drname = '$logged_doctor_id' AND DATE(created_at) = CURDATE()"));

// Get doctor's name for display
$doctor_query = mysqli_query($con, "SELECT drname FROM doctor WHERE id = '$logged_doctor_id'");
$doctor_data = mysqli_fetch_assoc($doctor_query);
$doctor_name = $doctor_data['drname'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Doctor Panel - Appointments</title>

   <?php include 'headlink.php'?>
   <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #fff5f0 100%);
        }
        
        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(233, 113, 64, 0.1);
            color: white;
        }
        
        .page-heading h1 {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: white;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
            border: none;
        }
        
        .table {
            font-size: 0.875rem;
        }
        
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
            color: #4b5563;
            border-top: 1px solid #e5e7eb;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: #f9fafb;
        }
        
        /* Sidebar navigation hover effects */
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            margin: 0 0.5rem;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
       <?php include 'sidebar.php'?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
     <?php include "nav.php"?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="page-heading">
                        <div class="d-flex align-items-center">
                            <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 40px; margin-right: 1rem; filter: brightness(0) invert(1);">
                            <h1>Appointments Management</h1>
                        </div>
                        <div>
                            <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">
                                <?php echo date('l, F j, Y'); ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Appointments</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_appointments ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Today's Appointments</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $today_appointments ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Appointments - Dr. <?= htmlspecialchars($doctor_name) ?></h6>
                        </div>
                   
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th> <!-- User Name -->
                <th>Doctor</th> <!-- Doctor Name -->
                <th>Service</th> <!-- Service Name -->
                <th>Pet Detail</th>
                <th>Location</th>
                <th>Contact</th>
                <th>Message</th>
                <th>User Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['uername']) . "</td>"; // User Name
            echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>"; // Doctor Name from JOIN
            echo "<td>" . htmlspecialchars($row['service_name']) . "</td>"; // Service Name from JOIN
            echo "<td>" . htmlspecialchars($row['petdetail']) . "</td>";
            echo "<td>" . htmlspecialchars($row['location']) . "</td>";
            echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
            echo "<td>" . htmlspecialchars($row['message']) . "</td>";
            echo "<td>" . htmlspecialchars($row['useremail']) . "</td>";
            echo "<td>
                    <button class='btn btn-sm btn-warning send-reminder-btn' 
                            data-appointment-id='" . $row['id'] . "'
                            data-patient-name='" . htmlspecialchars($row['uername']) . "'
                            data-patient-email='" . htmlspecialchars($row['useremail']) . "'
                            data-service='" . htmlspecialchars($row['service_name']) . "'
                            data-contact='" . htmlspecialchars($row['contact']) . "'
                            data-location='" . htmlspecialchars($row['location']) . "'
                            title='Send appointment reminder'>
                        <i class='fas fa-envelope'></i> Remind
                    </button>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
    }
    ?>
</tbody>

    </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CureMyPet 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    
    <!-- Notification Toast -->
    <div id="emailNotification" class="email-notification" style="display: none;">
        <div class="notification-content">
            <i class="notification-icon"></i>
            <div class="notification-text">
                <h6 class="notification-title">Email Status</h6>
                <span class="notification-message"></span>
            </div>
            <button class="notification-close" onclick="closeNotification()">&times;</button>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
   <?php include 'footerlink.php'?>
   
   <style>
   /* Notification Styles - Enhanced for better visibility */
   .email-notification {
       position: fixed;
       top: 80px;
       right: 20px;
       z-index: 999999;
       min-width: 300px;
       max-width: 450px;
       border-radius: 12px;
       box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
       animation: slideInRight 0.3s ease;
       background: white;
       border: 1px solid rgba(0, 0, 0, 0.1);
   }
   
   .notification-content {
       padding: 20px 24px;
       background: white;
       border-radius: 12px;
       display: flex;
       align-items: center;
       gap: 16px;
       position: relative;
   }
   
   .notification-content.success {
       border-left: 5px solid #10b981;
       background: linear-gradient(to right, #f0fdf4, white);
   }
   
   .notification-content.error {
       border-left: 5px solid #ef4444;
       background: linear-gradient(to right, #fef2f2, white);
   }
   
   .notification-icon {
       font-size: 24px;
       line-height: 1;
       display: inline-block;
       min-width: 24px;
   }
   
   .notification-content.success .notification-icon {
       color: #10b981;
   }
   
   .notification-content.success .notification-icon::before {
       content: '✓';
       font-weight: bold;
       background: #10b981;
       color: white;
       width: 24px;
       height: 24px;
       display: inline-flex;
       align-items: center;
       justify-content: center;
       border-radius: 50%;
       font-size: 14px;
   }
   
   .notification-content.error .notification-icon {
       color: #ef4444;
   }
   
   .notification-content.error .notification-icon::before {
       content: '✕';
       font-weight: bold;
       background: #ef4444;
       color: white;
       width: 24px;
       height: 24px;
       display: inline-flex;
       align-items: center;
       justify-content: center;
       border-radius: 50%;
       font-size: 14px;
   }
   
   .notification-text {
       flex: 1;
   }
   
   .notification-title {
       font-size: 14px;
       font-weight: 600;
       color: #111827;
       margin: 0 0 4px 0;
   }
   
   .notification-message {
       font-weight: 400;
       color: #4b5563;
       font-size: 13px;
       line-height: 1.5;
       display: block;
   }
   
   .notification-close {
       background: none;
       border: none;
       font-size: 20px;
       color: #6b7280;
       cursor: pointer;
       padding: 0;
       width: 24px;
       height: 24px;
       display: flex;
       align-items: center;
       justify-content: center;
       border-radius: 4px;
       transition: all 0.2s;
       margin-left: 8px;
   }
   
   .notification-close:hover {
       background: #f3f4f6;
       color: #374151;
   }
   
   @keyframes slideInRight {
       from {
           transform: translateX(100%);
           opacity: 0;
       }
       to {
           transform: translateX(0);
           opacity: 1;
       }
   }
   
   @keyframes slideOutRight {
       from {
           transform: translateX(0);
           opacity: 1;
       }
       to {
           transform: translateX(100%);
           opacity: 0;
       }
   }
   </style>
   
   <script>
   $(document).ready(function() {
       $('.send-reminder-btn').click(function() {
           var button = $(this);
           var appointmentId = button.data('appointment-id');
           var patientName = button.data('patient-name');
           var patientEmail = button.data('patient-email');
           var service = button.data('service');
           var contact = button.data('contact');
           var location = button.data('location');
           
           // Disable button and show loading
           button.prop('disabled', true);
           button.html('<i class="fas fa-spinner fa-spin"></i> Sending...');
           
           $.ajax({
               url: 'send_reminder.php',
               type: 'POST',
               data: {
                   appointment_id: appointmentId,
                   patient_name: patientName,
                   patient_email: patientEmail,
                   service: service,
                   contact: contact,
                   location: location
               },
               dataType: 'json',
               success: function(response) {
                   if (response.success) {
                       showNotification(response.message, 'success');
                       // Fallback alert
                       if ($('#emailNotification:visible').length === 0) {
                           alert('✅ ' + response.message);
                       }
                   } else {
                       showNotification(response.message, 'error');
                       // Fallback alert
                       if ($('#emailNotification:visible').length === 0) {
                           alert('❌ ' + response.message);
                       }
                   }
               },
               error: function(xhr, status, error) {
                   var errorMessage = 'An error occurred while sending the reminder email.';
                   showNotification(errorMessage, 'error');
                   // Fallback alert
                   if ($('#emailNotification:visible').length === 0) {
                       alert('❌ ' + errorMessage + '\n\nDetails: ' + error);
                   }
               },
               complete: function() {
                   // Re-enable button
                   button.prop('disabled', false);
                   button.html('<i class="fas fa-envelope"></i> Remind');
               }
           });
       });
   });
   
   function showNotification(message, type) {
       var notification = $('#emailNotification');
       var content = notification.find('.notification-content');
       var titleElement = notification.find('.notification-title');
       var messageElement = notification.find('.notification-message');
       
       // Update title based on type
       if (type === 'success') {
           titleElement.text('Success!');
       } else {
           titleElement.text('Error');
       }
       
       // Update message and type
       messageElement.text(message);
       content.removeClass('success error').addClass(type);
       
       // Show notification with animation
       notification.css('display', 'block').hide().fadeIn(300);
       
       // Auto hide after 5 seconds
       setTimeout(function() {
           closeNotification();
       }, 5000);
   }
   
   function closeNotification() {
       var notification = $('#emailNotification');
       notification.fadeOut(300, function() {
           $(this).css('display', 'none');
       });
   }
   </script>

</body>

</html>