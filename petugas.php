<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$jabatan = $_SESSION['jabatan'];

include 'db_connect.php';

if (isset($_POST['tambah_petugas'])) {
    $no_petugas = $_POST['no_petugas'];
    $nama_petugas = $_POST['nama_petugas'];
    $jabatan = $_POST['jabatan'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO Petugas (No_Petugas, Nama_Petugas, Jabatan, Username, Password) VALUES ('$no_petugas', '$nama_petugas', '$jabatan', '$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Petugas berhasil ditambahkan.";
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['hapus_petugas'])) {
    $no_petugas = $_POST['no_petugas'];

    $sql = "DELETE FROM Petugas WHERE No_Petugas = $no_petugas";
    if ($conn->query($sql) === TRUE) {
        echo "Petugas berhasil dihapus.";
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['edit_petugas'])) {
    $no_petugas = $_POST['no_petugas'];
    $nama_petugas = $_POST['nama_petugas'];
    $jabatan = $_POST['jabatan'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $sql = "UPDATE Petugas SET Nama_Petugas='$nama_petugas', Jabatan='$jabatan', Username='$username', Password='$password' WHERE No_Petugas='$no_petugas'";
    if ($conn->query($sql) === TRUE) {
        echo "Petugas berhasil diperbarui.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM Petugas";
$result = $conn->query($sql);

$edit_petugas = null;
if (isset($_POST['edit'])) {
    $no_petugas = $_POST['no_petugas'];
    $sql = "SELECT * FROM Petugas WHERE No_Petugas='$no_petugas'";
    $edit_result = $conn->query($sql);
    if ($edit_result->num_rows > 0) {
        $edit_petugas = $edit_result->fetch_assoc();
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

                    <h1 class="h3 mb-4 text-gray-800">Kelola Petugas</h1>

                    <div class="row">
                        <div class="col-lg-12 mb-4">

                        <div class="card shadow mb-4 <?php echo $edit_petugas ? 'd-none' : ''; ?>">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tambah Petugas</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="petugas.php">
                                        <div class="form-group">
                                            <label for="no_petugas">No Petugas:</label>
                                            <input type="number" name="no_petugas" id="no_petugas" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_petugas">Nama Petugas:</label>
                                            <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan:</label>
                                            <select name="jabatan" id="jabatan" class="form-control" required>
                                                <option value="--">--</option>
                                                <option value="Kasir">Kasir</option>
                                                <option value="Manager">Manager</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username:</label>
                                            <input type="text" name="username" id="username" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input type="password" name="password" id="password" class="form-control" required>
                                        </div>
                                        <button type="submit" name="tambah_petugas" class="btn btn-primary">Tambah</button>
                                    </form>
                                </div>
                            </div>

                            <?php if ($edit_petugas) { ?>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Edit Petugas</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="petugas.php">
                                        <input type="hidden" name="no_petugas" value="<?php echo $edit_petugas['No_Petugas']; ?>">
                                        <div class="form-group">
                                            <label for="nama_petugas">Nama Petugas:</label>
                                            <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" value="<?php echo $edit_petugas['Nama_Petugas']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan:</label>
                                            <select name="jabatan" id="jabatan" class="form-control" required>
                                                <option value="--">--</option>
                                                <option value="Kasir" <?php if ($edit_petugas['Jabatan'] === 'Kasir') echo 'selected'; ?>>Kasir</option>
                                                <option value="Manager" <?php if ($edit_petugas['Jabatan'] === 'Manager') echo 'selected'; ?>>Manager</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username:</label>
                                            <input type="text" name="username" id="username" class="form-control" value="<?php echo $edit_petugas['Username']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input type="password" name="password" id="password" class="form-control" value="<?php echo $edit_petugas['Password']; ?>" required>
                                        </div>
                                        <button type="submit" name="edit_petugas" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Petugas</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No Petugas</th>
                                                    <th>Nama Petugas</th>
                                                    <th>Jabatan</th>
                                                    <th>Username</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row['No_Petugas'] . "</td>";
                                                        echo "<td>" . $row['Nama_Petugas'] . "</td>";
                                                        echo "<td>" . $row['Jabatan'] . "</td>";
                                                        echo "<td>" . $row['Username'] . "</td>";
                                                        echo "<td>
                                                                <form method='POST' action='petugas.php' style='display:inline-block;'>
                                                                    <input type='hidden' name='no_petugas' value='" . $row['No_Petugas'] . "'>
                                                                    <button type='submit' name='edit' class='btn btn-warning btn-sm'>Edit</button>
                                                                </form>
                                                                <form method='POST' action='petugas.php' style='display:inline-block;'>
                                                                    <input type='hidden' name='no_petugas' value='" . $row['No_Petugas'] . "'>
                                                                    <button type='submit' name='hapus_petugas' class='btn btn-danger btn-sm'>Hapus</button>
                                                                </form>
                                                              </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='5'>Tidak ada data petugas.</td></tr>";
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
    <?php include 'template/scripts.php'; ?>
</body>
</html>
