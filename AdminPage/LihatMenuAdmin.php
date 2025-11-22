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

// Query untuk mengambil semua data yang ada di tabel datalauk di database restojawadb
$query = "SELECT * FROM datalauk";
$hasillauk = mysqli_query($koneksidb, $query);

// Query untuk mengambil semua data yang ada di tabel dataminuman di database restojawadb
$query = "SELECT * FROM dataminuman";
$hasilminuman = mysqli_query($koneksidb, $query);

// Mengecek apakah tombol hapuslauk atau tombol hapusminuman dipencet
if(isset($_POST["hapuslauk"])){

  // Memanggil fungsi hapusDataMenu() dengan parameter $_POST dan kategori
  hapusDataMenu($_POST["hapuslauk"], "Lauk");
}else if(isset($_POST["hapusminuman"])) {

  // Memanggil fungsi hapusDataMenu() dengan parameter $_POST dan kategori
  hapusDataMenu($_POST["hapusminuman"], "Minuman");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Menu - Resto Jawa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        <a class="nav-link active admin-nav-active" href="LihatMenuAdmin.php"><i class="fas fa-utensils me-2"></i><b>Kelola Menu</b></a>
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
                      <form action="UpdateMenu.php" method="post">
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
                      <form action="UpdateMenu.php" method="post">
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