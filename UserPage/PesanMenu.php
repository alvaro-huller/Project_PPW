<?php 

include "function.php";

if($_SESSION["Role"] != "Pelanggan") {
    echo "
            <script>
                alert('Anda Tidak Memiliki Akses');
                document.location.href = '../Index.php';
            </script>
        ";
  }

if(isset($_POST["jumlahorang"])) {
    $jumlahorang = $_POST["jumlahorang"];
    $idmeja = $_POST["idmeja"];
}else {
    echo "
        <script>
            alert('Anda belum melakukan reservasi, reservasi meja terlebih dahulu');
            document.location.href = 'Reservasi.php'
        </script>
        ";
}


if(isset($_POST["pesanmakanan"])) {
    pesanmakanan($_POST);
}

$query = "SELECT * FROM datalauk";
$hasilmakanan = mysqli_query($koneksidb, $query);

$query = "SELECT * FROM dataminuman";
$hasilminuman = mysqli_query($koneksidb, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Menu</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #5D4037;
        }

        .header {
            background-color: #5D4037;
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-name {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .menu-section {
            padding: 10px 10px;
            background-color: #f9f5f0;
        }

        .selection-info {
            background-color: white;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 15px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            color: #757575;
        }

        .menu-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .menu-image {
            height: 180px;
            background-color: #e0e0e0;
            background-size: cover;
            background-position: center;
        }

        .menu-content {
            padding: 15px;
        }

        .menu-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .menu-description {
            font-size: 14px;
            color: #757575;
            margin-bottom: 10px;
            height: 40px;
            overflow: hidden;
        }

        .menu-price {
            font-size: 16px;
            font-weight: 600;
            color: #2e7d32;
            margin-bottom: 10px;
        }

        .select-btn {
            background-color: #2e7d32;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 15px;
            font-size: 14px;
            width: 100%;
            transition: background-color 0.3s;
        }

        .select-btn:hover, .select-btn:active {
            background-color: #1b5e20;
        }

        .select-btn.selected {
            background-color: #ff9800;
        }

        .cart-btn {
            background-color: #ff9800;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .cart-btn:hover {
            background-color: #f57c00;
        }

        @media (max-width: 576px) {
            .menu-card {
                margin-bottom: 15px;
            }
            
            .menu-image {
                height: 150px;
            }
            
            .resto-name {
                font-size: 20px;
            }
        }
        .card-section {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .konfirmasi {
            background-color: #5D4037;
            color: #FFF8E1;
            padding: 1rem 2.5rem;
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .konfirmasi:hover {
            background-color: #6D4C41;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-name">Choose Your Menu</h1>
                </div>

                <div class="col">
                    <div class="selection-info">
                        Maksimal 3 Lauk
                        <br>
                        Maksimal 1 Minuman
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="menu-section" id="menu">
        <div class="container">
            <div class="card-section">
                <form action="" method="post">
                <h2 class="text-center">Daftar Lauk</h2>
                <div class="row">
                    <?php $j=0; for($i = 0 ; $i < $jumlahorang; $i++){ ?>
                        <h2 class="text-center">Pesanan <?= $i+1; ?></h2>
                    <?php foreach($hasilmakanan as $data){ if($data["IDMenu"] == 0) continue;?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="menu-card">
                                <div class="menu-image" style="background-image: url('../img/<?= $data["GambarMenu"]; ?>');"></div>
                                <div class="menu-content">
                                    <h3 class="menu-name"><?= $data["NamaMenu"]; ?></h3>
                                    <p class="menu-description"><?= $data["Deskripsi"]; ?></p>
                                    <div class="menu-price">Rp <?= $data["HargaMenu"]; ?></div>
                                    <input type="checkbox"  class="btn-check" id="lauk<?= ++$j; ?>" name="lauk<?= $j; ?>" value="<?= $data["IDMenu"] ?>" autocomplete="off">
                                    <label class="select-btn <?= 'lauk'.$i; ?>" for="lauk<?= $j; ?>" >Pilih</label>
                                </div>
                            </div>
                        </div>
                    <?php }} ?>
                </div>
                <h2 class="text-center">Daftar Minuman</h2>
                <div class="row">
                    <?php $j=0; for($i = 0 ; $i < $jumlahorang; $i++){ ?>
                        <h2 class="text-center">Pesanan <?= $i+1; ?></h2>
                    <?php foreach($hasilminuman as $data){?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="menu-card">
                                <div class="menu-image" style="background-image: url('../img/<?= $data["Gambar"]; ?>');"></div>
                                <div class="menu-content">
                                    <h3 class="menu-name"><?= $data["NamaMinuman"]; ?></h3>
                                    <p class="menu-description"><?= $data["Deskripsi"]; ?></p>
                                    <div class="menu-price">Rp <?= $data["HargaMinuman"]; ?></div>
                                    <input type="checkbox"  class="btn-check" id="minuman<?= ++$j; ?>" name="minuman<?= $j; ?>" value="<?= $data["IDMinuman"] ?>" autocomplete="off">
                                    <label class="select-btn <?= 'minuman'.$i; ?>" for="minuman<?= $j; ?>" >Pilih</label>
                                </div>
                            </div>
                        </div>
                    <?php }} ?>
                </div>
                <input type="number" name="jumlahorang" value="<?= $jumlahorang ?>" hidden>
                <input type="number" name="idmeja" value="<?= $idmeja?>" hidden>
                <div class="mt-5 text-end">
                    <button type="submit" id="konfirmasi" class="konfirmasi" name="pesanmakanan">
                        Konfirmasi Menu
                    </button>
                </div>    
                </form>
            </div>
            
        </div>
    </section>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectionInfo = document.querySelector('.selection-info');
            const tombolkonfirmasi = document.getElementById('konfirmasi');

            let buttonlauk = [];
            let buttonminuman = [];
            let indexs = [0, 1, 2, 3];
            let selectedCountlauk = [0, 0, 0, 0];
            let selectedCountminuman = [0, 0, 0, 0];

            // indexs.forEach(index => {
            //     if(index == <?= $jumlahorang ?>){
            //         return; 
            //     }
            //     if(selectedCountlauk[index] > 0 && selectedCountminuman[index] > 0) {
            //         tombolkonfirmasi.disabled = false;
            //     }else {
            //         tombolkonfirmasi.disabled = true;
            //     }
            // })

            indexs.forEach(index => {
                if(index == <?= $jumlahorang ?>){
                    return; 
                }
                let string = ".lauk" + index;
                buttonlauk[index] = document.querySelectorAll(string);
                buttonlauk[index].forEach(button => {
                    button.addEventListener('click', function() {
                        if (this.classList.contains('selected')) {
                            // Deselect
                            this.classList.remove('selected');
                            this.textContent = 'Pilih';
                            selectedCountlauk[index]--;
                        } else {
                            // Check if we can select more
                            if (selectedCountlauk[index] < 3) {
                                this.classList.add('selected');
                                this.textContent = 'Dipilih';
                                selectedCountlauk[index]++;
                            } else {
                                alert('Maksimal hanya dapat memilih 3 lauk');
                            }
                        }
                    });
                });
            });

            indexs.forEach(index => {
                if(index == <?= $jumlahorang ?>){
                    return; 
                }
                string = ".minuman" + index;
                buttonminuman[index] = document.querySelectorAll(string);
                buttonminuman[index].forEach(button => {
                    button.addEventListener('click', function() {
                        if (this.classList.contains('selected')) {
                            // Deselect
                            this.classList.remove('selected');
                            this.textContent = 'Pilih';
                            selectedCountminuman[index]--;
                        } else {
                            // Check if we can select more
                            if (selectedCountminuman[index] < 1) {
                                this.classList.add('selected');
                                this.textContent = 'Dipilih';
                                selectedCountminuman[index]++;
                            } else {
                                alert('Maksimal hanya dapat memilih 1 minuman');
                            }
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>