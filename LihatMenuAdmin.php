<?php
include "function.php";

session_start();

  if($_SESSION["Role"] != "Admin") {
    echo "
            <script>
                alert('Anda Tidak Memiliki Akses');
                document.location.href = 'LoginPage.php';
            </script>
        ";
  }
$query = "SELECT * FROM menu";
// $hasil = mysqli_query($koneksidb, $query);
$hasil = $koneksidb->query($query);

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
    <link rel="stylesheet" href="style/Style.css">
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="home_admin.php"><b>Resto Jawa</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
<<<<<<< HEAD:lihatmenu.php
                        <a class="NavLink2" href="home_admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="NavLink1" href="lihatmenu.php">Lihat Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="NavLink2" href="tambahmenu.php">Tambah Menu</a>
=======
                        <a class="nav-link" href="HomeAdmin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="LihatMenuAdmin.php">Lihat Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="TambahMenu.php">Tambah Menu</a>
>>>>>>> f37cf6c15afced9c45285404e4d773d6caaaeb18:LihatMenuAdmin.php
                    </li>
                    <li class="nav-item">
                        <a class="NavLink2" href="transaksi.php">Transaksi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1>Daftar Menu</h1>
    <table border="1">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>