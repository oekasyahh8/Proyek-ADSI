<?php
// Masukkan kode untuk koneksi ke database di sini
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['no_transaksi'])) {
    $no_transaksi = $_GET['no_transaksi'];

    // Query untuk mengambil data transaksi berdasarkan nomor transaksi
    $sql = "SELECT * FROM transaksi WHERE No_Transaksi='$no_transaksi'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mengambil data transaksi dalam bentuk array asosiatif
        $data = $result->fetch_assoc();
        // Mengembalikan data transaksi dalam format JSON
        echo json_encode($data);
    } else {
        // Jika transaksi tidak ditemukan, kembalikan pesan error
        echo json_encode(array('error' => 'Transaksi tidak ditemukan'));
    }
} else {
    // Jika request bukan metode GET atau nomor transaksi tidak diberikan, kembalikan pesan error
    echo json_encode(array('error' => 'Invalid request'));
}
?>
