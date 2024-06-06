<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$jabatan = $_SESSION['jabatan'];
?>

<?php include 'template/header.php'; ?>

<style>
    body {
        background-image: url('bg/123.jpg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
    }

    .content-wrapper {
        background-color: rgba(255, 255, 255, 0.8); /* Optional: To make the content background semi-transparent */
        padding: 20px;
        border-radius: 10px;
    }
</style>

<body id="page-top">
    <div id="wrapper">
        <?php include 'template/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column content-wrapper">
            <div id="content">
                <?php include 'template/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <h2>Selamat datang, <?php echo $username; ?>!</h2>
                            <p>Anda login sebagai <?php echo $jabatan; ?>.</p>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end align-items-start" style="margin-top: -20px;">
                            <a href="transaksi.php" class="btn btn-primary mx-2">
                                <i class="fas fa-plus"></i> Tambah Transaksi
                            </a>
                            <a href="pelanggan.php" class="btn btn-info mx-2">
                                <i class="fas fa-users"></i> Data Pelanggan
                            </a>
                            <a href="playstation.php" class="btn btn-warning mx-2">
                                <i class="fas fa-gamepad"></i> Data Playstation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <?php include 'template/scripts.php'; ?>
</body>
</html>
