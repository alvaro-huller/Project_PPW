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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Pesanan</title>
</head>
<body>
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
</body>
</html>