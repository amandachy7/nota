<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jasa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: #ffc107;
        }

        .navbar-brand:hover, .navbar-nav .nav-link:hover {
            color: #ffffff;
        }

        .main-content {
            padding: 20px;
            margin-top: 70px;
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

// Menangani aksi tambah jasa
if (isset($_POST['tambah_jasa'])) {
    $nama_jasa = $_POST['nama_jasa'];
    $harga_jasa = $_POST['harga_jasa'];

    $query_tambah = "INSERT INTO jasa (id_transaksi, nama_jasa, harga_jasa) VALUES ('$id_transaksi', '$nama_jasa', '$harga_jasa')";
    if (mysqli_query($conn, $query_tambah)) {
        echo "<script>alert('Jasa berhasil ditambahkan'); window.location='jasa.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan jasa');</script>";
    }
}

// Menangani aksi edit jasa
if (isset($_POST['edit_jasa'])) {
    $id_jasa = $_POST['id_jasa'];
    $nama_jasa = $_POST['nama_jasa'];
    $harga_jasa = $_POST['harga_jasa'];

    $query_edit = "UPDATE jasa SET nama_jasa='$nama_jasa', harga_jasa='$harga_jasa' WHERE id_jasa='$id_jasa'";
    if (mysqli_query($conn, $query_edit)) {
        echo "<script>alert('Jasa berhasil diperbarui'); window.location='jasa.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui jasa');</script>";
    }
}

// Menangani aksi hapus jasa
if (isset($_GET['hapus'])) {
    $id_jasa = $_GET['hapus'];
    $query_hapus = "DELETE FROM jasa WHERE id_jasa='$id_jasa'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('Jasa berhasil dihapus'); window.location='jasa.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus jasa');</script>";
    }
}

// Mengambil data jasa
$query_jasa = "SELECT * FROM jasa";
$result_jasa = mysqli_query($conn, $query_jasa);
?>

<!-- Navbar -->
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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data Management
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
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

<!-- Main Content -->
<div class="main-content">
    <h1>Data Jasa</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Jasa</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jasa</th>
                <th>Harga Jasa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result_jasa)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_jasa']; ?></td>
                <td><?= number_format($row['harga_jasa'], 0, ',', '.'); ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_jasa']; ?>">Edit</button>
                    <a href="jasa.php?hapus=<?= $row['id_jasa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row['id_jasa']; ?>" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Jasa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="">
                            <div class="modal-body">
                                <input type="hidden" name="id_jasa" value="<?= $row['id_jasa']; ?>">
                                <div class="mb-3">
                                    <label for="id_transaksi" class="form-label">ID Transaksi</label>
                                    <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" value="<?= $row['id_transaksi']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_jasa" class="form-label">Nama Jasa</label>
                                    <input type="text" class="form-control" id="nama_jasa" name="nama_jasa" value="<?= $row['nama_jasa']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga_jasa" class="form-label">Harga Jasa</label>
                                    <input type="number" class="form-control" id="harga_jasa" name="harga_jasa" value="<?= $row['harga_jasa']; ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="edit_jasa" class="btn btn-warning">Simpan Perubahan</button>
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
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Jasa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_transaksi" class="form-label">ID Transaksi</label>
                            <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_jasa" class="form-label">Nama Jasa</label>
                            <input type="text" class="form-control" id="nama_jasa" name="nama_jasa" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_jasa" class="form-label">Harga Jasa</label>
                            <input type="number" class="form-control" id="harga_jasa" name="harga_jasa" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah_jasa" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
