<?php
include "function.php";
$query = "SELECT * FROM menu";
// $hasil = mysqli_query($koneksidb, $query);
$hasil = $koneksidb->query($query);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lihat Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">Komunitas Kucing</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="form.html">Daftar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="design.html">Design</a>
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
        echo("<pre>");
        while($data = mysqli_fetch_array($hasil)){
            ?>
            <tr>
            <td><?= $data['id']?></td>
            <td><img src="img/<?= $data['gambar']?>" alt=""></td>
            <td><?= $data['nama_menu']?></td>
            <td><?= $data['kategori']?></td>
            <td><?= $data['harga']?></td>
            <td><?= $data['deskripsi']?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>