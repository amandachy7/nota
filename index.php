<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bengkel Raja</title>
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
                margin-top: 70px; /* Make room for the navbar on small screens */
            }
        }
    </style>
</head>
<body>
    <?php
    // Include koneksi ke database
    include 'koneksi.php';

    // Mengambil data jumlah pelanggan
    $query_pelanggan = "SELECT COUNT(*) AS total_pelanggan FROM pelanggan";
    $result_pelanggan = mysqli_query($conn, $query_pelanggan);
    $data_pelanggan = mysqli_fetch_assoc($result_pelanggan);

    // Mengambil data jumlah transaksi
    $query_transaksi = "SELECT COUNT(*) AS total_transaksi FROM transaksi";
    $result_transaksi = mysqli_query($conn, $query_transaksi);
    $data_transaksi = mysqli_fetch_assoc($result_transaksi);

    // Mengambil data total pendapatan
    $query_pendapatan = "SELECT SUM(harga_total) AS total_pendapatan FROM detail_transaksi";
    $result_pendapatan = mysqli_query($conn, $query_pendapatan);
    $data_pendapatan = mysqli_fetch_assoc($result_pendapatan);
    ?>

    <!-- Navbar (Top Bar) -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <h4>Bengkel Raja</h4>
        <div class="navbar-nav">
            <a class="nav-link" href="#">Dashboard</a>
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

    <!-- Content -->
    <div class="content">
        <h1>Selamat Datang di Dashboard Bengkel Raja</h1>
        <p>Gunakan menu di atas untuk mengelola data.</p>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Pelanggan</h5>
                        <p class="card-text">Data pelanggan terdaftar: <strong><?php echo $data_pelanggan['total_pelanggan']; ?></strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Transaksi</h5>
                        <p class="card-text">Total transaksi selesai: <strong><?php echo $data_transaksi['total_transaksi']; ?></strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pendapatan</h5>
                        <p class="card-text">Total pendapatan: <strong>Rp. <?php echo number_format($data_pendapatan['total_pendapatan'], 0, ',', '.'); ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
