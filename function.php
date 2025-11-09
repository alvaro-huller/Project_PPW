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

    // Query untuk menambahkan data user baru ke tabel user di database restojawadb
    $query = "INSERT INTO user (Username, Password, Role) VALUES ('$username', '$password', 'Pelanggan')";
    mysqli_query($koneksidb, $query);

    return mysqli_affected_rows($koneksidb);
}

// Fungsi pemeriksaan login website resto jawa
function login($data){
    global $koneksidb;

    $username = $data["username"];
    $password = $data["password"];

    // Query untuk mencari username admin
    $query = "SELECT * FROM pegawai WHERE Username = '$username'";
    $hasil = mysqli_query($koneksidb, $query);

    // cek username apakah ada
    if(mysqli_num_rows($hasil) === 1){

        // cek password apakah benar
        $data = mysqli_fetch_assoc($hasil);
        if($password === "admin123"){

            // Set session
            $_SESSION["Role"] = $data["Role"];
            header("Location: AdminPage/HomeAdmin.php");
        }
    }
    
    // Query untuk mencari username user
    $query = "SELECT * FROM user WHERE Username = '$username'";
    $hasil = mysqli_query($koneksidb, $query);

    // cek username apakah ada
    if(mysqli_num_rows($hasil) === 1){
        // cek password apakah benar
        $pw = mysqli_fetch_assoc($hasil);
        if($pw["Password"] === $password){
            echo "
            <script>
                alert('cek');
            </script>
        ";
            // Set session
            $_SESSION["Role"] = $data["Role"];
            header("Location: UserPage/HomePage.php");
        }
    }

    return 0;
}

?>