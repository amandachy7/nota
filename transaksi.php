<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-brand, .nav-link {
            color: #ffc107 !important;
        }

        .dropdown-menu {
            background-color: #495057;
        }

        .dropdown-menu .dropdown-item {
            color: #ffffff;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #6c757d;
        }

        .main-content {
            margin-top: 70px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 18px;
            color: #343a40;
        }

        .card-text {
            font-size: 16px;
            color: #6c757d;
        }
    </style>
</head>
<body>
<?php
// Include koneksi ke database
include 'koneksi.php';

// Menangani aksi tambah transaksi
if (isset($_POST['tambah_transaksi'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];

    $query_tambah = "INSERT INTO transaksi (id_pelanggan, tanggal_transaksi) VALUES ('$id_pelanggan', '$tanggal_transaksi')";
    if (mysqli_query($conn, $query_tambah)) {
        echo "<script>alert('Transaksi berhasil ditambahkan'); window.location='transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan transaksi');</script>";
    }
}

// Menangani aksi hapus transaksi
if (isset($_GET['hapus'])) {
    $id_transaksi = $_GET['hapus'];
    $query_hapus = "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('Transaksi berhasil dihapus'); window.location='transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus transaksi');</script>";
    }
}

// Mengambil data transaksi
$query_transaksi = "SELECT * FROM transaksi";
$result_transaksi = mysqli_query($conn, $query_transaksi);
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Bengkel Raja</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="pelanggan.php">Pelanggan</a></li>
                        <li><a class="dropdown-item" href="transaksi.php">Transaksi</a></li>
                        <li><a class="dropdown-item" href="jasa.php">Jasa</a></li>
                        <li><a class="dropdown-item" href="nota.php">Nota</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="main-content">
    <h1>Data Transaksi</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Transaksi</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pelanggan</th>
                <th>Tanggal Transaksi</th>
                <th>Aksi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result_transaksi)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['id_pelanggan']; ?></td>
                <td><?= $row['tanggal_transaksi']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_transaksi']; ?>">Edit</button>
                    <a href="transaksi.php?hapus=<?= $row['id_transaksi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
                <td>
                    <a href="detail-transaksi.php?id_transaksi=<?= $row['id_transaksi']; ?>" class="btn btn-info btn-sm">Detail Transaksi</a>
                    <a href="cetak-transaksi.php?id_transaksi=<?= $row['id_transaksi']; ?>" class="btn btn-secondary btn-sm" target="_blank">Cetak</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row['id_transaksi']; ?>" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="">
                            <div class="modal-body">
                                <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                                <div class="mb-3">
                                    <label for="id_pelanggan" class="form-label">ID Pelanggan</label>
                                    <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" value="<?= $row['id_pelanggan']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                                    <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="<?= $row['tanggal_transaksi']; ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="edit_transaksi" class="btn btn-warning">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_pelanggan" class="form-label">ID Pelanggan</label>
                            <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah_transaksi" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
