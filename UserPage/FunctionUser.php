<?php 

include "../koneksi.php";

// Fungsi untuk melakukan logout website
function logout() {

    // Menghancurkan semua sesi yang ada
    session_destroy();
    return 1;
}

// Fungsi untuk pemrosesan pemesanan menu
function pesanmenu($data) {
    global $koneksidb;
    
    $jumlahorang = $data["jumlahorang"];
    $idmeja = $data["idmeja"];

    // Query untuk menghitung jumlah data di tabel datalauk di database restojawadb
    $hasil = mysqli_query($koneksidb, "SELECT * FROM datalauk");
    $jumlahlauk = mysqli_num_rows($hasil);

    // Proses penyimpanan data lauk yang dipilih
    $k = 0;
    for($i = 0; $i < $jumlahorang; $i++) {
        for($j = 1; $j <= $jumlahlauk; $j++) {
            $str = "lauk" . ++$k;
            if(isset($data[$str])){
                $lauk[$i][] = $data[$str];
            }
        }
    }

    // Query untuk menghitung jumlah data di tabel dataminuman di database restojawadb
    $hasil = mysqli_query($koneksidb, "SELECT * FROM dataminuman");
    $jumlahminuman = mysqli_num_rows($hasil);
    
    // Proses penyimpanan data minuman yang dipilih
    $k = 0;
    for($i = 0; $i < $jumlahorang; $i++) {
        for($j = 1; $j <= $jumlahminuman; $j++) {
            $str = "minuman" . ++$k;
            if(isset($data[$str])){
                $minuman[$i] = $data[$str];
            }
        }
    }

    // Mengenerate id secara random
    $idreservasi = uniqid();

    // Query untuk menambahkan data di tabel reservasi di database restojawadb
    $query = "INSERT INTO reservasi (IDReservasi, IDMeja) VALUES ('$idreservasi', '$idmeja')";
    mysqli_query($koneksidb, $query);

    // Proses memasukkan data pesanan
    for($i = 0; $i < $jumlahorang; $i++) {

        // Pengecekan id lauk dan id minuman yang dipilih
        $lauk1 = $lauk[$i][0] ?? 0;
        $lauk2 = $lauk[$i][1] ?? 0;
        $lauk3 = $lauk[$i][2] ?? 0; 
        $idminuman = $minuman[$i];

        // Query untuk menghitung jumlah harga dari lauk yang dipilih
        $query = "SELECT sum(HargaLauk) AS total FROM datalauk WHERE IDLauk = '$lauk1' OR IDLauk = '$lauk2' OR IDLauk = '$lauk3'";
        $hasil = mysqli_query($koneksidb, $query);
        $totallauk = mysqli_fetch_assoc($hasil);

        // Query untuk mencari harga dari minuman yang dipilih
        $query = "SELECT HargaMinuman AS total FROM dataminuman WHERE IDMinuman = '$idminuman'";
        $hasil = mysqli_query($koneksidb, $query);
        $totalminuman = mysqli_fetch_assoc($hasil);

        $total = $totallauk["total"] + $totalminuman["total"]; 

        // Query untuk menambahkan data di tabel pesanan di database restojawadb
        $query = "INSERT INTO pesanan (IDReservasi, IDMeja, IDLauk1, IDLauk2, IDLauk3, IDMinuman, Total, Status) VALUES ('$idreservasi', '$idmeja', '$lauk1', '$lauk2', '$lauk3', '$idminuman', '$total', 'Proses')";
        mysqli_query($koneksidb, $query);

        $id = $_SESSION["ID"];

        // Query untuk mengupdate IDReservasi dengan IDUser tertentu di tabel user di database restojawadb
        $query = "UPDATE user SET IDReservasi = '$idreservasi' WHERE IDUser = '$id'";
        mysqli_query($koneksidb, $query);

        // Query untuk mengupdate Status dengan IDMeja tertentu di tabel datameja di database restojawadb
        $query = "UPDATE datameja SET Status = 'Penuh' WHERE IDMeja = '$idmeja'";
        mysqli_query($koneksidb, $query);
    }

    header("location: HomePage.php");
}

// Fungsi untuk pembatalan pesanan
function batalPesanan($data) {
    global $koneksidb;

    $idreservasi = $data["idreservasi"];
    $idmeja = $data["idmeja"];
    $iduser = $data["iduser"];

    // Query untuk mengupdate Status dengan IDMeja tertentu di tabel datameja di database restojawadb
    $query = "UPDATE datameja SET Status = 'Kosong' WHERE IDMeja = '$idmeja'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengupdate IDReservasi dengan IDUser tertentu di tabel user di database restojawadb
    $query = "UPDATE user SET IDReservasi = 'Kosong' WHERE IDUser = '$iduser'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengapus data dengan IDReservasi tertentu di tabel pesanan di database restojawadb
    $query = "DELETE FROM pesanan WHERE IDReservasi = '$idreservasi'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengapus data dengan IDReservasi tertentu di tabel reservasi di database restojawadb
    $query = "DELETE FROM reservasi WHERE IDReservasi = '$idreservasi'";
    mysqli_query($koneksidb, $query);

    header("location: HomePage.php");
}

?>