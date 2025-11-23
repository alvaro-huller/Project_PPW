<?php 

include "../koneksi.php";

// Fungsi menambahkan data menu ke tabel menu di database restojawadb
function tambahDataMenu($data){
    global $koneksidb;
    $eror = 0;

    $gambar = uploadGambar();
    $nama = $data["nama_menu"];
    $harga = $data["harga"];
    $kategori = $data["kategori"];
    $deskripsi = $data["deskripsi"];

    if($kategori === "Lauk") {
        // Query untuk menambahkan data lauk di tabel lauk di database restojawadb
        $query = "INSERT INTO datalauk (NamaLauk, HargaLauk, GambarLauk, Kategori, Deskripsi) values ('$nama', '$harga', '$gambar', '$kategori', '$deskripsi')";
        $eror = 1;
    }else if($kategori === "Minuman") {
        // Query untuk menambahkan data minuman di tabel minuman di database restojawadb
        $query = "INSERT INTO dataminuman (NamaMinuman, HargaMinuman, GambarMinuman, Kategori, Deskripsi) values ('$nama', '$harga', '$gambar', '$kategori', '$deskripsi')";
        $eror = 1;
    }

    // Menjalan Query diatas
    mysqli_query($koneksidb, $query);

    return $eror;
}


// Fungsi untuk mengolah input file gambar
function uploadGambar(){
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $tmpname = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];

    // Cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "<script>
                alert('pilih gambar terlebih dahulu');
            </script>";
        return false;
    }

    // Cek apakah yang diuplaod adalah gambar
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));

    if(!in_array($ekstensigambar, $ekstensigambarvalid)){
        echo "<script>
                alert('yang anda upload bukan gambar');
            </script>";
        return false;
    }

    // Cek ukuran terlalu besar
    if($ukuranfile > 1000000){
        echo "<script>
                alert('ukuran gambar terlalu besar');
            </script>";
        return false;
    }

    move_uploaded_file($tmpname, '../img/' . $namafile);

    return $namafile;
}


// Fungsi mengupdate data lauk atau minuman di database restojawadb
function updateDataMenu($data){
    global $koneksidb;
    $eror = 0;

    $id = $data["id"];
    $nama = $data["nama"];
    $kategori = $data["kategori"];
    $harga = $data["harga"];
    $deskripsi = $data["deskripsi"];

    if($kategori === "Lauk") {
        // Query untuk mengupdate data lauk di tabel datalauk di database restojawadb
        $query = "UPDATE datalauk SET NamaLauk = '$nama', HargaLauk = '$harga', Deskripsi = '$deskripsi' WHERE IDLauk = $id";
        $eror = 1;
    }else if($kategori === "Minuman") {
        // Query untuk mengupdate data minuman di tabel dataminuman di database restojawadb
        $query = "UPDATE dataminuman SET NamaMinuman = '$nama', HargaMinuman = '$harga', Deskripsi = '$deskripsi' WHERE IDMinuman = $id";
        $eror = 1;
    }

    mysqli_query($koneksidb, $query);

    return $eror;
}


// Fungsi menghapus data menu lauk atau minuman di database restojawadb
function hapusDataMenu($data, $kategori){
    global $koneksidb;

    $id = $data;
    $query = "SELECT * FROM datamenu WHERE IDMenu = $id";
    $hasil = mysqli_query($koneksidb, $query);
    $data = mysqli_fetch_assoc($hasil);

    $hapus = "../img/" . $data["GambarMenu"];

    unlink($hapus);

    if($kategori === "Lauk") {
        // Query untuk menghapus data lauk di tabel datalauk di database restojawadb
        $query = "DELETE FROM datalauk WHERE IDLauk = $id";
        mysqli_query($koneksidb, $query);
    }else if($kategori === "Minuman") {
        // Query untuk menghapus data minuman di tabel dataminuman di database restojawadb
        $query = "DELETE FROM datalauk WHERE IDLauk = $id";
        mysqli_query($koneksidb, $query);
        
    }

    echo "
        <script>
            alert('Data berhasil dihapus')
            setTimeout(function() { location.reload(); }, 1)
        </script>
    ";
}

