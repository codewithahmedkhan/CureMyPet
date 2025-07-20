<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(180deg, #e97140 0%, #f97316 100%);">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" style="padding: 1.5rem;">
    <div class="sidebar-brand-icon" style="margin-right: 0.5rem;">
        <img src="../assets/img/logo/logo.png" alt="Logo" style="height: 40px; filter: brightness(0) invert(1);">
    </div>
    <div class="sidebar-brand-text mx-2" style="font-size: 0.9rem; font-weight: 600;">HELLO DR. <?php echo strtoupper(isset($_SESSION['drname']) ? $_SESSION['drname'] : 'NOT SET'); ?></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">



<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link" href="index.php" >
        <span>Appointment</span></a>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link" href="treatment.php">
        <span>Treatment</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">


<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>