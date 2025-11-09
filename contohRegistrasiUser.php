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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Resto Jawa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/loginstyle.css">
</head>
<body>
    <div class="batik-background"></div>
    <div class="container page-container">
        <div class="card">
            <div class="card-header">
                <div class="logo">Resto Jawa</div>
                <h2 class="mb-3">Daftar Akun Baru</h2>
                <p class="welcome-text">Buat akun untuk mulai reservasi di Resto Jawa</p>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="regUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="regUsername" name="username" placeholder="Pilih username Anda">
                    </div>
                    <div class="mb-3">
                        <label for="regPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="regPassword" name="password" placeholder="Buat password Anda">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="password2" placeholder="Ulangi password Anda">
                    </div>
                    
                    <button type="submit" name="register" class="btn btn-primary">Daftar</button>
                    <div class="text-center">
                        <span>Sudah punya akun? </span>
                        <a href="Index.php" class="link-text">Login sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>