// Fungsi untuk pemrosesan pesanan selesai
function pesananSelesai($data) {
    global $koneksidb;

    $idreservasi = $data["idreservasi"];
    $idmeja = $data["idmeja"];

    // Query untuk mencari bebarapa data dengan IDReservasi tertentu di tabel pesanan di database restojawadb
    $query = "SELECT IDLauk1, IDLauk2, IDLauk3, IDMinuman FROM pesanan WHERE IDReservasi = '$idreservasi'";
    $hasil = mysqli_query($koneksidb, $query);
    while($data = mysqli_fetch_assoc($hasil)) {

        // Proses pengecekan apakah id ada
        $idminuman = $data["IDMinuman"];
        $idlauks = [0, 0, 0];
        if($data["IDLauk1"] != 0) $idlauks[0] = 1;
        if($data["IDLauk2"] != 0) $idlauk2[1] = 1;
        if($data["IDLauk3"] != 0) $idlauk3[2]= 1;
        
        // Proses update total penjualan lauk
        foreach ($idlauks as $idlauk) {
            if($idlauk == 0) continue;

            // Query untuk mengupdate TotalPenjualan dengan IDLauk tertentu di tabel datalauk di database restojawadb
            $query = "UPDATE datalauk SET TotalPenjualan = TotalPenjualan + 1 WHERE IDLauk = '$idlauk'";
            mysqli_query($koneksidb, $query);
        }
        
        // Query untuk mengupdate TotalPenjualan dengan IDMinuman tertentu di tabel dataminuman di database restojawadb
        $query = "UPDATE dataminuman SET TotalPenjualan = TotalPenjualan + 1 WHERE IDMinuman = '$idminuman'";
        mysqli_query($koneksidb, $query);
    }

    // Query untuk mengupdate Status dengan IDReservasi tertentu di tabel pesanan di database restojawadb
    $query = "UPDATE pesanan SET Status = 'Selesai' WHERE IDReservasi = '$idreservasi'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengupdate Status dengan IDReservasi tertentu di tabel user di database restojawadb
    $query = "UPDATE user SET IDReservasi = 'Kosong' WHERE IDReservasi = '$idreservasi'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengupdate Status dengan IDMeja tertentu di tabel datameja di database restojawadb
    $query = "UPDATE datameja SET Status = 'Kosong' WHERE IDMeja = '$idmeja'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengapus data dengan IDReservasi tertentu di tabel reservasi di database restojawadb
    $query = "DELETE FROM reservasi WHERE IDReservasi = '$idreservasi'";
    mysqli_query($koneksidb, $query);

    echo "
        <script>
            alert('Pesanan telah dilakukan proses penyelesaian')
        </script>
    ";
}

// Fungsi untuk pembatalan pesanan
function batalPesanan($data) {
    global $koneksidb;

    $idreservasi = $data["idreservasi"];
    $idmeja = $data["idmeja"];

    // Query untuk mengupdate Status dengan IDMeja tertentu di tabel datameja di database restojawadb
    $query = "UPDATE datameja SET Status = 'Kosong' WHERE IDMeja = '$idmeja'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengupdate IDReservasi dengan IDReservasi tertentu di tabel user di database restojawadb
    $query = "UPDATE user SET IDReservasi = 'Kosong' WHERE IDReservasi = '$idreservasi'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengapus data dengan IDReservasi tertentu di tabel pesanan di database restojawadb
    $query = "DELETE FROM pesanan WHERE IDReservasi = '$idreservasi'";
    mysqli_query($koneksidb, $query);
    
    // Query untuk mengapus data dengan IDReservasi tertentu di tabel reservasi di database restojawadb
    $query = "DELETE FROM reservasi WHERE IDReservasi = '$idreservasi'";
    mysqli_query($koneksidb, $query);

    echo "
        <script>
            alert('Pesanan telah dilakukan proses penyelesaian')
        </script>
    ";
}

// Fungsi untuk melakukan logout website
function logout() {

    // Menghancurkan semua sesi yang ada
    session_destroy();
    return 1;
}
?>