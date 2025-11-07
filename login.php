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
    <title>Login</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td><button type="submit" name="login">Login</button></td>
            </tr>
        </table>
    </form>

    <a href="RegistrasiUser.php"><button type="submit" name="register">Buat Akun</button></a>
</body>
</html>