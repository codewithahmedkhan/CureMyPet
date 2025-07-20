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

// Fetch treatment records for this user from the existing record table
$treatmentQuery = "SELECT r.*, s.servicename 
                  FROM record r 
                  LEFT JOIN services s ON r.servicesname = s.id 
                  WHERE r.useremail = '{$user['email']}' 
                  ORDER BY r.id DESC";
$treatmentResult = mysqli_query($con, $treatmentQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment Instructions | CureMyPet</title>
    <?php include 'headlink.php'; ?>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e5e7eb 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .page-container {
            padding: 120px 0 80px;
            min-height: 100vh;
        }

        .page-header {
            background: linear-gradient(135deg, #e86f3f 0%, #d6612d 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 20px rgba(232, 111, 63, 0.2);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .page-header p {
            font-size: 1rem;
            opacity: 0.95;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .back-button {
            background: white;
            color: #10b981;
            border: 2px solid #10b981;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            margin-bottom: 3rem;
            font-size: 0.9rem;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
        }

        .back-button:hover {
            background: #10b981;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .treatment-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #10b981;
            transition: all 0.3s ease;
        }

        .treatment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .treatment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .doctor-info h3 {
            color: #065f46;
            margin: 0 0 0.4rem 0;
            font-size: 1.15rem;
            font-weight: 700;
        }

        .service-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .treatment-id {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .info-section {
            margin-bottom: 1.25rem;
        }

        .info-section h4 {
            color: #065f46;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .info-section h4 i {
            color: #10b981;
            width: 20px;
        }

        .info-content {
            background: #f9fafb;
            padding: 1rem;
            border-radius: 10px;
            line-height: 1.5;
            white-space: pre-line;
            border-left: 3px solid #10b981;
            font-size: 0.9rem;
        }

        .prescription-content {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-left: 3px solid #10b981;
        }

        .bill-content {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 3px solid #f59e0b;
            font-weight: 700;
            font-size: 1rem;
            color: #92400e;
        }

        .pet-details {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.8rem;
            color: #6b7280;
            font-size: 0.85rem;
            margin-top: 0.8rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            color: #374151;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .cta-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            color: white;
            text-decoration: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.25rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 800;
            color: #10b981;
            margin-bottom: 0.4rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Enhanced Mobile Styles */
        @media (max-width: 768px) {
            .page-container {
                padding: 100px 15px 60px;
            }

            .page-header {
                padding: 1.5rem;
                border-radius: 12px;
            }

            .page-header h1 {
                font-size: 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .page-header h1 i {
                font-size: 1.25rem;
            }

            .page-header p {
                font-size: 0.875rem;
                margin-top: 0.5rem;
            }

            .back-button {
                font-size: 0.875rem;
                padding: 8px 16px;
                margin-bottom: 2rem;
            }

            .treatment-header {
                flex-direction: column;
                gap: 0.75rem;
                align-items: flex-start;
            }

            .treatment-card {
                padding: 1.25rem;
                border-radius: 12px;
                margin-bottom: 1.25rem;
            }

            .doctor-info h3 {
                font-size: 1.05rem;
                margin-bottom: 0.5rem;
            }

            .service-badge {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }

            .treatment-id {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }

            .info-section {
                margin-bottom: 1rem;
            }

            .info-section h4 {
                font-size: 0.875rem;
                gap: 0.3rem;
            }

            .info-section h4 i {
                font-size: 0.875rem;
                width: 16px;
            }

            .info-content {
                padding: 0.875rem;
                font-size: 0.85rem;
                border-radius: 8px;
            }

            .pet-details {
                padding: 0.75rem;
                font-size: 0.8rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .stat-card {
                padding: 1rem;
                border-radius: 10px;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .empty-state {
                padding: 3rem 1.5rem;
                border-radius: 15px;
            }

            .empty-state i {
                font-size: 3rem;
            }

            .empty-state h3 {
                font-size: 1.25rem;
            }

            .empty-state p {
                font-size: 0.875rem;
            }

            .cta-button {
                padding: 12px 24px;
                font-size: 0.875rem;
            }

            /* Important Notice Mobile */
            div[style*="margin-top: 2rem"] {
                margin-top: 1.5rem !important;
                padding: 1.25rem !important;
                border-radius: 12px !important;
            }

            div[style*="margin-top: 2rem"] p {
                font-size: 0.85rem !important;
            }
        }

        @media (max-width: 480px) {
            .page-container {
                padding: 90px 10px 50px;
            }

            .page-header {
                padding: 1.25rem;
            }

            .page-header h1 {
                font-size: 1.25rem;
                flex-direction: column;
                text-align: center;
            }

            .treatment-card {
                padding: 1rem;
                border-left-width: 3px;
            }

            .doctor-info h3 {
                font-size: 1rem;
            }

            .info-content {
                padding: 0.75rem;
                font-size: 0.8rem;
            }

            .bill-content {
                font-size: 0.9rem;
            }

            .stat-number {
                font-size: 1.25rem;
            }

            .back-button {
                font-size: 0.8rem;
                padding: 6px 12px;
            }

            .empty-state {
                padding: 2.5rem 1rem;
            }

            .empty-state h3 {
                font-size: 1.125rem;
            }

            .empty-state p {
                font-size: 0.8rem;
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="page-container">
    <div class="container">
        
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-file-medical mr-3"></i>Treatment Instructions & Medical Records</h1>
            <p>View your complete medical history, treatment records, and doctor instructions</p>
        </div>

        <!-- Back Button -->
        <a href="userprofile.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Profile
        </a>

        <?php if ($treatmentResult && mysqli_num_rows($treatmentResult) > 0): ?>
            
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?= mysqli_num_rows($treatmentResult); ?></div>
                    <div class="stat-label">Total Treatments</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">
                        <?php 
                        // Count unique doctors
                        mysqli_data_seek($treatmentResult, 0);
                        $doctors = [];
                        while ($temp = mysqli_fetch_assoc($treatmentResult)) {
                            $doctors[$temp['drname']] = true;
                        }
                        echo count($doctors);
                        mysqli_data_seek($treatmentResult, 0); // Reset pointer
                        ?>
                    </div>
                    <div class="stat-label">Doctors Consulted</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">
                        <?php 
                        // Calculate total bill
                        $totalBill = 0;
                        while ($temp = mysqli_fetch_assoc($treatmentResult)) {
                            if (!empty($temp['bill']) && is_numeric($temp['bill'])) {
                                $totalBill += floatval($temp['bill']);
                            }
                        }
                        mysqli_data_seek($treatmentResult, 0); // Reset pointer
                        echo 'AED ' . number_format($totalBill, 0);
                        ?>
                    </div>
                    <div class="stat-label">Total Spent</div>
                </div>
            </div>

            <!-- Treatment Records -->
            <div class="treatment-records">
                <?php while ($record = mysqli_fetch_assoc($treatmentResult)): ?>
                <div class="treatment-card">
                    <div class="treatment-header">
                        <div class="doctor-info">
                            <h3>Dr. <?= htmlspecialchars($record['drname']); ?></h3>
                            <span class="service-badge">
                                <?= htmlspecialchars($record['servicename'] ?? 'General Care'); ?>
                            </span>
                        </div>
                        <div class="treatment-id">
                            Treatment #<?= $record['id']; ?>
                        </div>
                    </div>
                    
                    <!-- Medical Record Summary -->
                    <?php if (!empty($record['record'])): ?>
                    <div class="info-section">
                        <h4><i class="fas fa-file-medical-alt"></i>Medical Record & Diagnosis</h4>
                        <div class="info-content">
                            <?= htmlspecialchars($record['record']); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Prescription & Instructions -->
                    <?php if (!empty($record['prescription'])): ?>
                    <div class="info-section">
                        <h4><i class="fas fa-pills"></i>Prescription & Treatment Instructions</h4>
                        <div class="info-content prescription-content">
                            <?= htmlspecialchars($record['prescription']); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Bill Information -->
                    <?php if (!empty($record['bill'])): ?>
                    <div class="info-section">
                        <h4><i class="fas fa-dollar-sign"></i>Treatment Cost</h4>
                        <div class="info-content bill-content">
                            AED <?= htmlspecialchars($record['bill']); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Pet Details -->
                    <?php if (!empty($record['petdetail'])): ?>
                    <div class="pet-details">
                        <h5 style="color: #6b7280; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.5rem;">
                            <i class="fas fa-paw" style="margin-right: 0.5rem;"></i>Pet Information
                        </h5>
                        <?= htmlspecialchars($record['petdetail']); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>

        <?php else: ?>
            
            <!-- Empty State -->
            <div class="empty-state">
                <i class="fas fa-file-medical-alt"></i>
                <h3>No Treatment Records Found</h3>
                <p>You don't have any treatment records yet. Your medical history and treatment instructions will appear here after your appointments.</p>
                <a href="form.php" class="cta-button">
                    <i class="fas fa-calendar-plus"></i>
                    Book an Appointment
                </a>
            </div>

        <?php endif; ?>

        <!-- Important Notice -->
        <div style="margin-top: 2rem; padding: 1.5rem; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 15px; border-left: 5px solid #3b82f6;">
            <p style="margin: 0; color: #1e40af; font-size: 0.95rem; line-height: 1.6;">
                <i class="fas fa-info-circle" style="margin-right: 0.5rem; color: #3b82f6;"></i>
                <strong>Important:</strong> These medical records and treatment instructions are provided by your veterinarian. Please follow all instructions carefully and contact your doctor immediately if you have any questions or if your pet's condition changes. Keep these records for your pet's health history.
            </p>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'footerlink.php'; ?>

</body>
</html>