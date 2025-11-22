<?php

include "function.php";

// Mengecek apakah "Role" sesinya Admin
if($_SESSION["Role"] != "Admin") {

  // Jika Bukan Admin
  echo "
          <script>
              alert('Anda Tidak Memiliki Akses');
              document.location.href = '../Index.php';
          </script>
      ";
}

// Mengecek apakah tombol logout dipencet
if(isset($_POST["logout"])) {

  // Memanngil fungsi logout
  logout();
}

$query = "SELECT a.NoMeja, b.* FROM datameja a, pesanan b WHERE a.IDMeja = b.IDMeja AND b.Status = 'Proses'";
$hasil = mysqli_query($koneksidb, $query);

// Query untuk statistik
$query_statistik = "SELECT 
                    COUNT(CASE WHEN Status = 'Proses' THEN 1 END) as pesanan_proses,
                    COUNT(CASE WHEN Status = 'Selesai' THEN 1 END) as pesanan_selesai,
                    COUNT(CASE WHEN Status = 'Batal' THEN 1 END) as pesanan_batal,
                    COUNT(*) as total_pesanan
                    FROM pesanan";
$hasil_statistik = mysqli_query($koneksidb, $query_statistik);
$statistik = mysqli_fetch_assoc($hasil_statistik);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - Resto Jawa</title>
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

  <body class="admin-body">
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
                        <a class="nav-link active admin-nav-active" href="HomeAdmin.php"><i class="fas fa-tachometer-alt me-2"></i><b>Dashboard</b></a>
                    </li>
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link admin-nav-link" href="LihatMenuAdmin.php"><i class="fas fa-utensils me-2"></i><b>Kelola Menu</b></a>
                    </li>
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link admin-nav-link" href="LihatHistoriPesanan.php"><i class="fas fa-history me-2"></i><b>Histori Pesanan</b></a>
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
            <h1 class="mb-2">Dashboard Admin</h1>
            <p class="mb-0">Selamat datang di dashboard admin Resto Jawa</p>
          </div>
        </div>
    
        <!-- Tabel Pesanan -->
        <div class="container">
          <div class="admin-card">
            <div class="admin-card-header">
              <h3 class="mb-0"><i class="fas fa-list-alt me-2"></i>Pesanan Terkini</h3>
            </div>
            <div class="admin-card-body">
              <div class="table-responsive">
                <table class="table table-hover admin-table">
                  <thead class="admin-table-header">
                    <tr>
                      <th>ID Reservasi</th>
                      <th>ID Pesanan</th>
                      <th>No Meja</th>
                      <th>Lauk 1</th>
                      <th>Lauk 2</th>
                      <th>Lauk 3</th>
                      <th>Minuman</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($data = mysqli_fetch_array($hasil)) {?>
                    <tr>
                      <td><?= $data["IDReservasi"]; ?></td>
                      <td><?= $data["IDPesanan"]; ?></td>
                      <td><?= $data["NoMeja"]; ?></td>
                      <td><?= $data["IDLauk1"]; ?></td>
                      <td><?= $data["IDLauk2"]; ?></td>
                      <td><?= $data["IDLauk3"]; ?></td>
                      <td><?= $data["IDMinuman"]; ?></td>
                      <td>Rp <?= number_format($data["Total"], 0, ',', '.'); ?></td>
                      <td>
                        <?php 
                        $status = $data["Status"];
                        if($status == "Proses") {
                          echo '<span class="status-badge status-proses">'.$status.'</span>';
                        } elseif($status == "Selesai") {
                          echo '<span class="status-badge status-selesai">'.$status.'</span>';
                        } elseif($status == "Batal") {
                          echo '<span class="status-badge status-batal">'.$status.'</span>';
                        } else {
                          echo '<span class="status-badge">'.$status.'</span>';
                        }
                        ?>
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <button class="btn-action btn-selesai">
                            <i class="fas fa-check me-1"></i>Selesai
                          </button>
                          <button class="btn-action btn-batal">
                            <i class="fas fa-times me-1"></i>Batal
                          </button>
                        </div>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>