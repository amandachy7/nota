<?php
include 'koneksi.php';

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    // Mengambil data transaksi
    $query_transaksi = "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'";
    $result_transaksi = mysqli_query($conn, $query_transaksi);
    $transaksi = mysqli_fetch_assoc($result_transaksi);

    // Mengambil data detail transaksi
    $query_detail_transaksi = "SELECT * FROM detail_transaksi WHERE id_transaksi='$id_transaksi'";
    $result_detail = mysqli_query($conn, $query_detail_transaksi);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Detail Transaksi</h1>

    <h3>Transaksi ID: <?= $transaksi['id_transaksi']; ?></h3>
    <p>Pelanggan ID: <?= $transaksi['id_pelanggan']; ?></p>
    <p>Tanggal Transaksi: <?= $transaksi['tanggal_transaksi']; ?></p>

    <h4>Detail Jasa</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Item</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Harga Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_detail)): ?>
            <tr>
                <td><?= $row['nama_item']; ?></td>
                <td><?= $row['satuan']; ?></td>
                <td><?= $row['harga_satuan']; ?></td>
                <td><?= $row['harga_total']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
