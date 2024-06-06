<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Rental PS Zalika <sup></sup></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Items -->
    <li class="nav-item">
        <a class="nav-link" href="transaksi.php">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Kelola Transaksi</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="pelanggan.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Kelola Pelanggan</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="playstation.php">
            <i class="fas fa-fw fa-gamepad"></i>
            <span>Kelola Playstation</span></a>
    </li>
    <?php if ($jabatan == 'Manager') { ?>
    <li class="nav-item">
        <a class="nav-link" href="petugas.php">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Kelola Petugas</span></a>
    </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link" href="paket.php">
            <i class="fas fa-fw fa-box"></i>
            <span>Kelola Paket</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="laporan.php">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Cetak Laporan Transaksi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
