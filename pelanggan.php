<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #343a40;
            padding: 10px 20px;
        }

        .navbar h4 {
            color: #ffc107;
            margin-right: 20px;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            margin-right: 15px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        .content {
            padding: 20px;
            margin-top: 20px;
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

        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }

            .content {
                margin-top: 70px; /* Make room for the navbar on small screens */
            }
        }
    </style>
</head>
<body>
<?php
// Include koneksi ke database
include 'koneksi.php';

// Handle actions (add, edit, delete) for pelanggan
if (isset($_POST['tambah_pelanggan'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tipe_mobil = $_POST['tipe_mobil'];
    $no_polisi = $_POST['no_polisi'];

    $query_tambah = "INSERT INTO pelanggan (nama, alamat, tipe_mobil, no_polisi) VALUES ('$nama', '$alamat', '$tipe_mobil', '$no_polisi')";
    if (mysqli_query($conn, $query_tambah)) {
        echo "<script>alert('Pelanggan berhasil ditambahkan'); window.location='pelanggan.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pelanggan');</script>";
    }
}

if (isset($_POST['edit_pelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tipe_mobil = $_POST['tipe_mobil'];
    $no_polisi = $_POST['no_polisi'];

    $query_edit = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', tipe_mobil='$tipe_mobil', no_polisi='$no_polisi' WHERE id_pelanggan='$id_pelanggan'";
    if (mysqli_query($conn, $query_edit)) {
        echo "<script>alert('Pelanggan berhasil diperbarui'); window.location='pelanggan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui pelanggan');</script>";
    }
}

if (isset($_GET['hapus'])) {
    $id_pelanggan = $_GET['hapus'];
    $query_hapus = "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('Pelanggan berhasil dihapus'); window.location='pelanggan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus pelanggan');</script>";
    }
}

$query_pelanggan = "SELECT * FROM pelanggan";
$result_pelanggan = mysqli_query($conn, $query_pelanggan);
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <h4>Bengkel Raja</h4>
    <div class="navbar-nav">
        <a class="nav-link" href="index.php">Dashboard</a>
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Data Management
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="pelanggan.php">Pelanggan</a></li>
                <li><a class="dropdown-item" href="transaksi.php">Transaksi</a></li>
                <li><a class="dropdown-item" href="jasa.php">Jasa</a></li>
                <li><a class="dropdown-item" href="nota.php">Nota</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="content">
    <h1>Data Pelanggan</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Pelanggan</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Tipe Mobil</th>
                <th>No Polisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result_pelanggan)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['alamat']; ?></td>
                <td><?= $row['tipe_mobil']; ?></td>
                <td><?= $row['no_polisi']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_pelanggan']; ?>">Edit</button>
                    <a href="pelanggan.php?hapus=<?= $row['id_pelanggan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row['id_pelanggan']; ?>" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Pelanggan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="">
                            <div class="modal-body">
                                <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan']; ?>">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $row['alamat']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tipe_mobil" class="form-label">Tipe Mobil</label>
                                    <input type="text" class="form-control" id="tipe_mobil" name="tipe_mobil" value="<?= $row['tipe_mobil']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_polisi" class="form-label">No Polisi</label>
                                    <input type="text" class="form-control" id="no_polisi" name="no_polisi" value="<?= $row['no_polisi']; ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="edit_pelanggan" class="btn btn-warning">Simpan Perubahan</button>
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
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipe_mobil" class="form-label">Tipe Mobil</label>
                            <input type="text" class="form-control" id="tipe_mobil" name="tipe_mobil" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_polisi" class="form-label">No Polisi</label>
                            <input type="text" class="form-control" id="no_polisi" name="no_polisi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah_pelanggan" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
