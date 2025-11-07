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
$query = "SELECT * FROM pesanan WHERE Status = 'Served'";
$hasil = mysqli_query($koneksidb, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Histori Pesanan</title>
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
                        <a class="nav-link" href="HomeAdmin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="LihatMenuAdmin.php">Lihat Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="TambahMenu.php">Tambah Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="NavLink2" href="transaksi.php">Transaksi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1>Histori Pesanan</h1><br>
    <table border="1">
        <tr>
            <th>ID Pesanan</th>
            <th>ID Meja</th>
            <th>Jam</th>
            <th>ID Lauk 1</th>
            <th>ID Lauk 2</th>
            <th>ID Lauk 3</th>
            <th>ID Minuman</th>
            <th>Total</th>
        </tr>
        <?php
        while($data = mysqli_fetch_array($hasil)){
            ?>
            <tr>
            <td><?= $data['IDPesanan']?></td>
            <td><?= $data['IDMeja']?></td>
            <td><?= $data['Jam']?></td>
            <td><?= $data['IDLauk1']?></td>
            <td><?= $data['IDLauk2']?></td>
            <td><?= $data['IDLauk3']?></td>
            <td><?= $data['Minuman']?></td>
            <td><?= $data['Total']?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>