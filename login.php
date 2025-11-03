<?php 

include "function.php";

// Mengecek apakah tombol register sudah ditekan
if(isset($_POST["login"])) {

    // Memanggil fungsiDataMenu() untuk menambahkan data dengan mengirimkan $_POST sebagai parameter
    if(login($_POST) > 0) {

        // Jika data berhasil ditambahkan
        echo "
            <script>
                alert('Berhasil Login');
                document.location.href = 'login.php';
            </script>
        ";
    }else {

        // Jika data gagal ditambahkan
        echo "
            <script>
                alert('Gagal Login');
                document.location.href = 'login.php';
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
                <td>Konfirmasi Password</td>
                <td><input type="password" name="password2" required></td>
            </tr>
            <tr>
                <td><button type="register" name="register">Login</button></td>
            </tr>
        </table>
    </form>
</body>
</html>