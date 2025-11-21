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
    <title>Tambah Menu</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/Style.css">
</head>

<body>
<div class="container">
    <br>
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-header text-white text-center">
            <h3 class="mb-0">Resto Jawa</h3>
            <p class="mb-0 mt-1">Tambah Menu Baru</p>
        </div>
        <div class="card-body p-4">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="nama_menu" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="Lauk">Lauk</option>
                        <option value="Minuman">Minuman</option>
                    </select>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="LihatMenuAdmin.php" class="btn btn-brown">Kembali</a>
                    <button type="submit" name="tambah" class="btn btn-brown">Tambah Menu</button>
                </div>
            </form>
        </div>
    </div>
    <br>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>