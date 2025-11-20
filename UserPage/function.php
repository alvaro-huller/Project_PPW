<?php 

include "../koneksi.php";

function pesanmakanan($data) {
    global $koneksidb;
    
    $jumlahorang = $data["jumlahorang"];
    $idmeja = $data["idmeja"];

    $hasil = mysqli_query($koneksidb, "SELECT * FROM datalauk");
    $jumlahlauk = mysqli_num_rows($hasil);

    $k = 0;
    for($i = 0; $i < $jumlahorang; $i++) {
        for($j = 1; $j <= $jumlahlauk; $j++) {
            $str = "lauk" . ++$k;
            if(isset($data[$str])){
                $lauk[$i][] = $data[$str];
            }
        }
    }

    $hasil = mysqli_query($koneksidb, "SELECT * FROM dataminuman");
    $jumlahminuman = mysqli_num_rows($hasil);
    
    $k = 0;
    for($i = 0; $i < $jumlahorang; $i++) {
        for($j = 1; $j <= $jumlahminuman; $j++) {
            $str = "minuman" . ++$k;
            if(isset($data[$str])){
                $minuman[$i] = $data[$str];
            }
        }
    }

    $idreservasi = uniqid();

    $query = "INSERT INTO reservasi (IDReservasi, IDMeja) VALUES ('$idreservasi', '$idmeja')";
    mysqli_query($koneksidb, $query);

    for($i = 0; $i < $jumlahorang; $i++) {
        $lauk1 = $lauk[$i][0] ?? 0;
        $lauk2 = $lauk[$i][1] ?? 0;
        $lauk3 = $lauk[$i][2] ?? 0; 
        $idminuman = $minuman[$i];

        $query = "SELECT sum(HargaMenu) AS total FROM datalauk WHERE IDMenu = '$lauk1' OR IDMenu = '$lauk2' OR IDMenu = '$lauk3'";
        $hasil = mysqli_query($koneksidb, $query);
        $totallauk = mysqli_fetch_assoc($hasil);
        $query = "SELECT HargaMinuman AS total FROM dataminuman WHERE IDMinuman = '$idminuman'";
        $hasil = mysqli_query($koneksidb, $query);
        $totalminuman = mysqli_fetch_assoc($hasil);
        $total = $totallauk["total"] + $totalminuman["total"]; 

        $query = "INSERT INTO pesanan (IDReservasi, IDMeja, IDLauk1, IDLauk2, IDLauk3, IDMinuman, Total, Status) VALUES ('$idreservasi', '$idmeja', '$lauk1', '$lauk2', '$lauk3', '$idminuman', '$total', 'Proses')";
        mysqli_query($koneksidb, $query);
    }

    header("location: HomePage.php");
}

?>