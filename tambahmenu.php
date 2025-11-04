<?php 

// Menghubungkan ke file function.php
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


// Mengecek apakah tombol tambah sudah ditekan
if(isset($_POST["tambah"])) {

    // Memanggil fungsiDataMenu() untuk menambahkan data dengan mengirimkan $_POST sebagai parameter
    if(tambahDataMenu($_POST) > 0) {

        // Jika data berhasil ditambahkan
        echo "
            <script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'HomeAdmin.php';
            </script>
        ";
    }else {

        // Jika data gagal ditambahkan
        echo "
            <script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'HomeAdmin.php';
            </script>
        ";
    }
}

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
                <td><input type="text" name="nama_menu" required></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>
                    <select name="kategori" required>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Harga</td>
                <td><input type="number" name="harga" required></td>
            </tr>
            <tr>
                <td>Stok</td>
                <td><input type="number" name="stok" required></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><textarea name="deskripsi" cols="30" rows="10"></textarea></td>
            </tr>
            <tr>
                <td>Gambar</td>
                <td><input type="file" name="gambar"></td>
            </tr>
            <tr>

                <td><button type="submit" name="tambah">Tambah Menu</button></td>
            </tr>
        </table>
    </form>
</body>
</html>