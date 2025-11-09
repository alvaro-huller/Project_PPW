<?php 

include "function.php";

session_start();

// Mengecek apakah tombol login sudah ditekan
if(isset($_POST["login"])) {

    // Memanggil fungsi login() untuk
    if(login($_POST) == 0) {

        // Jika gagal login
        echo "
            <script>
                alert('Gagal Login');
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
    <title>Login Resto Jawa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/loginstyle.css">
</head>
<body>
    <div class="batik-background"></div>
    <div class="container page-container">
        <div class="card">
            <div class="card-header">
                <div class="logo">Resto Jawa</div>
                <h2 class="mb-3">Login ke Akun Anda</h2>
                <p class="welcome-text">Selamat datang di Resto Jawa!</p>
                <p class="welcome-text">Silakan login untuk melanjutkan.</p>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username Anda">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda">
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                    <div class="text-center">
                        <span>Belum punya akun? </span>
                        <a href="RegistrasiUser.php" class="link-text">Daftar sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>