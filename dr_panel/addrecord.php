<?php
session_start();
include 'dr_login_check.php';
include 'connection.php';

// Set the timezone to Dubai (UAE)
date_default_timezone_set('Asia/Dubai');

// Fetch required data for dropdowns
$services = mysqli_query($con, "SELECT id, servicename FROM services ORDER BY servicename ASC");

// Fetch patients with appointments for this doctor
$dr_id = $_SESSION['dr_id'];
$appointmentPatients = mysqli_query($con, "
    SELECT DISTINCT f.useremail, f.uername, f.contact, f.location, f.petdetail, f.servicesname, s.servicename, f.id as appointment_id
    FROM form f 
    LEFT JOIN services s ON f.servicesname = s.id 
    WHERE f.drname = '$dr_id' 
    ORDER BY f.id DESC
");

// Handle form submission
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $service_id = $_POST['service_id'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];
    $petdetail = $_POST['petdetail'];
    $record = $_POST['record'];
    $bill = $_POST['bill'];
    $prescription = $_POST['prescription'];
    $useremail = $_POST['useremail'];
    $dr_id = $_SESSION['dr_id'];

    // Fetch doctor name from session
    $doctorQuery = mysqli_query($con, "SELECT drname FROM doctor WHERE id = '$dr_id'");
    $doctorRow = mysqli_fetch_assoc($doctorQuery);
    $drname = $doctorRow['drname'];

    // SECURITY CHECK: Verify that the doctor has an appointment with this patient
    $appointmentCheck = mysqli_query($con, "
        SELECT f.id, f.useremail, f.uername 
        FROM form f 
        WHERE f.drname = '$dr_id' 
        AND f.useremail = '$useremail' 
        AND f.servicesname = '$service_id'
        ORDER BY f.id DESC 
        LIMIT 1
    ");

    if (mysqli_num_rows($appointmentCheck) == 0) {
        echo "<script>alert('Error: You can only provide treatment to patients who have booked an appointment with you for this service.'); window.location.href='addrecord.php';</script>";
        exit();
    }

    // Get appointment details for validation
    $appointmentData = mysqli_fetch_assoc($appointmentCheck);
    
    // Verify that the patient name matches the appointment
    if (strtolower(trim($username)) !== strtolower(trim($appointmentData['uername']))) {
        echo "<script>alert('Error: Patient name does not match the appointment record. Please verify the patient details.'); window.location.href='addrecord.php';</script>";
        exit();
    }

    // Insert into `record` table (make sure columns match)
    $query = "INSERT INTO record 
        (username, drname, servicesname, record, bill, prescription, location, contact, petdetail, useremail) 
        VALUES 
        ('$username', '$drname', '$service_id', '$record', '$bill', '$prescription', '$location', '$contact', '$petdetail', '$useremail')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Treatment record added successfully! The treatment details have been saved to the patient records.'); window.location.href='treatment.php';</script>";
    } else {
        die("Error: " . mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Medical Record</title>
    <?php include 'headlink.php'; ?>
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
        
        .btn-primary {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(233, 113, 64, 0.2);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #d6612d 0%, #ea580c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(233, 113, 64, 0.3);
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(233, 113, 64, 0.1);
            background: white;
            margin-bottom: 2rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, #fff 0%, #fff5f0 100%);
            border-bottom: 2px solid #e97140;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem 2rem;
        }
        
        .card-header h3 {
            color: #e97140;
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem;
        }
        
        .card-body {
            padding: 2.5rem;
        }
        
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid #e97140;
        }
        
        .form-section-title {
            color: #e97140;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .form-section-title i {
            margin-right: 0.5rem;
        }
        
        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .form-col {
            flex: 1;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }
        
        /* Base form control styling */
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
            line-height: 1.5;
            width: 100%;
            display: block;
        }
        
        /* ULTIMATE SELECT FIX - This will override everything */
        select.form-control,
        select#service_id,
        #service_id {
            /* Reset all appearance */
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            
            /* Force text color - ULTIMATE OVERRIDE */
            color: #1f2937 !important;
            background-color: #ffffff !important;
            
            /* Basic styling */
            border: 2px solid #e97140 !important;
            border-radius: 10px !important;
            padding: 14px 40px 14px 16px !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            line-height: 1.5 !important;
            width: 100% !important;
            height: auto !important;
            min-height: 50px !important;
            
            /* Custom dropdown arrow */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23e97140' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 8 4 4 4-4'/%3e%3c/svg%3e") !important;
            background-position: right 12px center !important;
            background-repeat: no-repeat !important;
            background-size: 16px 12px !important;
            
            cursor: pointer !important;
            outline: none !important;
        }
        
        /* Force text visibility on all states */
        select.form-control:focus,
        select#service_id:focus,
        #service_id:focus,
        select.form-control:active,
        select#service_id:active,
        #service_id:active,
        select.form-control:valid,
        select#service_id:valid,
        #service_id:valid {
            color: #1f2937 !important;
            background-color: #ffffff !important;
            border-color: #e97140 !important;
            box-shadow: 0 0 0 3px rgba(233, 113, 64, 0.1) !important;
        }
        
        /* Option styling with extreme specificity */
        select.form-control option,
        select#service_id option,
        #service_id option {
            padding: 12px 16px !important;
            background-color: #ffffff !important;
            color: #1f2937 !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            line-height: 1.5 !important;
            border: none !important;
        }
        
        /* Selected option styling */
        select.form-control option:checked,
        select#service_id option:checked,
        #service_id option:checked {
            background-color: #e97140 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
        }
        
        /* Disabled option (placeholder) */
        select.form-control option[disabled],
        select#service_id option[disabled],
        #service_id option[disabled] {
            color: #9ca3af !important;
            background-color: #f9fafb !important;
            font-style: italic !important;
        }
        
        /* Focus state for all form controls */
        .form-control:focus {
            outline: none;
            border-color: #e97140;
            box-shadow: 0 0 0 3px rgba(233, 113, 64, 0.1);
            transform: translateY(-1px);
        }
        
        /* Placeholder styling for regular inputs */
        .form-control::placeholder {
            color: #9ca3af;
            font-style: italic;
        }
        
        /* Textarea specific styling */
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #e97140 0%, #f97316 100%);
            border: none;
            border-radius: 12px;
            padding: 16px 32px;
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(233, 113, 64, 0.3);
            width: 100%;
            margin-top: 1rem;
            cursor: pointer;
        }
        
        .btn-submit:hover {
            background: linear-gradient(135deg, #d6612d 0%, #ea580c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233, 113, 64, 0.4);
            color: white;
        }
        
        .required-field::after {
            content: ' *';
            color: #ef4444;
            font-weight: bold;
        }
        
        /* Sidebar navigation hover effects */
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            margin: 0 0.5rem;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .page-heading {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body id="page-top">
<div id="wrapper">
    <?php include 'sidebar.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include "header.php"; ?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="page-heading">
                    <div class="d-flex align-items-center">
                        <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 40px; margin-right: 1rem; filter: brightness(0) invert(1);">
                        <h1>Add Medical Record</h1>
                    </div>
                    <div>
                        <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">
                            <?php echo date('l, F j, Y'); ?>
                        </span>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-clipboard-list"></i> Medical Record Form</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="medical-record-form">
                            
                            <!-- Patient Selection Section -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-user-check"></i> Select Patient with Appointment
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient_appointment" class="form-label required-field">Select Patient</label>
                                    <select name="patient_appointment" id="patient_appointment" class="form-control" required>
                                        <option value="" disabled selected>-- Select a Patient with Appointment --</option>
                                        <?php 
                                        if ($appointmentPatients && mysqli_num_rows($appointmentPatients) > 0) {
                                            while ($patient = mysqli_fetch_assoc($appointmentPatients)) : ?>
                                                <option value="<?= htmlspecialchars($patient['appointment_id']) ?>" 
                                                        data-username="<?= htmlspecialchars($patient['uername']) ?>"
                                                        data-email="<?= htmlspecialchars($patient['useremail']) ?>"
                                                        data-contact="<?= htmlspecialchars($patient['contact']) ?>"
                                                        data-location="<?= htmlspecialchars($patient['location']) ?>"
                                                        data-petdetail="<?= htmlspecialchars($patient['petdetail']) ?>"
                                                        data-service="<?= htmlspecialchars($patient['servicesname']) ?>">
                                                    <?= htmlspecialchars($patient['uername']) ?> - <?= htmlspecialchars($patient['servicename']) ?> (<?= htmlspecialchars($patient['useremail']) ?>)
                                                </option>
                                            <?php endwhile;
                                        } else {
                                            echo '<option value="" disabled>No patients with appointments found</option>';
                                        } ?>
                                    </select>
                                    <small class="form-text text-muted">Only patients who have booked appointments with you are shown here.</small>
                                </div>
                            </div>

                            <!-- Patient Information Section (Auto-filled) -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-user"></i> Patient Information
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="username" class="form-label required-field">Client Name</label>
                                            <input type="text" name="username" id="username" class="form-control" placeholder="Select patient above to auto-fill" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="useremail" class="form-label required-field">Client Email</label>
                                            <input type="email" name="useremail" id="useremail" class="form-control" placeholder="Select patient above to auto-fill" readonly required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="contact" class="form-label required-field">Contact Number</label>
                                            <input type="tel" name="contact" id="contact" class="form-control" placeholder="Select patient above to auto-fill" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="location" class="form-label required-field">Location</label>
                                            <input type="text" name="location" id="location" class="form-control" placeholder="Select patient above to auto-fill" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pet Information Section -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-paw"></i> Pet Information
                                </div>
                                
                                <div class="form-group">
                                    <label for="petdetail" class="form-label required-field">Pet Details</label>
                                    <textarea name="petdetail" id="petdetail" class="form-control" placeholder="Select patient above to auto-fill pet details" readonly required></textarea>
                                </div>
                            </div>
                            
                            <!-- Medical Information Section -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-stethoscope"></i> Medical Information
                                </div>
                                
                                <div class="form-group">
                                    <label for="service_id" class="form-label required-field">Service Type</label>
                                    <select name="service_id" id="service_id" class="form-control" required readonly disabled>
                                        <option value="" disabled selected>-- Service will be auto-filled from appointment --</option>
                                        <?php 
                                        // Fetch services fresh for the dropdown
                                        $services_dropdown = mysqli_query($con, "SELECT id, servicename FROM services ORDER BY servicename ASC");
                                        if ($services_dropdown && mysqli_num_rows($services_dropdown) > 0) {
                                            while ($service = mysqli_fetch_assoc($services_dropdown)) : ?>
                                                <option value="<?= htmlspecialchars($service['id']) ?>"><?= htmlspecialchars($service['servicename']) ?></option>
                                            <?php endwhile;
                                        } else {
                                            echo '<option value="" disabled>No services available</option>';
                                        } ?>
                                    </select>
                                    <small class="form-text text-muted">Service type is automatically selected based on the patient's appointment.</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="record" class="form-label required-field">Medical Record Summary</label>
                                    <textarea name="record" id="record" class="form-control" placeholder="Enter detailed medical examination findings, diagnosis, and treatment provided" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="prescription" class="form-label required-field">Prescription & Instructions</label>
                                    <textarea name="prescription" id="prescription" class="form-control" placeholder="Enter medication details, dosage, frequency, and special instructions" required></textarea>
                                </div>
                            </div>
                            
                            <!-- Billing Information Section -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-dollar-sign"></i> Billing Information
                                </div>
                                
                                <div class="form-group">
                                    <label for="bill" class="form-label required-field">Total Bill Amount</label>
                                    <input type="number" step="0.01" name="bill" id="bill" class="form-control" placeholder="Enter amount (e.g., 150.00)" required>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Submit Medical Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing patient selection and fixing select dropdown...');
    
    // Patient selection auto-fill functionality
    const patientSelect = document.getElementById('patient_appointment');
    const usernameField = document.getElementById('username');
    const emailField = document.getElementById('useremail');
    const contactField = document.getElementById('contact');
    const locationField = document.getElementById('location');
    const petDetailField = document.getElementById('petdetail');
    const serviceSelect = document.getElementById('service_id');
    
    if (patientSelect) {
        patientSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                // Auto-fill patient information
                usernameField.value = selectedOption.dataset.username || '';
                emailField.value = selectedOption.dataset.email || '';
                contactField.value = selectedOption.dataset.contact || '';
                locationField.value = selectedOption.dataset.location || '';
                petDetailField.value = selectedOption.dataset.petdetail || '';
                
                // Auto-select service
                const serviceId = selectedOption.dataset.service;
                if (serviceId) {
                    serviceSelect.value = serviceId;
                    serviceSelect.disabled = false;
                    serviceSelect.removeAttribute('readonly');
                }
                
                // Enable form fields for editing if needed
                usernameField.removeAttribute('readonly');
                emailField.removeAttribute('readonly');
                contactField.removeAttribute('readonly');
                locationField.removeAttribute('readonly');
                petDetailField.removeAttribute('readonly');
                
                console.log('Patient data auto-filled for:', selectedOption.dataset.username);
            } else {
                // Clear fields if no selection
                usernameField.value = '';
                emailField.value = '';
                contactField.value = '';
                locationField.value = '';
                petDetailField.value = '';
                serviceSelect.value = '';
                serviceSelect.disabled = true;
                serviceSelect.setAttribute('readonly', 'readonly');
            }
        });
    }
    
    if (serviceSelect) {
        console.log('Service select found:', serviceSelect);
        
        // ULTIMATE FIX FUNCTION
        function forceSelectVisibility() {
            const element = document.getElementById('service_id');
            if (element) {
                // Use direct style manipulation with maximum specificity
                element.style.setProperty('color', '#1f2937', 'important');
                element.style.setProperty('background-color', '#ffffff', 'important');
                element.style.setProperty('border', '2px solid #e97140', 'important');
                element.style.setProperty('font-size', '16px', 'important');
                element.style.setProperty('font-weight', '500', 'important');
                element.style.setProperty('opacity', '1', 'important');
                element.style.setProperty('visibility', 'visible', 'important');
                
                console.log('Applied ultimate fix to select element');
            }
        }
        
        // Apply fix on all possible events
        serviceSelect.addEventListener('change', function() {
            console.log('Service changed to:', this.value, this.options[this.selectedIndex].text);
            forceSelectVisibility();
            
            // Additional debugging
            const computedStyle = window.getComputedStyle(this);
            console.log('Computed color:', computedStyle.color);
            console.log('Computed background:', computedStyle.backgroundColor);
        });
        
        serviceSelect.addEventListener('focus', forceSelectVisibility);
        serviceSelect.addEventListener('blur', forceSelectVisibility);
        serviceSelect.addEventListener('click', forceSelectVisibility);
        serviceSelect.addEventListener('mousedown', forceSelectVisibility);
        
        // Apply initial fix
        forceSelectVisibility();
        
        // Apply fix with delays to override any other scripts
        setTimeout(forceSelectVisibility, 100);
        setTimeout(forceSelectVisibility, 500);
        setTimeout(forceSelectVisibility, 1000);
        
        // Create a MutationObserver to watch for style changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    forceSelectVisibility();
                }
            });
        });
        
        observer.observe(serviceSelect, {
            attributes: true,
            attributeFilter: ['style', 'class']
        });
        
    } else {
        console.error('Service select element not found!');
    }
    
    // Additional fix for any conflicting CSS
    const style = document.createElement('style');
    style.textContent = `
        #service_id, select#service_id {
            color: #1f2937 !important;
            background-color: #ffffff !important;
            border: 2px solid #e97140 !important;
            font-size: 16px !important;
            font-weight: 500 !important;
        }
        #service_id option, select#service_id option {
            color: #1f2937 !important;
            background-color: #ffffff !important;
        }
    `;
    document.head.appendChild(style);
});

// Global function for manual fixing
window.fixServiceSelect = function() {
    const element = document.getElementById('service_id');
    if (element) {
        element.style.setProperty('color', '#1f2937', 'important');
        element.style.setProperty('background-color', '#ffffff', 'important');
        console.log('Manual fix applied');
    }
};

// Call fix after everything loads
window.addEventListener('load', function() {
    setTimeout(function() {
        if (window.fixServiceSelect) {
            window.fixServiceSelect();
        }
    }, 200);
});
</script>

<?php include 'footerlink.php'; ?>
</body>
</html>