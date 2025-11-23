<?php 

include "FunctionUser.php";

// Mengecek apakah "Role" sesinya Pelanggan
if($_SESSION["Role"] != "Pelanggan") {

    // Jika bukan pelanggan
    echo "
        <script>
            alert('Anda Tidak Memiliki Akses');
            document.location.href = '../Index.php';
        </script>
    ";
}

// Mengecek apakah tombol logout dipencet
if(isset($_POST["logout"])) {

  // Memanngil fungsi logout untuk proses logout
  if(logout() > 0) {
    
    // Jika berhasil logout
    echo "
        <script>
            alert('Berhasil logout');
            document.location.href = '../Index.php';
        </script>
    ";
  }else {

    // Jika gagal logout
    echo "
        <script>
            alert('Gagal logout');
            document.location.href = 'HomeAdmin.php';
        </script>
    ";
  }
}

// Mngecek apakah tombol batal dipencet
if(isset($_POST["batal"])) {

    // Memanggil fungsi batalPesanan() untul membatalkan pesanan dengan mengirim $_POST sebagai parameter
    batalPesanan($_POST);
}

$iduser = $_SESSION["ID"];

// Query untuk mengambil data IDReservasi di tabel user di database restojawadb dengan IDUser tertentu
$query = "SELECT IDReservasi FROM user WHERE IDUser = '$iduser'";
$hasil = mysqli_query($koneksidb, $query);
$idreservasi = mysqli_fetch_assoc($hasil);
$idreservasi = $idreservasi["IDReservasi"];

// Query untuk mengambil beberapa data di tabel pesanan dan datameja dengan beberapa ketentuan
$query = "SELECT a.IDReservasi, a.IDMeja, b.NoMeja, b.Jam FROM pesanan a, datameja b WHERE a.IDMeja = b.IDMeja AND a.status = 'Proses' AND IDReservasi = '$idreservasi'"; 
$hasil = mysqli_query($koneksidb, $query);
$reservasi = mysqli_fetch_assoc($hasil);

// Query untuk mengambil semua data di tabel datalauk di database restojawadb
$query = "SELECT * FROM datalauk";
$hasillauk = mysqli_query($koneksidb, $query);

// Query untuk mengambil semua data di tabel dataminuman di database restojawadb
$query = "SELECT * FROM dataminuman";
$hasilminuman = mysqli_query($koneksidb, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/HomePage.css">
</head>
<body class="bodyuser">
    <!-- Navigation -->
    <nav id="usernav" class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="HomePage.php">Resto Jawa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#menu">Daftar Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Reservasiku
                        </button>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary" href="Reservasi.php" id="reservasi" >Reservasi</a>
                    </li>
                    <li class="nav-item ms-2">
                        <form action="" method="post"><button type="submit" class="btn btn-danger" name="logout">Logout</button></form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Selamat Datang<br>Di Resto Jawa</h1>
                    <p class="hero-subtitle">Experience the rich flavors and traditions of Java in every dish. Our restaurant brings you authentic recipes passed down through generations.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#menu" class="btn btn-primary btn-lg">Lihat Menu</a>
                        <a href="Reservasi.php" class="btn btn-outline-light btn-lg">Reservasi Meja</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://asset.kompas.com/crops/W4Rk5gx31HtfLjHYLSG4-cWrYU0=/0x0:780x390/780x390/data/photo/2012/12/27/1715322-set-memeriksa-goronggorong-780x390.jpg" alt="Restaurant Interior" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="menu-section" id="menu">
        <div class="container">

            <h2 class="section-title text-center">Daftar Lauk</h2>
            <div class="row">
                <?php while($data = mysqli_fetch_assoc($hasillauk)) {
                    if($data["IDLauk"] == 0) continue; ?>
                    <div class='col-md-6 col-lg-4'>
                        <div class='menu-item'>
                            <div class='menu-item-img' style='background-image: url("../img/<?= $data["GambarLauk"]; ?>");'></div>
                            <div class='menu-item-content'>
                                <h4 class='menu-item-title'><?= $data["NamaLauk"]; ?></h4>
                                <p><?= $data["Deskripsi"]; ?></p>
                                <div class='d-flex justify-content-between align-items-center mt-3'>
                                    <span class='menu-item-price'>RP <?= $data["HargaLauk"]; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            
            <h2 class="section-title text-center">Daftar Minuman</h2>
            <div class="row">
                <?php while($data = mysqli_fetch_assoc($hasilminuman)) { ?>
                    <div class='col-md-6 col-lg-4'>
                        <div class='menu-item'>
                            <div class='menu-item-img' style='background-image: url("../img/<?= $data["GambarMinuman"]; ?>");'></div>
                            <div class='menu-item-content'>
                                <h4 class='menu-item-title'><?= $data["NamaMinuman"]; ?></h4>
                                <p><?= $data["Deskripsi"]; ?></p>
                                <div class='d-flex justify-content-between align-items-center mt-3'>
                                    <span class='menu-item-price'>RP <?= $data["HargaMinuman"]; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <h2 class="section-title text-center">Visit Us</h2>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <h4>Location</h4>
                    <p>Kayangan</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <h4>Hours</h4>
                    <p>Senin - Jum'at: 10.00 - 20.00<br>Saturday - Sunday: Close</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <h4>Contact</h4>
                    <p>Phone: +62 6969 - 6969<br>Email: RestoJawa@gmail.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2023 Resto Jawa. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Modal Reservasi -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Reservasiku</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php if($idreservasi == "Kosong"){ ?>
                Anda Belum Melakukan Reservasi
            <?php } else{ ?>
                ID Reservasi = <?= $idreservasi; ?><br>
                No Meja = <?= $reservasi["NoMeja"]; ?><br>
                Jam = <?= $reservasi["Jam"]; ?>
            <?php } ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <?php if($idreservasi != "Kosong"){ ?>
                <form action="" method="post">
                    <button type="submit" class="btn btn-danger" name="batal" onclick="return confirm('Apakah Anda Yakin Ingin Membatalkan Pesanan?')">Batal</button>   
                    <input type="text" name="idreservasi" value="<?= $idreservasi ?>" hidden>
                    <input type="number" name="idmeja" value="<?= $reservasi['IDMeja'] ?>" hidden>
                    <input type="number" name="iduser" value="<?= $_SESSION['ID'] ?>" hidden>
                </form>
            <?php } ?>
            
        </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tombolreservasi = document.getElementById('reservasi')

            if("<?= $idreservasi ?>" != "Kosong") {
                tombolreservasi.removeAttribute('href');
            }else {
                tombolreservasi.setAttribute('href', 'Reservasi.php');
            }
            tombolreservasi.addEventListener('click', function() {
                if(this.getAttribute('href') == true) {
                    alert('Anda Sudah Melakukan Reservasi');
                }
            })
        })
    </script>
</body>
</html>