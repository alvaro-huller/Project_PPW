<?php
include "function.php";

session_start();

  if($_SESSION["Role"] != "Admin") {
    echo "
            <script>
                alert('Anda Tidak Memiliki Akses');
                document.location.href = 'Index.php';
            </script>
        ";
  }
$query = "SELECT * FROM datamenu";
$hasil = mysqli_query($koneksidb, $query);

if(isset($_POST["hapus"])) {
    $id = $_POST["id"];
    $query = "DELETE FROM datamenu WHERE id = $id";
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lihat Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/Style.css">
  </head>

  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <p class="text-white mb-0 me-5">
              <a class="navbar-brand text-white d-block" href="HomeAdmin.php"><b>Resto Jawa</b></a>
              <span class="small">Admin</span>
            </p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link text-white" href="HomeAdmin.php"><b>Dashboard</b></a>
                    </li>
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link active bg-warning" href="LihatMenuAdmin.php"><b>Kelola Menu</b></a>
                    </li>
                    <li class="nav-item mx-auto p-2">
                        <a class="nav-link text-white" href="LihatHistoriPesanan.php"><b>Histori Pesanan</b></a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php"><b>Keluar</b></a>
                  </li>
                </ul>
            </div>
        </div>
    </nav>
  
    <!-- Deskripsi halaman -->
    <div class="container">
      <br>
        <h1>Daftar Menu</h1>
        <p>Kelola daftar menu yang ada di restoran.</p>
    </div>

    <!-- Tabel -->
    <div class="container">
        <table class="table table-striped table-bordered table-hover shadow">
            <tr>
                <td colspan="6" class="text-end">
                  <a href="TambahMenu.php" class="btn btn-brown">Tambah menu</a>
                </td>
            </tr>
            <tr>
                <th>ID Menu</th>
                <th>Gambar</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Deskripsi</th>
            </tr>
            <?php
            while($data = mysqli_fetch_array($hasil)){
            ?>
            <tr>
            <td><?= $data['id']?></td>
            <td><img src="img/<?= $data['GambarMenu']?>" alt=""></td>
            <td><?= $data['NamaMenu']?></td>
            <td><?= $data['Kategori']?></td>
            <td><?= $data['HargaMenu']?></td>
            <td><?= $data['Stok']?></td>
            <td><?= $data['Deskripsi']?></td>
            <td><form action="UpdateMenu.php" method="post"><button type="submit" class="btn btn-success cont" name="id" value="<?= $data['id']; ?>">Update Data</button></form></td>
            <td><form action="" method="post"><button type="submit" class="btn btn-success cont" name="hapus" value="<?= $data['id']; ?>" onclick="return confirm('yakin')">Hapus Data</button></form></td>
            </tr>
            <?php
            }
            ?>
    </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>