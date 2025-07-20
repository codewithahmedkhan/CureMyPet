<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(180deg, #e97140 0%, #f97316 100%);">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" style="padding: 1.5rem;">
    <div class="sidebar-brand-icon" style="margin-right: 0.5rem;">
        <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 40px; filter: brightness(0) invert(1);">
    </div>
    <div class="sidebar-brand-text mx-2" style="font-size: 0.9rem; font-weight: 600;">HELLO <?php echo (isset($_SESSION['adminname']) ? $_SESSION['adminname'] : 'Not Set');?> </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="index.php">
      
        <span>Appointment</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- <div class="sidebar-heading">
    Interface
</div> -->

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link" href="usersdata.php">
        <span>Users</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="doctors.php">
        <span>Doctors</span></a>
</li>

<hr class="sidebar-divider d-none d-md-block">

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link" href="services.php">
        <span>Services</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="products.php">
        <span>Products</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="orders.php">
        <span>Orders</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="contact.php">
        <span>Contact</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="doctorrecord.php">
        <span>Record</span></a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>