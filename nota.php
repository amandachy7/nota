<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nota</title>
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
                margin-top: 70px;
            }
        }
    </style>
</head>
<body>
<?php
// Include koneksi ke database
include 'koneksi.php';

// Menangani aksi tambah nota
if (isset($_POST['tambah_nota'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $jumlah_total = $_POST['jumlah_total'];
    $status_penerimaan = $_POST['status_penerimaan'];
    $tanggal_nota = $_POST['tanggal_nota'];

    $query_tambah = "INSERT INTO nota (id_transaksi, jumlah_total, status_penerimaan, tanggal_nota) VALUES ('$id_transaksi', '$jumlah_total', '$status_penerimaan', '$tanggal_nota')";
    if (mysqli_query($conn, $query_tambah)) {
        echo "<script>alert('Nota berhasil ditambahkan'); window.location='nota.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan nota');</script>";
    }
}

// Menangani aksi edit nota
if (isset($_POST['edit_nota'])) {
    $id_nota = $_POST['id_nota'];
    $id_transaksi = $_POST['id_transaksi'];
    $jumlah_total = $_POST['jumlah_total'];
    $status_penerimaan = $_POST['status_penerimaan'];
    $tanggal_nota = $_POST['tanggal_nota'];

    $query_edit = "UPDATE nota SET id_transaksi='$id_transaksi', jumlah_total='$jumlah_total', status_penerimaan='$status_penerimaan', tanggal_nota='$tanggal_nota' WHERE id_nota='$id_nota'";
    if (mysqli_query($conn, $query_edit)) {
        echo "<script>alert('Nota berhasil diperbarui'); window.location='nota.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui nota');</script>";
    }
}

// Menangani aksi hapus nota
if (isset($_GET['hapus'])) {
    $id_nota = $_GET['hapus'];
    $query_hapus = "DELETE FROM nota WHERE id_nota='$id_nota'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('Nota berhasil dihapus'); window.location='nota.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus nota');</script>";
    }
}

// Mengambil data nota
$query_nota = "SELECT * FROM nota";
$result_nota = mysqli_query($conn, $query_nota);
?>

<!-- Navbar (Top Bar) -->
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
    <h1>Data Nota</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Nota</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Jumlah Total</th>
                <th>Status Penerimaan</th>
                <th>Tanggal Nota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result_nota)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['id_transaksi']; ?></td>
                <td><?= $row['jumlah_total']; ?></td>
                <td><?= $row['status_penerimaan']; ?></td>
                <td><?= $row['tanggal_nota']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_nota']; ?>">Edit</button>
                    <a href="nota.php?hapus=<?= $row['id_nota']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row['id_nota']; ?>" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Nota</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="">
                            <div class="modal-body">
                                <input type="hidden" name="id_nota" value="<?= $row['id_nota']; ?>">
                                <div class="mb-3">
                                    <label for="id_transaksi" class="form-label">ID Transaksi</label>
                                    <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" value="<?= $row['id_transaksi']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah_total" class="form-label">Jumlah Total</label>
                                    <input type="number" class="form-control" id="jumlah_total" name="jumlah_total" value="<?= $row['jumlah_total']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status_penerimaan" class="form-label">Status Penerimaan</label>
                                    <input type="text" class="form-control" id="status_penerimaan" name="status_penerimaan" value="<?= $row['status_penerimaan']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_nota" class="form-label">Tanggal Nota</label>
                                    <input type="date" class="form-control" id="tanggal_nota" name="tanggal_nota" value="<?= $row['tanggal_nota']; ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="edit_nota" class="btn btn-warning">Simpan Perubahan</button>
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
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_transaksi" class="form-label">ID Transaksi</label>
                            <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_total" class="form-label">Jumlah Total</label>
                            <input type="number" class="form-control" id="jumlah_total" name="jumlah_total" required>
                        </div>
                        <div class="mb-3">
                            <label for="status_penerimaan" class="form-label">Status Penerimaan</label>
                            <input type="text" class="form-control" id="status_penerimaan" name="status_penerimaan" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_nota" class="form-label">Tanggal Nota</label>
                            <input type="date" class="form-control" id="tanggal_nota" name="tanggal_nota" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah_nota" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
