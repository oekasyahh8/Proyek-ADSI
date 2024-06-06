<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$jabatan = $_SESSION['jabatan'];

include 'db_connect.php';

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql_transaksi = "SELECT * FROM Transaksi";
$result_transaksi = $conn->query($sql_transaksi);

if ($result_transaksi === FALSE) {
    die("Error: " . $conn->error);
}

$title = "Laporan Transaksi";
include 'template/header.php';
?>

<div id="wrapper">
    <?php include 'template/sidebar.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include 'template/topbar.php'; ?>
            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800">Laporan Transaksi</h1>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No Transaksi</th>
                                        <th>Nama Pelanggan</th>
                                        <th>ID Playstation</th>
                                        <th>Nama Petugas</th>
                                        <th>Nama Paket</th>
                                        <th>Durasi (jam)</th>
                                        <th>Harga</th>
                                        <th>Total Biaya</th>
                                        <th>Tanggal Sewa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result_transaksi->num_rows > 0) {
                                        while ($row_transaksi = $result_transaksi->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row_transaksi['No_Transaksi'] . "</td>";
                                            echo "<td>" . $row_transaksi['Nama_Pelanggan'] . "</td>";
                                            echo "<td>" . $row_transaksi['No_Playstation'] . "</td>";
                                            echo "<td>" . $row_transaksi['Nama_Petugas'] . "</td>";
                                            echo "<td>" . $row_transaksi['Nama_Paket'] . "</td>";
                                            echo "<td>" . $row_transaksi['Durasi_jam'] . "</td>";
                                            echo "<td>" . $row_transaksi['Harga'] . "</td>";
                                            echo "<td>" . $row_transaksi['Total_biaya'] . "</td>";
                                            echo "<td>" . $row_transaksi['Tanggal_sewa'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9'>Tidak ada data transaksi.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary no-print" onclick="window.print();">Cetak Laporan</button>
                        <form method="POST" action="Dashboard.php" class="no-print mt-2"></form>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'template/footer.php'; ?>
    </div>
</div>
<?php include 'template/scripts.php'; ?>

