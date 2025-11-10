<?php 

// Mengkoneksikan ke database restojawadb
$hostname = "localhost";
$username = "root";
$password = "";
$database = "restojawadb";
$koneksidb = new mysqli($hostname, $username, $password, $database);


// Mengecek apakah database restojawadb berhasil dikoneksikan
if($koneksidb->connect_errno){
    die("Koneksi Gagal" . $koneksidb->connect_errno);
}


// Fungsi menambahkan data menu ke tabel menu di database restojawadb
function tambahDataMenu($data){
    global $koneksidb;

    $gambar = uploadGambar();
    $nama = $data["nama_menu"];
    $harga = $data["harga"];
    $kategori = $data["kategori"];
    $stok = $data["stok"];
    $deskripsi = $data["deskripsi"];

    // Query untuk menambahkan data ke tabel menu di database restojawadb
    $query = "INSERT INTO datamenu (NamaMenu, HargaMenu, GambarMenu, Kategori, Stok, Deskripsi) values ('$nama', '$harga', '$gambar', '$kategori', '$stok', '$deskripsi')";
    mysqli_query($koneksidb, $query);

    return mysqli_error($koneksidb);
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


// Fungsi mengupdate data menu di tabel menu di database restojawadb
function updateDataMenu($data){
    global $koneksidb;

    $id = $data["id"];
    $nama = $data["nama_menu"];
    $kategori = $data["kategori"];
    $harga = $data["harga"];
    $stok = $data["stok"];
    $deskripsi = $data["deskripsi"];

    // Query untuk mengupdate data di tabel menu di database restojawadb
    $query = "query menu SET NamaMenu = '$nama', Kategori = '$kategori', HargaMenu = '$harga', Stok = '$stok', Deskripsi = '$deskripsi' WHERE IDMenu = $id";
    mysqli_query($koneksidb, $query);
}


// Fungsi menghapus data menu di tabel menu di database restojawadb
function hapusDataMenu($data){
    global $koneksidb;

    $id = $data;
    $query = "SELECT * FROM datamenu WHERE IDMenu = $id";
    $hasil = mysqli_query($koneksidb, $query);
    $data = mysqli_fetch_assoc($hasil);

    $hapus = "../img/" . $data["GambarMenu"];

    unlink($hapus);

    // Query untuk menghapus data di tabel menu di database restojawadb
    $query = "DELETE FROM datamenu WHERE IDMenu = $id";
    mysqli_query($koneksidb, $query);
    echo "<script>alert('File berhasil dihapus');</script>";
    echo "<script>setTimeout(function() { location.reload(); }, 1);</script>";
}


// Funsgi menambah data user ke tabel user di database restojawadb
function tambahDataUser($data){
    global $koneksidb;

    $username = $data["username"];
    $password = $data["password"];
    $password2 = $data["password2"];

    // Cek apakah username sudah digunakan
    $query = "SELECT Username FROM user WHERE Username = '$username'";
    $result = mysqli_query($koneksidb, $query);
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('username yang dipilih sudah ada');
            </script>";
        return false;
    }

    // Cek apakah konfirmasi password benar
    if($password !== $password2){
        echo "<script>
                alert('konfirmasi password tidak sesuai');
            </script>";
        return false;
    }

    // Enkirpsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan userbaru ke database
    $query = "INSERT INTO user (Username, Password, Role) VALUES ('$username', '$password', 'pelanggan')";
    mysqli_query($koneksidb, $query);

    return mysqli_affected_rows($koneksidb);
}

function login($data){
    global $koneksidb;

    $username = $data["username"];
    $password = $data["password"];

    $query = "SELECT * FROM pegawai WHERE Username = '$username'";
    $hasil = mysqli_query($koneksidb, $query);

    // cek username
    if(mysqli_num_rows($hasil) === 1){
        // cek password
        $data = mysqli_fetch_assoc($hasil);
        if($password === "admin123"){
            // set session
            $_SESSION["Role"] = $data["Role"];
            header("Location: HomeAdmin.php");
            return 1;
        }
    }
    
    $query = "SELECT * FROM user WHERE Username = '$username'";
    $hasil = mysqli_query($koneksidb, $query);

    // cek username
    if(mysqli_num_rows($hasil) === 1){
        // cek password
        $data = mysqli_fetch_assoc($hasil);
        if(password_verify($password, $data["password"])){
            // set session
            $_SESSION["Role"] = $data["Role"];
            header("Location: HomePage.php");
            return 1;
        }
    }

    return 0;
}

?>