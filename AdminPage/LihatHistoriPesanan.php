<?php

include "function.php";

// Mengecek apakah "Role" sesinya Admin
if($_SESSION["Role"] != "Admin") {

    // Jika bukan Admin
    echo "
            <script>
                alert('Anda Tidak Memiliki Akses');
                document.location.href = '../Index.php';
            </script>
        ";
}

// Mengecek apakah tombol logout dipencet
if(isset($_POST["logout"])) {
    
    // Memanggil fungsi logout
    logout();
}

// Query untuk mendapatkan data pesanan yang sudah selesai
$query = "SELECT p.*, 
          l1.NamaLauk as NamaLauk1, 
          l2.NamaLauk as NamaLauk2, 
          l3.NamaLauk as NamaLauk3,
          m.NamaMinuman as NamaMinuman,
          dm.NoMeja as NoMeja
          FROM pesanan p 
          LEFT JOIN datalauk l1 ON p.IDLauk1 = l1.IDLauk 
          LEFT JOIN datalauk l2 ON p.IDLauk2 = l2.IDLauk 
          LEFT JOIN datalauk l3 ON p.IDLauk3 = l3.IDLauk 
          LEFT JOIN dataminuman m ON p.IDMinuman = m.IDMinuman
          LEFT JOIN datameja dm ON p.IDMeja = dm.IDMeja
          WHERE p.Status = 'Served' 
          ORDER BY p.IDPesanan DESC";
$hasil = mysqli_query($koneksidb, $query);
$jumlah_data = mysqli_num_rows($hasil);

// Query untuk statistik
$query_statistik = "SELECT 
                    COUNT(CASE WHEN Status = 'Selesai' THEN 1 END) as pesanan_selesai,
                    COUNT(CASE WHEN Status = 'Batal' THEN 1 END) as pesanan_batal,
                    COUNT(*) as total_pesanan
                    FROM pesanan";
