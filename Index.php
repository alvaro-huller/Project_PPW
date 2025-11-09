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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/Style.css">
</head>

<body id="login-page">
    <div class="container card-container">
        <div class="card">
            <div class="card-header">
                <h3>Resto Jawa</h3>
                <p class="m-1">Selamat datang di Resto Jawa!<br>
                    Login Ke Akun Anda</p>
                
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan Username Anda">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password Anda">
                    </div>
                    <button type="submit" id="tombol-login" name="login" class="btn btn-warning">LOGIN</button>
                </form>
                <p>Belum Punya Akun? <a id="hl" href="RegistrasiUser.php">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>
</body>

</html>