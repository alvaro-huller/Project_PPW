<?php 

include "function.php";

$query = "SELECT * FROM datamenu";
$hasil = mysqli_query($koneksidb, $query);

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
    <!-- <link rel="stylesheet" href="../style/style.css"> -->
    <link rel="stylesheet" href="../style/PesanMenu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
                        Lauk terpilin: 0/3
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="menu-section" id="menu">
        <div class="container">

            <h2 class="text-center">Daftar Menu</h2>
            
            <div class="row">
                <?php while($data = mysqli_fetch_assoc($hasil)){ ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="menu-card">
                            <div class="menu-image" style="background-image: url('../img/<?= $data["GambarMenu"]; ?>');"></div>
                            <div class="menu-content">
                                <h3 class="menu-name"><?= $data["NamaMenu"]; ?></h3>
                                <p class="menu-description"><?= $data["Deskripsi"]; ?></p>
                                <div class="menu-price">Rp <?= $data["HargaMenu"]; ?></div>
                                <button class="select-btn">Pilih</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectButtons = document.querySelectorAll('.select-btn');
            const selectionInfo = document.querySelector('.selection-info');
            
            let selectedCount = 0;
            const maxSelection = 3;
            
            selectButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (this.classList.contains('selected')) {
                        // Deselect
                        this.classList.remove('selected');
                        this.textContent = 'Pilih';
                        selectedCount--;
                    } else {
                        // Check if we can select more
                        if (selectedCount < maxSelection) {
                            this.classList.add('selected');
                            this.textContent = 'Dipilih';
                            selectedCount++;
                        } else {
                            alert('Maksimal hanya dapat memilih ' + maxSelection + ' lauk');
                        }
                    }
                    
                    // Update selection info and cart button
                    selectionInfo.innerHTML = `Maksimal ${maxSelection} Lauk<br>\nLauk terpilin: ${selectedCount}/${maxSelection}`;
                });
            });
        });
    </script>
</body>
</html>