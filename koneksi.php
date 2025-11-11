<?php 

// Mengkoneksikan ke database restojawadb
$hostname = "localhost";
$username = "root";
$password = "";
$database = "restojawadb";
$koneksidb = new mysqli($hostname, $username, $password, $database);

// Mengecek apakah database restojawadb berhasil dikoneksikan
if($koneksidb->connect_error){
    die("Koneksi Gagal" . $koneksidb->connect_error);
}

session_start();

?>