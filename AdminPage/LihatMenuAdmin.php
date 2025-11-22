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
  session_destroy();
  header("location: ../Index.php");
}

$query = "SELECT * FROM datalauk";
$hasillauk = mysqli_query($koneksidb, $query);

$query = "SELECT * FROM dataminuman";
$hasilminuman = mysqli_query($koneksidb, $query);

if(isset($_POST["hapus"])) {
    hapusDataMenu($_POST["hapus"]);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Menu - Resto Jawa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      /* Body */
      .admin-body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background-color: #f9f5f0;
          color: #5D4037;
          margin: 0;
          padding: 0;
      }

      /* Navbar */
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

      /* Header Dashboard */
      .admin-header {
          background-color: #5D4037;
          background: linear-gradient(rgba(93, 64, 55, 0.9), rgba(93, 64, 55, 0.9)), 
                      url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
          background-size: cover;
          background-position: center;
          margin-bottom: 30px;
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
                        <a class="nav-link admin-nav-link" href="HomeAdmin.php"><i class="fas fa-tachometer-alt me-2"></i><b>Dashboard</b></a>
                    </li>
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link admin-nav-active" href="LihatMenuAdmin.php"><i class="fas fa-utensils me-2"></i><b>Kelola Menu</b></a>
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
  
    <!-- Header -->
    <div class="admin-header">
        <div class="container py-5">
            <h1 class="text-white mb-2"><i class="fas fa-utensils me-3"></i>Kelola Menu</h1>
            <p class="text-white mb-0">Kelola daftar menu yang tersedia di Resto Jawa</p>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="container mb-5">
      <div class="admin-card">
        <div class="admin-card-header d-flex justify-content-between align-items-center">
          <h3 class="mb-0"><i class="fas fa-list-alt me-2"></i>Daftar Menu</h3>
          <a href="TambahMenu.php" class="btn admin-logout-btn">
            <i class="fas fa-plus me-2"></i>Tambah Menu
          </a>
        </div>
        <div class="admin-card-body">
          <div class="table-responsive">
            <table class="table table-hover admin-table">
              <thead class="admin-table-header">
                <tr>
                  <th>ID</th>
                  <th>Gambar</th>
                  <th>Nama Menu</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Deskripsi</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while($data = mysqli_fetch_array($hasillauk)){
                  if($data["IDLauk"] == 0) continue;
                ?>
                <tr>
                  <td><strong>#<?= $data['IDLauk'] ?></strong></td>
                  <td>
                    <img src="../img/<?= $data['GambarLauk'] ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #FFF8E1;" alt="<?= $data['NamaLauk'] ?>">
                  </td>
                  <td><strong><?= $data['NamaLauk'] ?></strong></td>
                  <td>
                    <span class="status-badge status-proses"><?= $data['Kategori'] ?></span>
                  </td>
                  <td><strong>Rp <?= number_format($data['HargaLauk'], 0, ',', '.') ?></strong></td>
                  <td>
                    <span class="status-badge <?= $data['Stok'] > 0 ? 'status-selesai' : 'status-batal' ?>">
                      <?= $data['Stok'] ?> porsi
                    </span>
                  </td>
                  <td class="small"><?= $data['Deskripsi'] ?></td>
                  <td>
                    <div class="d-flex gap-2 justify-content-center">
                      <form action="UpdateLauk.php" method="post">
                        <button type="submit" class="btn-action btn-selesai" name="id" value="<?= $data['IDLauk']; ?>">
                          <i class="fas fa-edit me-1"></i>Edit
                        </button>
                      </form>
                      <form action="" method="post">
                        <button type="submit" class="btn-action btn-batal" name="hapus" value="<?= $data['IDLauk']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                          <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                <?php
                }
                ?>
                
                <?php
                while($data = mysqli_fetch_array($hasilminuman)){
                ?>
                <tr>
                  <td><strong>#<?= $data['IDMinuman'] ?></strong></td>
                  <td>
                    <img src="../img/<?= $data['GambarMinuman'] ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #FFF8E1;" alt="<?= $data['NamaMinuman'] ?>">
                  </td>
                  <td><strong><?= $data['NamaMinuman'] ?></strong></td>
                  <td>
                    <span class="status-badge status-proses"><?= $data['Kategori'] ?></span>
                  </td>
                  <td><strong>Rp <?= number_format($data['HargaMinuman'], 0, ',', '.') ?></strong></td>
                  <td>
                    <span class="status-badge <?= $data['Stok'] > 0 ? 'status-selesai' : 'status-batal' ?>">
                      <?= $data['Stok'] ?> gelas
                    </span>
                  </td>
                  <td class="small"><?= $data['Deskripsi'] ?></td>
                  <td>
                    <div class="d-flex gap-2 justify-content-center">
                      <form action="UpdateMinuman.php" method="post">
                        <button type="submit" class="btn-action btn-selesai" name="id" value="<?= $data['IDMinuman']; ?>">
                          <i class="fas fa-edit me-1"></i>Edit
                        </button>
                      </form>
                      <form action="" method="post">
                        <button type="submit" class="btn-action btn-batal" name="hapus" value="<?= $data['IDMinuman']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                          <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>