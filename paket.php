<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';

$username = $_SESSION['username'];
$jabatan = $_SESSION['jabatan'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_paket'])) {
        $no_paket = $_POST['no_paket'];
        $jenis_playstation = $_POST['jenis_playstation'];
        $nama_paket = $_POST['nama_paket'];
        $durasi_jam = $_POST['durasi_jam'];
        $harga = $_POST['harga'];

        $stmt = $conn->prepare("INSERT INTO Paket (No_Paket, Jenis_Playstation, Nama_Paket, Durasi_jam, Harga) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $no_paket, $jenis_playstation, $nama_paket, $durasi_jam, $harga);

        if ($stmt->execute()) {
            echo "Paket berhasil ditambahkan.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['hapus_paket'])) {
        $no_paket = $_POST['no_paket'];

        $stmt = $conn->prepare("DELETE FROM Paket WHERE No_Paket = ?");
        $stmt->bind_param("i", $no_paket);

        if ($stmt->execute()) {
            echo "Paket berhasil dihapus.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['edit_paket'])) {
        $no_paket = $_POST['no_paket'];
        $jenis_playstation = $_POST['jenis_playstation'];
        $nama_paket = $_POST['nama_paket'];
        $durasi_jam = $_POST['durasi_jam'];
        $harga = $_POST['harga'];

        $stmt = $conn->prepare("UPDATE Paket SET Jenis_Playstation = ?, Nama_Paket = ?, Durasi_jam = ?, Harga = ? WHERE No_Paket = ?");
        $stmt->bind_param("ssssi", $jenis_playstation, $nama_paket, $durasi_jam, $harga, $no_paket);

        if ($stmt->execute()) {
            echo "Paket berhasil diperbarui.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['edit'])) {
        $no_paket = $_POST['no_paket'];
        $stmt = $conn->prepare("SELECT * FROM Paket WHERE No_Paket = ?");
        $stmt->bind_param("i", $no_paket);
        $stmt->execute();
        $edit_paket = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
}

$sql = "SELECT * FROM Paket";
$result = $conn->query($sql);
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Paket</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 mb-4">

                            <div class="card shadow mb-4 <?php echo $edit_paket ? 'd-none' : ''; ?>">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Paket</h6>
                        </div>
                                <div class="card-body">
                                    <form method="POST" action="paket.php">
                                        <div class="form-group">
                                            <label for="no_paket">No Paket:</label>
                                            <input type="text" name="no_paket" id="no_paket" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_playstation">Jenis Playstation:</label>
                                            <select name="jenis_playstation" id="jenis_playstation" class="form-control" required>
                                                <option value="--">--</option>
                                                <option value="PS3">PS3</option>
                                                <option value="PS4">PS4</option>
                                                <option value="PS5">PS5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_paket">Nama Paket:</label>
                                            <input type="text" name="nama_paket" id="nama_paket" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="durasi_jam">Durasi (jam):</label>
                                            <input type="text" name="durasi_jam" id="durasi_jam" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="harga">Harga:</label>
                                            <input type="text" name="harga" id="harga" class="form-control" required>
                                        </div>
                                        <button type="submit" name="tambah_paket" class="btn btn-primary">Tambah</button>
                                    </form>
                                </div>
                            </div>

                            <?php if (isset($edit_paket)) { ?>
    <div class="col-lg-12 mb-4">
        <h2>Edit Paket</h2>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="POST" action="paket.php">
                    <input type="hidden" name="no_paket" value="<?php echo $edit_paket['No_Paket']; ?>">
                    <div class="form-group">
                        <label for="no_paket">No Paket:</label>
                        <input type="text" name="no_paket" id="no_paket" class="form-control" value="<?php echo $edit_paket['No_Paket']; ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="jenis_playstation">Jenis Playstation:</label>
                        <select name="jenis_playstation" id="jenis_playstation" class="form-control" required>
                            <option value="--">--</option>
                            <option value="PS3" <?php if ($edit_paket['Jenis_Playstation'] === 'PS3') echo 'selected'; ?>>PS3</option>
                            <option value="PS4" <?php if ($edit_paket['Jenis_Playstation'] === 'PS4') echo 'selected'; ?>>PS4</option>
                            <option value="PS5" <?php if ($edit_paket['Jenis_Playstation'] === 'PS5') echo 'selected'; ?>>PS5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_paket">Nama Paket:</label>
                        <input type="text" name="nama_paket" id="nama_paket" class="form-control" value="<?php echo $edit_paket['Nama_Paket']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="durasi_jam">Durasi (jam):</label>
                        <input type="text" name="durasi_jam" id="durasi_jam" class="form-control" value="<?php echo $edit_paket['Durasi_jam']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga:</label>
                        <input type="text" name="harga" id="harga" class="form-control" value="<?php echo $edit_paket['Harga']; ?>" required>
                    </div>
                    <button type="submit" name="edit_paket" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
     <div class="col-lg-12 mb-4">
            <h2>Daftar Paket</h2>
                    <div class="card shadow mb-4">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No Paket</th>
                                            <th>Jenis Playstation</th>
                                            <th>Nama Paket</th>
                                            <th>Durasi (jam)</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['No_Paket'] . "</td>";
                                                    echo "<td>" . $row['Jenis_Playstation'] . "</td>";
                                                    echo "<td>" . $row['Nama_Paket'] . "</td>";
                                                    echo "<td>" . $row['Durasi_jam'] . "</td>";
                                                    echo "<td>" . $row['Harga'] . "</td>";
                                                    echo "<td>
                                                            <form method='POST' action='paket.php' style='display:inline-block;'>
                                                                <input type='hidden' name='no_paket' value='" . $row['No_Paket'] . "'>
                                                                <button type='submit' name='edit' class='btn btn-warning'>Edit</button>
                                                            </form>
                                                            <form method='POST' action='paket.php' style='display:inline-block;'>
                                                                <input type='hidden' name='no_paket' value='" . $row['No_Paket'] . "'>
                                                                <button type='submit' name='hapus_paket' class='btn btn-danger'>Hapus</button>
                                                            </form>
                                                        </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>Tidak ada data paket.</td></tr>";
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
            <?php include('template/footer.php'); ?>
        </div>
    </div>
    <?php include('template/scripts.php'); ?>
</body>

</html>

<?php
$conn->close();
?>
