<?php 

include "../koneksi.php";

function pesanmakanan($data) {
    global $koneksidb;

    $hasil = mysqli_query($koneksidb, "SELECT * FROM datamenu WHERE Kategori = 'Lauk'");
    $jumlah = mysqli_num_rows($hasil);

    $jumlahorang = $_POST["jumlahorang"];
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

    $query = "INSERT INTO reservasi (IDReservasi, IDMeja) VALUES ('$idreservasi', '$idmeja')";
    mysqli_query($koneksidb, $query);

    for($i = 0; $i < $jumlahorang; $i++) {
        $lauk1 = (isset($lauk[$i][0])) ? $lauk[$i][0] : 0;
        $lauk2 = (isset($lauk[$i][0])) ? $lauk[$i][1] : 0;
        $lauk3 = (isset($lauk[$i][0])) ? $lauk[$i][2] : 0;
        $idminuman = 0;

        $query = "SELECT sum(HargaMenu) AS total FROM datamenu WHERE IDMenu = '$lauk1' OR IDMenu = '$lauk2' OR IDMenu = '$lauk3'";
        $hasil = mysqli_query($koneksidb, $query);
        $data = mysqli_fetch_assoc($hasil);
        $total = $data["total"]; 

        $query = "INSERT INTO pesanan (IDReservasi, IDMeja, IDLauk1, IDLauk2, IDLauk3, IDMinuman, Total, Status) VALUES ('$idreservasi', '$idmeja', '$lauk1', '$lauk2', '$lauk3', '$idminuman', '$total', 'Proses')";
        mysqli_query($koneksidb, $query);
    }

    header("location: PesanMinuman.php");
}

function pesanminuman($data) {
    header("location: HpmePage.php");
}

?>