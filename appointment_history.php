<?php
session_start();
include 'connection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$loggedInUserId = $_SESSION['user_id'];

// Fetch user email
$userResult = mysqli_query($con, "SELECT email FROM user WHERE id = '$loggedInUserId'");
$user = mysqli_fetch_assoc($userResult);
$userEmail = $user['email'];

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_appointment'])) {
    $appointmentId = intval($_POST['appointment_id']);
    mysqli_query($con, "DELETE FROM form WHERE id = '$appointmentId' AND useremail = '$userEmail'");
    header("Location: appointment_history.php");
    exit();
}

// Fetch appointment history
$query = "SELECT f.*, d.drname, s.servicename 
          FROM form f
          JOIN doctor d ON f.drname = d.id
          JOIN services s ON f.servicesname = s.id
          WHERE f.useremail = '$userEmail'
          ORDER BY f.id DESC";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History | CureMyPet</title>
    <?php include 'headlink.php'; ?>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e5e7eb 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .history-container {
            padding: 120px 0 80px;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(135deg, var(--primary-orange) 0%, #ea580c 100%);
        }

        .page-header h1 {
            font-size: 2.5rem;
            margin: 0 0 0.5rem;
            color: var(--dark-navy);
            font-weight: 700;
        }

        .page-header p {
            margin: 0;
            color: var(--gray-600);
            font-size: 1.1rem;
        }

        .back-link {
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .back-link:hover {
            background: var(--gray-200);
            color: var(--gray-900);
            text-decoration: none;
        }

        .appointments-container {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state .icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-orange) 0%, #ea580c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--gray-700);
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: 2rem;
        }

        .appointment-grid {
            display: grid;
            gap: 1.5rem;
        }

        .appointment-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .appointment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-orange);
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .appointment-id {
            background: var(--primary-orange);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .appointment-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .appointment-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            color: var(--gray-900);
            font-weight: 600;
        }

        .appointment-actions {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .action-button {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #ea580c 100%);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(249, 115, 22, 0.3);
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(249, 115, 22, 0.3);
            text-decoration: none;
            color: white;
        }

        /* Enhanced Mobile Styles */
        @media (max-width: 768px) {
            .history-container {
                padding: 100px 15px 60px;
            }

            .page-header {
                padding: 1.5rem;
                border-radius: 15px;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .page-header p {
                font-size: 1rem;
            }

            .appointments-container {
                padding: 1.5rem;
                border-radius: 15px;
            }

            .appointment-card {
                padding: 1.25rem;
            }

            .appointment-header {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .appointment-details {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .detail-item {
                padding: 0.75rem;
                background: var(--gray-50);
                border-radius: 8px;
            }

            .appointment-actions {
                justify-content: center;
            }

            .btn-delete {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .history-container {
                padding: 90px 10px 50px;
            }

            .page-header {
                padding: 1.25rem;
            }

            .page-header h1 {
                font-size: 1.75rem;
            }

            .appointments-container {
                padding: 1.25rem;
            }

            .appointment-card {
                padding: 1rem;
                border-radius: 12px;
            }

            .appointment-id {
                font-size: 0.75rem;
                padding: 3px 10px;
            }

            .appointment-status {
                font-size: 0.7rem;
                padding: 3px 10px;
            }

            .detail-label {
                font-size: 0.75rem;
            }

            .detail-value {
                font-size: 0.875rem;
            }

            .back-link {
                font-size: 0.875rem;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="history-container">
    <div class="container">
        
       

        <!-- Page Header -->
        <div class="page-header">
            <h1>Appointment History</h1>
            <p>View and manage your pet's appointments</p>
        </div>

          <!-- Back Link -->
        <a href="userprofile.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <!-- Appointments Container -->
        <div class="appointments-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="appointment-grid">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="appointment-card">
                            <!-- Appointment Header -->
                            <div class="appointment-header">
                                <div class="appointment-id">
                                    #<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?>
                                </div>
                            </div>

                            <!-- Appointment Details -->
                            <div class="appointment-details">
                                <div class="detail-item">
                                    <span class="detail-label">Doctor</span>
                                    <span class="detail-value">
                                        <i class="fas fa-user-md" style="color: var(--primary-orange); margin-right: 0.5rem;"></i>
                                        <?= htmlspecialchars($row['drname']) ?>
                                    </span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label">Service</span>
                                    <span class="detail-value">
                                        <i class="fas fa-stethoscope" style="color: var(--primary-teal); margin-right: 0.5rem;"></i>
                                        <?= htmlspecialchars($row['servicename']) ?>
                                    </span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label">Pet Details</span>
                                    <span class="detail-value">
                                        <i class="fas fa-paw" style="color: var(--primary-orange); margin-right: 0.5rem;"></i>
                                        <?= htmlspecialchars($row['petdetail']) ?>
                                    </span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label">Location</span>
                                    <span class="detail-value">
                                        <i class="fas fa-map-marker-alt" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                                        <?= htmlspecialchars($row['location']) ?>
                                    </span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label">Contact</span>
                                    <span class="detail-value">
                                        <i class="fas fa-phone" style="color: var(--primary-teal); margin-right: 0.5rem;"></i>
                                        <?= htmlspecialchars($row['contact']) ?>
                                    </span>
                                </div>

                                <?php if (!empty($row['message'])): ?>
                                <div class="detail-item" style="grid-column: 1 / -1;">
                                    <span class="detail-label">Message</span>
                                    <span class="detail-value">
                                        <i class="fas fa-comment" style="color: var(--gray-500); margin-right: 0.5rem;"></i>
                                        <?= htmlspecialchars($row['message']) ?>
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Appointment Actions -->
                            <div class="appointment-actions">
                                <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');" style="margin: 0;">
                                    <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete_appointment" class="btn-delete">
                                        <i class="fas fa-trash"></i> Cancel Appointment
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3>No appointments found</h3>
                    <p>You haven't made any appointments yet. Book your first appointment to get started!</p>
                    <a href="services.php" class="action-button">
                        <i class="fas fa-calendar-plus"></i> Book Appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'footerlink.php'; ?>

</body>
</html>
