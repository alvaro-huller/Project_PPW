<?php 

include "function.php";

// Mengecek apakah tombol register sudah ditekan
if(isset($_POST["register"])) {

    // Memanggil fungsiDataMenu() untuk menambahkan data dengan mengirimkan $_POST sebagai parameter
    if(tambahDataUser($_POST) > 0) {

        // Jika data berhasil ditambahkan
        echo "
            <script>
                alert('Akun Berhasil Dibuat');
                document.location.href = 'Index.php';
            </script>
        ";
    }else {

        // Jika data gagal ditambahkan
        echo "
            <script>
                alert('Akun Gagal Dibuat');
                document.location.href = 'Index.php';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/Style.css">
</head>
<body id="login-page">
    <div class="container card-container">
        <div class="card">
            <div class="card-header">
                <h3>Resto Jawa</h3>
                <p class="m-1">Selamat datang di Resto Jawa!<br>
                    Buat Akun Untuk Reservasi</p>
                
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan Username Anda">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password1" class="form-control" placeholder="Masukkan Password Anda">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password2" class="form-control" placeholder="Konfirmasi Password Anda">
                    </div>
                    <button type="submit" id="tombol-registrasi" name="registrasi" class="btn btn-warning">BUAT AKUN</button>
                </form>
                <p>Sudah Punya Akun? <a id="hl" href="Index.php">Login Sekarang</a></p>
            </div>
        </div>
    </div>
</body>

</html>