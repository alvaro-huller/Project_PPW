<?php 

include "../koneksi.php";

// Fungsi menambahkan data menu ke tabel menu di database restojawadb
function tambahDataMenu($data){
    global $koneksidb;

    $gambar = uploadGambar();
    $nama = $data["nama_menu"];
    $harga = $data["harga"];
    $kategori = $data["kategori"];
    $stok = $data["stok"];
    $deskripsi = $data["deskripsi"];

    if($kategori === "Lauk") {
        // Query untuk menambahkan data lauk di tabel lauk di database restojawadb
        $query = "INSERT INTO datalauk (NamaLauk, HargaLauk, GambarLauk, Kategori, Stok, Deskripsi) values ('$nama', '$harga', '$gambar', '$kategori', '$stok', '$deskripsi')";
    }else if($kategori === "Minuman") {
        // Query untuk menambahkan data minuman di tabel minuman di database restojawadb
        $query = "INSERT INTO datalauk (NamaLauk, HargaLauk, GambarLauk, Kategori, Stok, Deskripsi) values ('$nama', '$harga', '$gambar', '$kategori', '$stok', '$deskripsi')";
    }

    // Menjalan Query diatas
    mysqli_query($koneksidb, $query);
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
    $stok = $data["stok"];
    $deskripsi = $data["deskripsi"];

    if($kategori === "Lauk") {
        // Query untuk mengupdate data lauk di tabel datalauk di database restojawadb
        $query = "UPDATE datalauk SET NamaLauk = '$nama', HargaLauk = '$harga', Stok = '$stok', Deskripsi = '$deskripsi' WHERE IDLauk = $id";
        $eror = 1;
    }else if($kategori === "Minuman") {
        // Query untuk mengupdate data minuman di tabel dataminuman di database restojawadb
        $query = "UPDATE dataminuman SET NamaMinuman = '$nama', HargaMinuman = '$harga', Stok = '$stok', Deskripsi = '$deskripsi' WHERE IDMinuman = $id";
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


// Fungsi untuk melakukan logout website
function logout() {

    // Menghancurkan semua sesi yang ada
    session_destroy();
    header("location: ../index.php");
}
?>