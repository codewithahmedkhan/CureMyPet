<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id = '$userId'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | CureMyPet</title>
    <?php include 'headlink.php'; ?>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e5e7eb 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .dashboard-container {
            padding: 120px 0 80px;
            min-height: 100vh;
        }

        .profile-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .profile-welcome {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
            flex-shrink: 0;
        }

        .profile-details h1 {
            font-size: 2.5rem;
            margin: 0 0 0.5rem;
            color: #1e293b;
            font-weight: 700;
        }

        .profile-details p {
            margin: 0;
            color: #6b7280;
            font-size: 1.1rem;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card.primary { border-left-color: #f97316; }
        .stat-card.success { border-left-color: #14b8a6; }
        .stat-card.info { border-left-color: #3b82f6; }

        .stat-card .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #1e293b;
        }

        .stat-card .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .profile-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-card .icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .info-card.profile-info .icon {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .info-card.quick-actions .icon {
            background: linear-gradient(135deg, #14b8a6 0%, #0891b2 100%);
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e5e7eb;
            gap: 1rem;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }

        .info-value {
            color: #111827;
            font-weight: 500;
            text-align: right;
            word-break: break-word;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 320px;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, #f97316 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .action-card:hover::before {
            opacity: 0.05;
        }

        .action-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
        }

        .action-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 2rem;
            color: white !important;
            position: relative;
            z-index: 10;
            overflow: visible;
        }

        .action-card.appointments .action-icon {
            background: linear-gradient(135deg, #e97140 0%, #ea580c 100%) !important;
        }

        .action-card.orders .action-icon {
            background: linear-gradient(135deg, #14b8a6 0%, #0891b2 100%) !important;
        }

        .action-card.treatment-instructions .action-icon {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        .action-card.profile-settings .action-icon {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
        }

        .action-icon i {
            color: white !important;
            font-size: 2rem !important;
            display: block !important;
            line-height: 1 !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 15 !important;
            position: relative !important;
        }

        /* Force visibility for specific problematic icons */
        .action-card.orders .action-icon i,
        .action-card.treatment-instructions .action-icon i {
            color: white !important;
            font-size: 2rem !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 20 !important;
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        /* Backup styling in case Font Awesome fails */
        .action-icon::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            z-index: 1;
        }

        .action-card.orders .action-icon::after {
            content: "📦";
            font-size: 2rem;
            position: absolute;
            z-index: 25;
            color: white;
        }

        .action-card.treatment-instructions .action-icon::after {
            content: "📋";
            font-size: 2rem;
            position: absolute;
            z-index: 25;
            color: white;
        }

        .action-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1e293b;
            position: relative;
            z-index: 1;
        }

        .action-description {
            color: #6b7280;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .action-button {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 6px rgba(249, 115, 22, 0.3);
            margin-top: auto;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(249, 115, 22, 0.3);
            text-decoration: none;
            color: white;
        }

        .action-button.secondary {
            background: linear-gradient(135deg, #14b8a6 0%, #0891b2 100%);
            box-shadow: 0 4px 6px rgba(20, 184, 166, 0.3);
        }

        .action-button.secondary:hover {
            box-shadow: 0 8px 12px rgba(20, 184, 166, 0.3);
        }

        .action-button.tertiary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            box-shadow: 0 4px 6px rgba(99, 102, 241, 0.3);
        }

        .action-button.tertiary:hover {
            box-shadow: 0 8px 12px rgba(99, 102, 241, 0.3);
        }

        .action-button.quaternary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
        }

        .action-button.quaternary:hover {
            box-shadow: 0 8px 12px rgba(16, 185, 129, 0.3);
        }

        .logout-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logout-button {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3);
        }

        .logout-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(239, 68, 68, 0.3);
            text-decoration: none;
            color: white;
        }

        /* Enhanced Mobile Styles */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 100px 15px 60px;
            }

            .profile-header {
                padding: 1.5rem;
                border-radius: 15px;
            }

            .profile-welcome {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .profile-details h1 {
                font-size: 1.75rem;
                text-align: center;
            }

            .profile-details p {
                font-size: 1rem;
                text-align: center;
            }

            .profile-avatar {
                width: 80px;
                height: 80px;
                font-size: 2rem;
                margin: 0 auto;
            }

            .profile-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                padding: 1.25rem;
            }

            .stat-card .stat-number {
                font-size: 2rem;
            }

            .stat-card .stat-label {
                font-size: 0.75rem;
            }

            .profile-info-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .info-card {
                padding: 1.5rem;
            }

            .info-card h3 {
                font-size: 1.125rem;
                flex-wrap: wrap;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                padding: 0.75rem 0;
            }

            .info-value {
                text-align: left;
                width: 100%;
            }

            .action-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .action-card {
                padding: 1.5rem;
                min-height: 280px;
            }

            .action-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .action-title {
                font-size: 1.25rem;
            }

            .action-description {
                font-size: 0.875rem;
                margin-bottom: 1.5rem;
            }

            .action-button {
                padding: 10px 24px;
                font-size: 0.875rem;
            }

            .logout-section {
                padding: 1.5rem;
            }

            /* Quick Actions Mobile Optimization */
            .info-card.quick-actions > div {
                flex-direction: column;
            }

            .info-card.quick-actions .action-button {
                width: 100%;
                padding: 12px 20px;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 480px) {
            .dashboard-container {
                padding: 90px 10px 50px;
            }

            .profile-header {
                padding: 1.25rem;
            }

            .profile-details h1 {
                font-size: 1.5rem;
            }

            .profile-avatar {
                width: 70px;
                height: 70px;
                font-size: 1.75rem;
            }

            .stat-card .stat-number {
                font-size: 1.75rem;
            }

            .info-card {
                padding: 1.25rem;
            }

            .action-card {
                padding: 1.25rem;
                min-height: 250px;
            }

            .action-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .action-title {
                font-size: 1.125rem;
            }

            .action-description {
                font-size: 0.8125rem;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="dashboard-container">
    <div class="container">
        
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-welcome">
                <div class="profile-avatar">
                    <?= strtoupper(substr(htmlspecialchars($user['name']), 0, 1)); ?>
                </div>
                <div class="profile-details">
                    <h1>Welcome back, <?= htmlspecialchars($user['name']); ?>!</h1>
                    <p>Manage your appointments, orders, and profile settings</p>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="profile-stats">
                <?php
                // Get user statistics
                $user_appointments = mysqli_num_rows(mysqli_query($con, "SELECT id FROM form WHERE useremail = '{$user['email']}'"));
                $user_orders = mysqli_num_rows(mysqli_query($con, "SELECT id FROM orders WHERE user_id = '$userId'"));
                $member_since = date('Y', strtotime($user['created_at'] ?? date('Y-m-d')));
                ?>
                
                <div class="stat-card primary">
                    <div class="stat-number"><?= $user_appointments ?></div>
                    <div class="stat-label">Total Appointments</div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-number"><?= $user_orders ?></div>
                    <div class="stat-label">Orders Placed</div>
                </div>
                
                <div class="stat-card info">
                    <div class="stat-number"><?= date('Y') - $member_since ?></div>
                    <div class="stat-label">Years with Us</div>
                </div>
            </div>
        </div>

        <!-- Profile Information & Quick Actions -->
        <div class="profile-info-grid">
            <!-- Profile Information Card -->
            <div class="info-card profile-info">
                <h3>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    Profile Information
                </h3>
                
                <div class="info-item">
                    <span class="info-label">Full Name</span>
                    <span class="info-value"><?= htmlspecialchars($user['name']); ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Email Address</span>
                    <span class="info-value"><?= htmlspecialchars($user['email']); ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Phone Number</span>
                    <span class="info-value"><?= htmlspecialchars($user['contact'] ?? 'Not provided'); ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Member Since</span>
                    <span class="info-value"><?= date('F Y', strtotime($user['created_at'] ?? date('Y-m-d'))); ?></span>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="info-card quick-actions">
                <h3>
                    <div class="icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    Quick Actions
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                    <a href="services.php" class="action-button" style="text-align: center;">
                        <i class="fas fa-calendar-plus"></i> Book New Appointment
                    </a>
                    
                    <a href="products.php" class="action-button secondary" style="text-align: center;">
                        <i class="fas fa-shopping-cart"></i> Shop Products
                    </a>
                    
                    <a href="contact.php" class="action-button tertiary" style="text-align: center;">
                        <i class="fas fa-headset"></i> Contact Support
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Action Cards -->
        <div class="action-grid">
            <!-- Appointments Card -->
            <div class="action-card appointments">
                <div class="action-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="action-title">My Appointments</h3>
                <p class="action-description">
                    View and manage your pet's upcoming and past appointments with our veterinary team.
                </p>
                <a href="appointment_history.php" class="action-button">
                    <i class="fas fa-calendar-check"></i> View Appointments
                </a>
            </div>

            <!-- Orders Card -->
            <div class="action-card orders">
                <div class="action-icon">
                    <i class="fas fa-box" style="color: white !important; font-size: 2rem !important; display: block !important; visibility: visible !important; opacity: 1 !important; z-index: 25 !important; position: relative !important;">📦</i>
                </div>
                <h3 class="action-title">Order History</h3>
                <p class="action-description">
                    Track your product orders, delivery status, and complete purchase history.
                </p>
                <a href="product_history.php" class="action-button secondary">
                    <i class="fas fa-shopping-bag"></i> View Orders
                </a>
            </div>

            <!-- Treatment Instructions Card -->
            <div class="action-card treatment-instructions">
                <div class="action-icon">
                    <i class="fas fa-file-medical-alt" style="color: white !important; font-size: 2rem !important; display: block !important; visibility: visible !important; opacity: 1 !important; z-index: 25 !important; position: relative !important;">📋</i>
                </div>
                <h3 class="action-title">Treatment Instructions</h3>
                <p class="action-description">
                    View your medical records, treatment instructions, and prescription details.
                </p>
                <a href="treatment_instructions.php" class="action-button quaternary">
                    <i class="fas fa-notes-medical"></i> View Instructions
                </a>
            </div>

            <!-- Profile Settings Card -->
            <div class="action-card profile-settings">
                <div class="action-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="action-title">Account Settings</h3>
                <p class="action-description">
                    Update your personal information, change password, and manage preferences.
                </p>
                <a href="#" class="action-button tertiary" onclick="alert('Profile settings coming soon!')">
                    <i class="fas fa-user-cog"></i> Edit Profile
                </a>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="logout-section">
            <h4 style="margin-bottom: 1rem; color: #374151;">Ready to sign out?</h4>
            <p style="margin-bottom: 2rem; color: #6b7280;">
                We'll keep your information safe until you return.
            </p>
            <a href="logout.php" class="logout-button">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </a>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'footerlink.php'; ?>

</body>
</html>