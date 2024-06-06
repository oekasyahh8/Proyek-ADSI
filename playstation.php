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
    if (isset($_POST['tambah_playstation'])) {
        $no_playstation = $_POST['no_playstation'];
        $jenis_playstation = $_POST['jenis_playstation'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("INSERT INTO Playstation (No_Playstation, Jenis_Playstation, Status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $no_playstation, $jenis_playstation, $status);

        if ($stmt->execute()) {
            echo "Playstation berhasil ditambahkan.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['hapus_playstation'])) {
        $id_playstation = $_POST['id_playstation'];

        $stmt = $conn->prepare("DELETE FROM Playstation WHERE ID_Playstation = ?");
        $stmt->bind_param("i", $id_playstation);

        if ($stmt->execute()) {
            echo "Playstation berhasil dihapus.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['edit_playstation'])) {
        $id_playstation = $_POST['id_playstation'];
        $no_playstation = $_POST['no_playstation'];
        $jenis_playstation = $_POST['jenis_playstation'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE Playstation SET No_Playstation = ?, Jenis_Playstation = ?, Status = ? WHERE ID_Playstation = ?");
        $stmt->bind_param("sssi", $no_playstation, $jenis_playstation, $status, $id_playstation);

        if ($stmt->execute()) {
            echo "Playstation berhasil diperbarui.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['edit'])) {
        $id_playstation = $_POST['id_playstation'];
        $stmt = $conn->prepare("SELECT * FROM Playstation WHERE ID_Playstation = ?");
        $stmt->bind_param("i", $id_playstation);
        $stmt->execute();
        $edit_playstation = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
}

$sql = "SELECT * FROM Playstation";
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Playstation</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            
                            <div class="card shadow mb-4 <?php echo $edit_playstation ? 'd-none' : ''; ?>">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Playstation</h6>
                        </div>
                                <div class="card-body">
                                    <form method="POST" action="playstation.php">
                                        <div class="form-group">
                                            <label for="no_playstation">No Playstation:</label>
                                            <input type="text" name="no_playstation" id="no_playstation" class="form-control" required>
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
                                            <label for="status">Status:</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="--">--</option>
                                                <option value="tersedia">Tersedia</option>
                                                <option value="tidak tersedia">Tidak Tersedia</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="tambah_playstation" class="btn btn-primary">Tambah</button>
                                    </form>
                                </div>
                            </div>

                            <?php if (isset($edit_playstation)) { ?>
                            <h2>Edit Playstation</h2>
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <form method="POST" action="playstation.php">
                                        <input type="hidden" name="id_playstation" value="<?php echo $edit_playstation['ID_Playstation']; ?>">
                                        <div class="form-group">
                                            <label for="no_playstation">No Playstation:</label>
                                            <input type="text" name="no_playstation" id="no_playstation" class="form-control" value="<?php echo $edit_playstation['No_Playstation']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_playstation">Jenis Playstation:</label>
                                            <select name="jenis_playstation" id="jenis_playstation" class="form-control" required>
                                                <option value="PS3" <?php if ($edit_playstation['Jenis_Playstation'] === 'PS3') echo 'selected'; ?>>PS3</option>
                                                <option value="PS4" <?php if ($edit_playstation['Jenis_Playstation'] === 'PS4') echo 'selected'; ?>>PS4</option>
                                                <option value="PS5" <?php if ($edit_playstation['Jenis_Playstation'] === 'PS5') echo 'selected'; ?>>PS5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="tersedia" <?php if ($edit_playstation['Status'] === 'tersedia') echo 'selected'; ?>>Tersedia</option>
                                                <option value="tidak tersedia" <?php if ($edit_playstation['Status'] === 'tidak tersedia') echo 'selected'; ?>>Tidak Tersedia</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="edit_playstation" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="col-lg-12 mb-4">
                            <h2>Daftar Playstation</h2>
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No Playstation</th>
                                                <th>Jenis Playstation</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    // echo "<td>" . $row['ID_Playstation'] . "</td>";
                                                    echo "<td>" . $row['No_Playstation'] . "</td>";
                                                    echo "<td>" . $row['Jenis_Playstation'] . "</td>";
                                                    echo "<td>" . $row['Status'] . "</td>";
                                                    echo "<td>
                                                            <form method='POST' action='playstation.php' style='display:inline-block;'>
                                                                <input type='hidden' name='id_playstation' value='" . $row['ID_Playstation'] . "'>
                                                                <button type='submit' name='edit' class='btn btn-warning'>Edit</button>
                                                            </form>
                                                            <form method='POST' action='playstation.php' style='display:inline-block;'>
                                                                <input type='hidden' name='id_playstation' value='" . $row['ID_Playstation'] . "'>
                                                                <button type='submit' name='hapus_playstation' class='btn btn-danger'>Hapus</button>
                                                            </form>
                                                        </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='4'>Tidak ada data playstation.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <form method="POST" action="dashboard.php">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
