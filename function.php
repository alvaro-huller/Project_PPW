<?php 

// Mengkoneksikan ke database restojawadb
$hostname = "localhost";
$username = "root";
$password = "";
$database = "restojawadb";

$koneksidb = new mysqli($hostname, $username, $password, $database);

if($koneksidb->connect_errno){
    die("Koneksi Gagal" . $koneksidb->connect_errno);
}


// fungsi menambahkan data ke restojawadb
function tambah($data){
    global $database, $koneksidb;

    $nama = $data["nama_menu"];
    $kategori = $data["kategori"];
    $harga = $data["harga"];
    $deskripsi = $data["deskripsi"];

    // query insert  data
    $tambah = "INSERT INTO $database (nama_menu , kategori, harga, deskripsi) values ('$nama', '$kategori', '$harga', '$deskripsi')";
    $koneksidb->query($tambah);
}

?>