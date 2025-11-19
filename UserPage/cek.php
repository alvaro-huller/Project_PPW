<?php 

include "function.php";

$hasil = mysqli_query($koneksidb, "SELECT * FROM datamenu WHERE Kategori = 'Lauk'");
$jumlah = mysqli_num_rows($hasil);

$jumlahorang = $_POST["jumlahorang"];
$jam = $_POST["jam"];
$idmeja = $_POST["idmeja"];

for($i = 0; $i < $jumlahorang; $i++) {
    for($j = 0; $j < $jumlah; $j++) {
        $str = "btncheck" . $j+1;
        if(isset($_POST[$str])){
            $lauk[$i][] = $_POST[$str];
        }
    }
}

$idreservasi = uniqid();

$query = "INSERT INTO reservasi (IDReservasi, IDMeja) VALUES '$idreservasi, $idmeja'";
mysqli_query($koneksidb, $query);

$query = "INSERT INTO pesanan (IDMeja) VALUES '$idmeja'";
mysqli_query($koneksidb, $query);

?>