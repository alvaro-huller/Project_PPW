<?php 

include "FunctionAutentikasi.php";

// Mengecek apakah tombol login sudah ditekan
if(isset($_POST["login"])) {

    // Memanggil fungsi login() untuk proses login dengan mengrimkan $_POST sebagai parameter
    $return = login($_POST);
    if($return === 1) {

        // Jika berhasil login sebgai admin
        echo "
            <script>
                alert('Berhasil login sebagai admin');
                document.location.href = 'AdminPage/HomeAdmin.php';
            </script>
        ";
    }else if($return === 2) {

        // Jika berhasil login sebgai user
        echo "
            <script>
                alert('Berhasil login');
                document.location.href = 'UserPage/HomePage.php';
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
    
    <style>
        body {
            background-color: rgb(255, 233, 186);
        }

        .card-container {
            width: 500px;
            margin-top: 100px;
        }
        .card-header {
            color: antiquewhite;
            text-align: center;
            background-color: #8B4513;
        }
        #register-hl {
            text-decoration: none;
        }
        #register-hl:hover {
            text-decoration: underline;
        }
        #hl {
            text-decoration: none;
        }
        #hl:hover {
            text-decoration: underline;
        }
    </style>
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
                        <input type="text" name="username" class="form-control" placeholder="Masukkan Username Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password Anda" required>
                    </div>
                    <button type="submit" id="tombol-login" name="login" class="btn btn-warning">LOGIN</button>
                </form>
                <p>Belum Punya Akun? <a id="hl" href="RegistrasiUser.php">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>
</body>

</html>