<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$jabatan = $_SESSION['jabatan'];
include 'db_connect.php';

if (isset($_POST['tambah_transaksi'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_playstation = $_POST['no_playstation'];
    $nama_petugas = $_POST['nama_petugas'];
    $nama_paket = $_POST['nama_paket'];
    $durasi_jam = $_POST['durasi_jam'];
    $status_pembayaran = $_POST['status_pembayaran'];
    $tanggal_sewa = $_POST['tanggal_sewa'];

    $sql_harga_paket = "SELECT Harga FROM paket WHERE Nama_Paket='$nama_paket'";
    $result_harga_paket = $conn->query($sql_harga_paket);
    $row_harga_paket = $result_harga_paket->fetch_assoc();
    $harga_paket = $row_harga_paket['Harga'];
    $total_biaya = $durasi_jam * $harga_paket;

    $sql_insert = "INSERT INTO transaksi (Nama_Pelanggan, No_Playstation, Nama_Petugas, Nama_Paket, Durasi_jam, Harga, Total_Biaya, Status_pembayaran, Tanggal_sewa) VALUES ('$nama_pelanggan', '$no_playstation', '$nama_petugas', '$nama_paket', '$durasi_jam', '$harga_paket', '$total_biaya', '$status_pembayaran', '$tanggal_sewa')";
    if ($conn->query($sql_insert) === TRUE) {
        header('Location: transaksi.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['hapus_transaksi'])) {
    $no_transaksi = $_POST['no_transaksi'];
    $sql_delete = "DELETE FROM transaksi WHERE No_Transaksi = '$no_transaksi'";
    if ($conn->query($sql_delete) === TRUE) {
        header('Location: transaksi.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['edit_transaksi'])) {
    $no_transaksi = $_POST['no_transaksi'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_playstation = $_POST['no_playstation'];
    $nama_petugas = $_POST['nama_petugas'];
    $nama_paket = $_POST['nama_paket'];
    $durasi_jam = $_POST['durasi_jam'];
    $status_pembayaran = $_POST['status_pembayaran'];
    $tanggal_sewa = $_POST['tanggal_sewa'];

    $sql_harga_paket = "SELECT Harga FROM paket WHERE Nama_Paket='$nama_paket'";
    $result_harga_paket = $conn->query($sql_harga_paket);
    $row_harga_paket = $result_harga_paket->fetch_assoc();
    $harga_paket = $row_harga_paket['Harga'];
    $total_biaya = $durasi_jam * $harga_paket;

    $sql_update = "UPDATE transaksi SET Nama_Pelanggan='$nama_pelanggan', No_Playstation='$no_playstation', Nama_Petugas='$nama_petugas', Nama_Paket='$nama_paket', Durasi_jam='$durasi_jam', Harga='$harga_paket', Total_Biaya='$total_biaya', Status_pembayaran='$status_pembayaran', Tanggal_sewa='$tanggal_sewa' WHERE No_Transaksi='$no_transaksi'";

    if ($conn->query($sql_update) === TRUE) {
        header('Location: transaksi.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$edit_transaksi = null;
if (isset($_POST['edit'])) {
    $no_transaksi = $_POST['no_transaksi'];
    $sql = "SELECT * FROM transaksi WHERE No_Transaksi='$no_transaksi'";
    $edit_result = $conn->query($sql);
    if ($edit_result->num_rows > 0) {
        $edit_transaksi = $edit_result->fetch_assoc();
    }
}
?>

<?php include 'template/header.php'; ?>

<body id="page-top">
    <div id="wrapper">
        <?php include 'template/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'template/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Kelola Transaksi</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow mb-4 <?php echo $edit_transaksi ? 'd-none' : ''; ?>">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tambah Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    <form action="transaksi.php" method="POST">
                                        <div class="form-group">
                                            <label for="nama_pelanggan">Nama Pelanggan:</label>
                                            <select name="nama_pelanggan" id="nama_pelanggan" class="form-control" required>
                                                <option value="--">--</option>
                                                <?php
                                                $sql_pelanggan = "SELECT Nama_Pelanggan FROM pelanggan";
                                                $result_pelanggan = $conn->query($sql_pelanggan);
                                                if ($result_pelanggan->num_rows > 0) {
                                                    while ($row_pelanggan = $result_pelanggan->fetch_assoc()) {
                                                        echo "<option value='" . $row_pelanggan['Nama_Pelanggan'] . "'>" . $row_pelanggan['Nama_Pelanggan'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_playstation">ID Playstation:</label>
                                            <select name="no_playstation" id="no_playstation" class="form-control" required>
                                                <option value="--">--</option>
                                                <?php
                                                $sql_playstation = "SELECT No_Playstation FROM playstation";
                                                $result_playstation = $conn->query($sql_playstation);
                                                if ($result_playstation->num_rows > 0) {
                                                    while ($row_playstation = $result_playstation->fetch_assoc()) {
                                                        echo "<option value='" . $row_playstation['No_Playstation'] . "'>" . $row_playstation['No_Playstation'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_petugas">Nama Petugas:</label>
                                            <select name="nama_petugas" id="nama_petugas" class="form-control" required>
                                                <option value="--">--</option>
                                                <?php
                                                $sql_petugas = "SELECT Nama_Petugas FROM petugas";
                                                $result_petugas = $conn->query($sql_petugas);
                                                if ($result_petugas->num_rows > 0) {
                                                    while ($row_petugas = $result_petugas->fetch_assoc()) {
                                                        echo "<option value='" . $row_petugas['Nama_Petugas'] . "'>" . $row_petugas['Nama_Petugas'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_paket">Nama Paket:</label>
                                            <select name="nama_paket" id="nama_paket" class="form-control" required>
                                                <option value="--">--</option>
                                                <?php
                                                $sql_paket = "SELECT Nama_Paket FROM paket";
                                                $result_paket = $conn->query($sql_paket);
                                                if ($result_paket->num_rows > 0) {
                                                    while ($row_paket = $result_paket->fetch_assoc()) {
                                                        echo "<option value='" . $row_paket['Nama_Paket'] . "'>" . $row_paket['Nama_Paket'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="durasi_jam">Durasi (jam):</label>
                                            <input type="number" name="durasi_jam" id="durasi_jam" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status_pembayaran">Status Pembayaran:</label>
                                            <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                                                <option value="--">--</option>
                                                <option value="Belum Lunas">Belum Lunas</option>
                                                <option value="Lunas">Lunas</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_sewa">Tanggal Sewa:</label>
                                            <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control" required>
                                        </div>
                                        <button type="submit" name="tambah_transaksi" class="btn btn-primary">Tambah</button>
                                    </form>
                                </div>
                            </div>

                            <?php if ($edit_transaksi): ?>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Edit Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    <form action="transaksi.php" method="POST">
                                        <input type="hidden" name="no_transaksi" value="<?php echo $edit_transaksi['No_Transaksi']; ?>">
                                        <div class="form-group">
                                            <label for="nama_pelanggan">Nama Pelanggan:</label>
                                            <select name="nama_pelanggan" id="nama_pelanggan" class="form-control" required>
                                                <option value="<?php echo $edit_transaksi['Nama_Pelanggan']; ?>"><?php echo $edit_transaksi['Nama_Pelanggan']; ?></option>
                                                <?php
                                                $sql_pelanggan = "SELECT Nama_Pelanggan FROM pelanggan";
                                                $result_pelanggan = $conn->query($sql_pelanggan);
                                                if ($result_pelanggan->num_rows > 0) {
                                                    while ($row_pelanggan = $result_pelanggan->fetch_assoc()) {
                                                        echo "<option value='" . $row_pelanggan['Nama_Pelanggan'] . "'>" . $row_pelanggan['Nama_Pelanggan'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_playstation">ID Playstation:</label>
                                            <select name="no_playstation" id="no_playstation" class="form-control" required>
                                                <option value="<?php echo $edit_transaksi['No_Playstation']; ?>"><?php echo $edit_transaksi['No_Playstation']; ?></option>
                                                <?php
                                                $sql_playstation = "SELECT No_Playstation FROM playstation";
                                                $result_playstation = $conn->query($sql_playstation);
                                                if ($result_playstation->num_rows > 0) {
                                                    while ($row_playstation = $result_playstation->fetch_assoc()) {
                                                        echo "<option value='" . $row_playstation['No_Playstation'] . "'>" . $row_playstation['No_Playstation'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_petugas">Nama Petugas:</label>
                                            <select name="nama_petugas" id="nama_petugas" class="form-control" required>
                                                <option value="<?php echo $edit_transaksi['Nama_Petugas']; ?>"><?php echo $edit_transaksi['Nama_Petugas']; ?></option>
                                                <?php
                                                $sql_petugas = "SELECT Nama_Petugas FROM petugas";
                                                $result_petugas = $conn->query($sql_petugas);
                                                if ($result_petugas->num_rows > 0) {
                                                    while ($row_petugas = $result_petugas->fetch_assoc()) {
                                                        echo "<option value='" . $row_petugas['Nama_Petugas'] . "'>" . $row_petugas['Nama_Petugas'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_paket">Nama Paket:</label>
                                            <select name="nama_paket" id="nama_paket" class="form-control" required>
                                                <option value="<?php echo $edit_transaksi['Nama_Paket']; ?>"><?php echo $edit_transaksi['Nama_Paket']; ?></option>
                                                <?php
                                                $sql_paket = "SELECT Nama_Paket FROM paket";
                                                $result_paket = $conn->query($sql_paket);
                                                if ($result_paket->num_rows > 0) {
                                                    while ($row_paket = $result_paket->fetch_assoc()) {
                                                        echo "<option value='" . $row_paket['Nama_Paket'] . "'>" . $row_paket['Nama_Paket'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="durasi_jam">Durasi (jam):</label>
                                            <input type="number" name="durasi_jam" id="durasi_jam" class="form-control" value="<?php echo $edit_transaksi['Durasi_jam']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status_pembayaran">Status Pembayaran:</label>
                                            <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                                                <option value="<?php echo $edit_transaksi['Status_pembayaran']; ?>"><?php echo $edit_transaksi['Status_pembayaran']; ?></option>
                                                <option value="Belum Lunas">Belum Lunas</option>
                                                <option value="Lunas">Lunas</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_sewa">Tanggal Sewa:</label>
                                            <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control" value="<?php echo $edit_transaksi['Tanggal_sewa']; ?>" required>
                                        </div>
                                        <button type="submit" name="edit_transaksi" class="btn btn-primary">Edit</button>
                                    </form>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Pelanggan</th>
                                                    <th>ID Playstation</th>
                                                    <th>Nama Petugas</th>
                                                    <th>Nama Paket</th>
                                                    <th>Durasi (jam)</th>
                                                    <th>Harga per Jam</th>
                                                    <th>Total Biaya</th>
                                                    <th>Status Pembayaran</th>
                                                    <th>Tanggal Sewa</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM transaksi";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row['No_Transaksi'] . "</td>";
                                                        echo "<td>" . $row['Nama_Pelanggan'] . "</td>";
                                                        echo "<td>" . $row['No_Playstation'] . "</td>";
                                                        echo "<td>" . $row['Nama_Petugas'] . "</td>";
                                                        echo "<td>" . $row['Nama_Paket'] . "</td>";
                                                        echo "<td>" . $row['Durasi_jam'] . "</td>";
                                                        echo "<td>" . $row['Harga'] . "</td>";
                                                        echo "<td>" . $row['Total_biaya'] . "</td>";
                                                        echo "<td>" . $row['Status_pembayaran'] . "</td>";
                                                        echo "<td>" . $row['Tanggal_sewa'] . "</td>";
                                                        echo "<td>";
                                                        echo "<form method='POST' action='transaksi.php' class='d-inline-block'>";
                                                        echo "<input type='hidden' name='no_transaksi' value='" . $row['No_Transaksi'] . "'>";
                                                        echo "<button type='submit' name='edit' class='btn btn-warning btn-sm'>Edit</button>";
                                                        echo "</form>";
                                                        echo "<form method='POST' action='transaksi.php' class='d-inline-block'>";
                                                        echo "<input type='hidden' name='no_transaksi' value='" . $row['No_Transaksi'] . "'>";
                                                        echo "<button type='submit' name='hapus_transaksi' class='btn btn-danger btn-sm'>Hapus</button>";
                                                        echo "</form>";
                                                        echo "<button type='button' onclick='printStruk(this)' data-transaksi='" . json_encode($row) . "' class='btn btn-info btn-sm'>Cetak</button>";
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>

    <script>
        function printStruk(button) {
            const transaksi = JSON.parse(button.getAttribute('data-transaksi'));
            const printContent = `
                <h1>Struk Transaksi</h1>
                <p>No Transaksi: ${transaksi.No_Transaksi}</p>
                <p>Nama Pelanggan: ${transaksi.Nama_Pelanggan}</p>
                <p>ID Playstation: ${transaksi.No_Playstation}</p>
                <p>Nama Petugas: ${transaksi.Nama_Petugas}</p>
                <p>Nama Paket: ${transaksi.Nama_Paket}</p>
                <p>Durasi (jam): ${transaksi.Durasi_jam}</p>
                <p>Harga per Jam: ${transaksi.Harga}</p>
                <p>Total Biaya: ${transaksi.Total_biaya}</p>
                <p>Status Pembayaran: ${transaksi.Status_pembayaran}</p>
                <p>Tanggal Sewa: ${transaksi.Tanggal_sewa}</p>
            `;

            const printWindow = window.open('', '', 'width=600,height=400');
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
    <?php include 'template/scripts.php'; ?>
</body>
</html>
