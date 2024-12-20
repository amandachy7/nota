<?php
include 'koneksi.php';

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    // Mengambil data pelanggan dan transaksi
    $query_transaksi = "
        SELECT p.nama, p.alamat, p.tipe_mobil, p.no_polisi, t.tanggal_transaksi
        FROM transaksi t
        JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
        WHERE t.id_transaksi = '$id_transaksi'
    ";
    $result_transaksi = mysqli_query($conn, $query_transaksi);
    $transaksi = mysqli_fetch_assoc($result_transaksi);

    // Mengambil data detail transaksi
    $query_detail = "
        SELECT nama_item, satuan, harga_satuan, harga_total
        FROM detail_transaksi
        WHERE id_transaksi = '$id_transaksi'
    ";
    $result_detail = mysqli_query($conn, $query_detail);

    // Mengambil data jasa
    $query_jasa = "
        SELECT nama_jasa, harga_jasa
        FROM jasa
        WHERE id_transaksi = '$id_transaksi'
    ";
    $result_jasa = mysqli_query($conn, $query_jasa);

    // Mengambil data nota
    $query_nota = "
        SELECT jumlah_total, tanggal_nota
        FROM nota
        WHERE id_transaksi = '$id_transaksi'
    ";
    $result_nota = mysqli_query($conn, $query_nota);
    $nota = mysqli_fetch_assoc($result_nota);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .nota {
            width: 100%;
            border: 1px solid #000;
            padding: 20px;
        }

        .nota-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .nota-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .nota-header p {
            margin: 0;
            font-size: 14px;
        }

        .nota-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .nota-table th, .nota-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .nota-footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
    <script>
        // Fungsi untuk langsung mencetak ketika halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
    <div class="nota">
        <div class="nota-header">
            <h1>BENGKEL MOBIL & SPARE PART RAJA</h1>
            <p>JL. A. YANI AIR KARANG BATURAJA</p>
        </div>
        <div>
            <table>
                <tr>
                    <td>Nama:</td>
                    <td><?= $transaksi['nama']; ?></td>
                    <td>Type:</td>
                    <td><?= $transaksi['tipe_mobil']; ?></td>
                </tr>
                <tr>
                    <td>Alamat:</td>
                    <td><?= $transaksi['alamat']; ?></td>
                    <td>No. Polisi:</td>
                    <td><?= $transaksi['no_polisi']; ?></td>
                </tr>
            </table>
        </div>
        <table class="nota-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Item</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Harga Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                while ($row = mysqli_fetch_assoc($result_detail)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama_item']; ?></td>
                    <td><?= $row['satuan']; ?></td>
                    <td><?= number_format($row['harga_satuan'], 2, ',', '.'); ?></td>
                    <td><?= number_format($row['harga_total'], 2, ',', '.'); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div>
            <h4>Jasa:</h4>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($result_jasa)): ?>
                <li><?= $row['nama_jasa']; ?> - Rp <?= number_format($row['harga_jasa'], 2, ',', '.'); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="nota-footer">
            <p>Jumlah Total: Rp <?= number_format($nota['jumlah_total'], 2, ',', '.'); ?></p>
            <p>Sudah diterima dengan baik dan lengkap,</p>
            <p>....................., <?= date('d-m-Y', strtotime($nota['tanggal_nota'])); ?></p>
        </div>
    </div>
</body>
</html>
