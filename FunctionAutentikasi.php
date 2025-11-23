<?php 

include "koneksi.php";


// Funsgi menambah data user ke tabel user di database restojawadb
function tambahDataUser($data){
    global $koneksidb;

    $username = $data["username"];
    $password = $data["password1"];
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

    // Query untuk menambahkan data user baru ke tabel user di database restojawadb
    $query = "INSERT INTO user (IDReservasi, Username, Password, Role) VALUES ('Kosong','$username', '$password', 'Pelanggan')";
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
            return 1;
        }
    }
    
    // Query untuk mencari username user
    $query = "SELECT * FROM user WHERE Username = '$username'";
    $hasil = mysqli_query($koneksidb, $query);

    // cek username apakah ada
    if(mysqli_num_rows($hasil) === 1){
        // cek password apakah benar
        $data = mysqli_fetch_assoc($hasil);
        if($data["Password"] === $password){
            // Set session
            $_SESSION["Role"] = $data["Role"];
            $_SESSION["ID"] = $data["IDUser"];
            return 2;
        }
    }

    return 0;
}

?>