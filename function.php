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


// fungsi menambahkan data menu ke tabel menu di database restojawadb
function tambahDataMenu($data){
    global $koneksidb;

    $nama = $data["nama_menu"];
    $kategori = $data["kategori"];
    $harga = $data["harga"];
    $deskripsi = $data["deskripsi"];
    $gambar = uploadGambar();

    // query untuk menambahkan data ke tabel menu di database restojawadb
    $tambah = "INSERT INTO menu (gambar, nama_menu , kategori, harga, deskripsi) values ('$gambar', '$nama', '$kategori', '$harga', '$deskripsi')";
    $koneksidb->query($tambah);

    return mysqli_error($koneksidb);
}


// fungsi untuk mengolah input file gambar
function uploadGambar(){
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $tmpname = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "<script>
                alert('pilih gambar terlebih dahulu');
            </script>";
        return false;
    }

    // cek apakah yang diuplaod adalah gambar
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));

    if(!in_array($ekstensigambar, $ekstensigambarvalid)){
        echo "<script>
                alert('yang anda upload bukan gambar');
            </script>";
        return false;
    }

    // cek ukuran terlalu besar
    if($ukuranfile > 1000000){
        echo "<script>
                alert('ukuran gambar terlalu besar');
            </script>";
        return false;
    }

    // generete nama gambar baru
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;
    move_uploaded_file($tmpname, 'img/' . $namafilebaru);

    return $namafilebaru;
}


// fungsi mengupdate data menu di tabel menu di database restojawadb
function updateDataMenu($data){
    global $koneksidb;

    $id = $data["id"];
    $gambar = $data["gambar"];
    $nama = $data["nama_menu"];
    $kategori = $data["kategori"];
    $harga = $data["harga"];
    $deskripsi = $data["deskripsi"];

    // query untuk mengupdate data di tabel menu di database restojawadb
    $update = "UPDATE menu SET gambar='$gambar', nama_menu='$nama' , kategori='$kategori', harga='$harga', deskripsi='$deskripsi' WHERE id=$id";
    $koneksidb->query($update);
}


// fungsi menghapus data menu di tabel menu di database restojawadb
function hapusDataMenu($data){
    global $koneksidb;

    $id = $data["id"];

    // query untuk menghapus data di tabel menu di database restojawadb
    $hapus = "DELETE FROM menu WHERE id = $id";
    $koneksidb->query($hapus);
}


function registrasi($data){
    global $db;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($db, $data["password"]);
    $password2 = mysqli_real_escape_string($db, $data["password2"]);

    // cek username
    $result = mysqli_query($db, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('username yang dipilih sudah ada');
            </script>";
        return false;
    }

    // cek konfirmasi password
    if($password !== $password2){
        echo "<script>
                alert('konfirmasi password tidak sesuai');
            </script>";
        return false;
    }

    // enkirpsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    $query = "INSERT INTO user VALUES (
                '',
                '$username',
                '$password')";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

?>