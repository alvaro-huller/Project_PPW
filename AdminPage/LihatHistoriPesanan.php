<?php
include "function.php";

if($_SESSION["Role"] != "Admin") {
echo "
        <script>
            alert('Anda Tidak Memiliki Akses');
            document.location.href = '../Index.php';
        </script>
    ";
}

  if(isset($_POST["logout"])) {
    unset($_SESSION["Role"]);
    header("location: ../Index.php");
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Histori Pesanan - Resto Jawa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
  
    <!-- Header -->
    <div class="histori-header">
        <div class="container">
            <h1 class="text-white mb-2"><i class="fas fa-history me-3"></i>Histori Pesanan</h1>
            <p class="text-white mb-0">Daftar semua pesanan yang sudah selesai dan dilayani</p>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="container">
        <div class="histori-card">
            <div class="histori-card-header">
                <h3 class="mb-0"><i class="fas fa-list-alt me-2"></i>Daftar Pesanan Selesai</h3>
            </div>
            <div class="histori-card-body">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>