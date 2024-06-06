<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$jabatan = $_SESSION['jabatan'];

include 'db_connect.php';

$error_message = '';

if (isset($_POST['tambah_pelanggan'])) {
    $no_pelanggan = $_POST['no_pelanggan'];
    $nama = $_POST['nama'];
    $no_telpon = $_POST['no_telpon'];
    $alamat = $_POST['alamat'];

    $check_sql = "SELECT * FROM Pelanggan WHERE No_Pelanggan='$no_pelanggan' OR Nama_Pelanggan='$nama'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $error_message = "Nama pelanggan atau No Pelanggan sudah ada.";
    } else {
        $sql = "INSERT INTO Pelanggan (No_Pelanggan, Nama_Pelanggan, No_Telpon, Alamat) VALUES ('$no_pelanggan', '$nama', '$no_telpon', '$alamat')";
        if ($conn->query($sql) === TRUE) {
            echo "Pelanggan berhasil ditambahkan.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_POST['hapus_pelanggan'])) {
    $no_pelanggan = $_POST['no_pelanggan'];

    $sql = "DELETE FROM Pelanggan WHERE No_Pelanggan = '$no_pelanggan'";
    if ($conn->query($sql) === TRUE) {
        echo "Pelanggan berhasil dihapus.";
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['edit_pelanggan'])) {
    $old_no_pelanggan = $_POST['old_no_pelanggan'];
    $no_pelanggan = $_POST['no_pelanggan'];
    $nama = $_POST['nama'];
    $no_telpon = $_POST['no_telpon'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE Pelanggan SET No_Pelanggan='$no_pelanggan', Nama_Pelanggan='$nama', No_Telpon='$no_telpon', Alamat='$alamat' WHERE No_Pelanggan='$old_no_pelanggan'";
    if ($conn->query($sql) === TRUE) {
        echo "Pelanggan berhasil diperbarui.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM Pelanggan";
$result = $conn->query($sql);

$edit_pelanggan = null;
if (isset($_POST['edit'])) {
    $no_pelanggan = $_POST['no_pelanggan'];
    $sql = "SELECT * FROM Pelanggan WHERE No_Pelanggan='$no_pelanggan'";
    $edit_result = $conn->query($sql);
    if ($edit_result->num_rows > 0) {
        $edit_pelanggan = $edit_result->fetch_assoc();
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

                    <h1 class="h3 mb-4 text-gray-800">Kelola Pelanggan</h1>

                    <div class="card shadow mb-4 <?php echo $edit_pelanggan ? 'd-none' : ''; ?>">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="pelanggan.php">
                                <?php if (!empty($error_message)) { ?>
                                    <div class="alert alert-danger" role="alert">
                                    <?php echo $error_message; ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="no_pelanggan">No Pelanggan:</label>
                                    <input type="text" name="no_pelanggan" id="no_pelanggan" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_telpon">No Telpon:</label>
                                    <input type="text" name="no_telpon" id="no_telpon" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                                </div>
                                <button type="submit" name="tambah_pelanggan" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>

                    <?php if ($edit_pelanggan) { ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="pelanggan.php">
                                <input type="hidden" name="old_no_pelanggan" value="<?php echo $edit_pelanggan['No_Pelanggan']; ?>">
                                <div class="form-group">
                                    <label for="no_pelanggan">No Pelanggan:</label>
                                    <input type="text" name="no_pelanggan" id="no_pelanggan" class="form-control" value="<?php echo $edit_pelanggan['No_Pelanggan']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $edit_pelanggan['Nama_Pelanggan']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_telpon">No Telpon:</label>
                                    <input type="text" name="no_telpon" id="no_telpon" class="form-control" value="<?php echo $edit_pelanggan['No_Telpon']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $edit_pelanggan['Alamat']; ?>" required>
                                </div>
                                <button type="submit" name="edit_pelanggan" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No Pelanggan</th>
                                            <th>Nama</th>
                                            <th>No Telpon</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['No_Pelanggan'] . "</td>";
                                                echo "<td>" . $row['Nama_Pelanggan'] . "</td>";
                                                echo "<td>" . $row['No_Telpon'] . "</td>";
                                                echo "<td>" . $row['Alamat'] . "</td>";
                                                echo "<td>
                                                        <form method='POST' action='pelanggan.php' style='display:inline-block;'>
                                                            <input type='hidden' name='no_pelanggan' value='" . $row['No_Pelanggan'] . "'>
                                                            <button type='submit' name='edit' class='btn btn-warning'>Edit</button>
                                                        </form>
                                                        <form method='POST' action='pelanggan.php' style='display:inline-block;'>
                                                            <input type='hidden' name='no_pelanggan' value='" . $row['No_Pelanggan'] . "'>
                                                            <button type='submit' name='hapus_pelanggan' class='btn btn-danger'>Hapus</button>
                                                        </form>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Tidak ada pelanggan.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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
