<?php 

// Menghubungkan ke file function.php
include "function.php";


// Mengecek apakah tombol tambah sudah ditekan
if(isset($_POST["tambah"])) {

    // Memanggil fungsiDataMenu() untuk menambahkan data dengan mengirimkan $_POST sebagai parameter
    if(tambahDataMenu($_POST) > 0) {

        // Jika data berhasil ditambahkan
        echo "
            <script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'index.php';
            </script>
        ";
    }else {

        // Jika data gagal ditambahkan
        echo "
            <script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'index.php';
            </script>
        ";
    }
}

?>