<?php 

// Menghubungkan ke file function.php
include "function.php";

  if($_SESSION["Role"] != "Admin") {
    echo "
            <script>
                alert('Anda Tidak Memiliki Akses');
                document.location.href = '../Index.php';
            </script>
        ";
  }


// Mengecek apakah tombol update sudah ditekan
if(isset($_POST["update"])) {

    // Memanggil fungsi updateDataMenu() untuk mengupdate data dengan mengirimkan $_POST sebagai parameter
    if(updateDataMenu($_POST) > 0) {

        // Jika data berhasil diupdate
        echo "
            <script>
                alert('Data Berhasil Diupdate');
                document.location.href = 'LihatMenuAdmin.php';
            </script>
        ";
    }else {

        // Jika data gagal diupdate
        echo "
            <script>
                alert('Data Gagal Diupdate');
                document.location.href = 'LihatMenuAdmin.php';
            </script>
        ";
    }
}

$id = $_POST["id"];
$query = "SELECT * FROM datamenu WHERE IDMenu = $id";
$hasil = mysqli_query($koneksidb, $query);
$data = mysqli_fetch_assoc($hasil);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Nama Menu</td>
                <td><input type="text" name="nama_menu" required value="<?= $data["NamaMenu"] ?>"></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>
                    <select name="kategori" required>
                        <option value="makanan" <?php if($data["Kategori"] == "makanan") echo "selected" ?>>Makanan</option>
                        <option value="minuman" <?php if($data["Kategori"] == "minuman") echo "selected" ?>>Minuman</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Harga</td>
                <td><input type="number" name="harga" required value="<?= $data["HargaMenu"] ?>"></td>
            </tr>
            <tr>
                <td>Stok</td>
                <td><input type="number" name="stok" required value="<?= $data["Stok"] ?>"></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><textarea name="deskripsi" cols="30" rows="10" value="<?= $data["Deskripsi"] ?>"></textarea></td>
            </tr>
            <tr>

                <td><button type="submit" name="update">Update Menu</button></td>
            </tr>
        </table>
    </form>
</body>
</html>