$hasil_statistik = mysqli_query($koneksidb, $query_statistik);
$statistik = mysqli_fetch_assoc($hasil_statistik);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Histori Pesanan - Resto Jawa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      .admin-body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background-color: #f9f5f0;
          color: #5D4037;
          margin: 0;
          padding: 0;
      }

      .admin-navbar {
          background-color: #5D4037;
          height: 72px;
          padding: 0 20px;
          box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }

      .admin-nav-active {
          background-color: #FFF8E1 !important;
          color: #5D4037 !important;
          border-radius: 8px;
          font-weight: 600;
          padding: 8px 16px !important;
      }

      .admin-nav-link {
          color: #FFF8E1 !important;
          font-weight: 500;
          border-radius: 8px;
          padding: 8px 16px !important;
          transition: all 0.3s ease;
          margin: 0 5px;
      }

      .admin-nav-link:hover {
          background-color: rgba(255, 255, 255, 0.1) !important;
          color: #FFD54F !important;
      }

      .admin-logout-btn {
          background-color: #FFF8E1;
          color: #5D4037;
          border: none;
          border-radius: 8px;
          padding: 8px 16px;
          font-weight: 600;
          transition: all 0.3s ease;
      }

      .admin-logout-btn:hover {
          background-color: #FFD54F;
          color: #5D4037;
      }

      .stat-card {
          display: flex;
          align-items: center;
          padding: 25px 20px;
          border-radius: 12px;
          color: white;
          box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
          transition: all 0.3s ease;
          height: 120px;
      }

      .stat-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
      }

      .stat-card-primary {
          background: linear-gradient(135deg, #5D4037, #8D6E63);
      }

      .stat-card-success {
          background: linear-gradient(135deg, #388E3C, #4CAF50);
      }

      .stat-card-warning {
          background: linear-gradient(135deg, #F57C00, #FF9800);
      }

      .stat-card-danger {
          background: linear-gradient(135deg, #d32f2f, #f44336);
      }

      .stat-card-icon {
          font-size: 2.8rem;
          margin-right: 20px;
          opacity: 0.9;
      }

      .stat-card-content h3 {
          font-size: 2.2rem;
          margin-bottom: 8px;
          font-weight: 700;
      }

      .stat-card-content p {
          margin-bottom: 0;
          font-size: 1rem;
          opacity: 0.95;
      }

      /* Admin Card */
      .admin-card {
          background-color: white;
          border-radius: 12px;
          box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
          overflow: hidden;
          border: none;
      }

      .admin-card-header {
          background-color: #5D4037;
          color: #FFF8E1;
          padding: 18px 25px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .admin-card-body {
          padding: 25px;
      }

      /* Admin Table */
      .admin-table {
          margin-bottom: 0;
          border-collapse: separate;
          border-spacing: 0;
          width: 100%;
      }

      .admin-table-header {
          background-color: #f8f9fa;
          border-bottom: 2px solid #5D4037;
      }

      .admin-table th {
          border-top: none;
          font-weight: 600;
          color: #5D4037;
          padding: 15px 12px;
          background-color: #FFF8E1;
      }

      .admin-table td {
          padding: 12px 12px;
          vertical-align: middle;
          border-bottom: 1px solid #f0f0f0;
      }

      .admin-table tbody tr {
          transition: all 0.2s ease;
      }

      .admin-table tbody tr:hover {
          background-color: rgba(93, 64, 55, 0.05);
          transform: scale(1.002);
      }

      /* Status Badge */
      .status-badge {
          padding: 6px 12px;
          border-radius: 20px;
          font-size: 0.85rem;
          font-weight: 600;
          text-transform: uppercase;
          letter-spacing: 0.5px;
          display: inline-block;
          text-align: center;
          min-width: 80px;
      }

      .status-proses {
          background-color: #FFF8E1;
          color: #5D4037;
          border: 1px solid #FFD54F;
      }

      .status-selesai {
          background-color: #4CAF50;
          color: white;
          border: 1px solid #388E3C;
      }

      .status-batal {
          background-color: #f44336;
          color: white;
          border: 1px solid #d32f2f;
      }

      /* Action Buttons */
      .btn-action {
          border: none;
          border-radius: 6px;
          padding: 8px 12px;
          cursor: pointer;
          transition: all 0.2s ease;
          font-size: 0.85rem;
          font-weight: 600;
          display: flex;
          align-items: center;
          justify-content: center;
          min-width: 80px;
      }

      .btn-selesai {
          background-color: #4CAF50;
          color: white;
          border: 1px solid #388E3C;
      }

      .btn-selesai:hover {
          background-color: #388E3C;
          transform: scale(1.05);
          color: white;
      }

      .btn-batal {
          background-color: #f44336;
          color: white;
          border: 1px solid #d32f2f;
      }

      .btn-batal:hover {
          background-color: #d32f2f;
          transform: scale(1.05);
          color: white;
      }

      .card-section {
          background-color: white;
          border-radius: 0.5rem;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          margin-bottom: 2rem;
      }

      .card {
          border: 2px solid #e9ecef;
          border-radius: 0.5rem;
          padding: 1.25rem;
          transition: all 0.3s ease;
          height: 100%;
      }
    </style>
  </head>

<body class="admin-body histori-container">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg admin-navbar">
        <div class="container-fluid">
            <p class="text-white mb-0 me-5">
              <a class="navbar-brand text-white d-block" href="HomeAdmin.php"><b>Resto Jawa</b></a>
              <span class="small">Admin Dashboard</span>
            </p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link admin-nav-link" href="HomeAdmin.php"><i class="fas fa-tachometer-alt me-2"></i><b>Dashboard</b></a>
                    </li>
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link admin-nav-link" href="LihatMenuAdmin.php"><i class="fas fa-utensils me-2"></i><b>Kelola Menu</b></a>
                    </li>
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link admin-nav-active" href="LihatHistoriPesanan.php"><i class="fas fa-history me-2"></i><b>Histori Pesanan</b></a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <form action="" method="post">
                      <button type="submit" class="btn admin-logout-btn" name="logout">
                        <i class="fas fa-sign-out-alt me-2"></i><b>Keluar</b>
                      </button>
                    </form>
                  </li>
                </ul>
            </div>
        </div>
    </nav>
  
    <div class="container">
      <div class="card-section">

        <!-- Header -->
        <div class="admin-header">
            <div class="row m-3">
                <h1 class="mb-2">Histori Pesanan</h1>
                <p class="mb-0">Daftar riwayat pesanan yang sudah diproses</p>
            </div>
        </div>
    
        <!-- Statistik -->
        <div class="container mt-4">
          <div class="row">
            <div class="col-md-4 mb-4">
              <div class="stat-card stat-card-success">
                <div class="stat-card-icon">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-content">
                  <h3><?= $statistik['pesanan_selesai'] ?></h3>
                  <p>Pesanan Selesai</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="stat-card stat-card-danger">
                <div class="stat-card-icon">
                  <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-card-content">
                  <h3><?= $statistik['pesanan_batal'] ?></h3>
                  <p>Pesanan Batal</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="stat-card stat-card-primary">
                <div class="stat-card-icon">
                  <i class="fas fa-chart-bar"></i>
                </div>
                <div class="stat-card-content">
                  <h3><?= $statistik['total_pesanan'] ?></h3>
                  <p>Total Pesanan</p>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <!-- Konten Utama -->
        <div class="container">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="mb-0"><i class="fas fa-list-alt me-2"></i>Daftar Riwayat</h3>
                </div>
                <div class="admin-card-body">
                    <div class="table-responsive">
                        <table class="table admin-table">
                            <thead class="admin-table-header">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>No Meja</th>
                                    <th>Lauk 1</th>
                                    <th>Lauk 2</th>
                                    <th>Lauk 3</th>
                                    <th>Minuman</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($jumlah_data > 0) {
                                    while($data = mysqli_fetch_array($hasil)){
                                ?>
                                <tr>
                                    <td><strong>#<?= $data['IDPesanan'] ?></strong></td>
                                    <td>Meja <?= $data['NoMeja'] ?></td>
                                    <td><?= $data['NamaLauk1'] ?? '-' ?></td>
                                    <td><?= $data['NamaLauk2'] ?? '-' ?></td>
                                    <td><?= $data['NamaLauk3'] ?? '-' ?></td>
                                    <td><?= $data['NamaMinuman'] ?? '-' ?></td>
                                    <td><strong>Rp <?= number_format($data['Total'], 0, ',', '.') ?></strong></td>
                                    <td>
                                        <span class="status-badge status-selesai">
                                            <i class="fas fa-check me-1"></i>Selesai
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h4>Belum ada pesanan yang selesai</h4>
                                            <p>Semua pesanan yang sudah selesai akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Info Jumlah Data -->
                    <div class="data-count">
                        <i class="fas fa-info-circle me-2"></i>
                        Menampilkan <?= $jumlah_data ?> pesanan yang sudah selesai
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>