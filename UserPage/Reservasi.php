<?php 

include "function.php";

$query = "SELECT * FROM datameja";
$hasil = mysqli_query($koneksidb, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Reservation</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .card-section {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .card {
            border: 2px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
            height: 100%;
        }

        .card:hover {
            border-color: #4CAF50;
        }

        .availability-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .dot {
            background-color: #4CAF50;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .dot.selected {
            background-color: gray;
        }

        .tersedia {
            color: #4CAF50;
        }

        .tersedia.selected {
            color: gray;
        }

        .booking {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: none;
            margin-bottom: 0.5rem;
            background-color: #4CAF50;
            color: white;
        }

        .booking.selected {
            background-color: gray;
        }

        .booking:hover {
            background-color: #387c3aff;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
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
                <div class="row">
                    <h1 class="page-name">Reservasi Meja</h1>
                </div>
                <div class="row">
                    <p>Masukkan jumlah orang yang akan datang dan pilih meja yang tersedia</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="min-vh-100 bg-light">
        <div class="container px-4 py-5">
            <form action="PesanMenu.php" method="post">
            <div class="card-section">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="h3 mb-4 reservation-header">Jumlah Orang</h2>
                        <select class="form-select form-select-lg" name="jumlahorang" required>
                            <option value="" selected disabled>Pilih jumlah orang</option>
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="3">3 Orang</option>
                            <option value="4">4 Orang</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-section">
                <h2 class="h3 mb-5 reservation-header">Ketersediaan Meja</h2>

                <div class="row g-4" id="tablesContainer">
                    <?php while($data = mysqli_fetch_assoc($hasil)) { if($data["Status"] == "Kosong"){?>
                    <div class="card col-12 col-sm-6 col-lg-3">
                        <div class="availability-indicator">
                            <span class="dot"></span>
                            <span class="tersedia small">Tersedia</span>
                        </div>  

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="idmeja h5 reservation-header mb-0" value="<?= $data["IDMeja"] ?>">Meja No  <?= $data["NoMeja"]; ?></h3>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="jam" value="<?= $data["Jam"] ?>">
                                <?= $data["Jam"]; ?>
                            </span>
                        </div>

                        <button type="button" class="booking">
                            Booking
                        </button>
                        
                    </div>
                    <?php } } ?> 
                </div>
                    <div class="mt-5 text-end">
                        <button type="submit" id="konfirmasi" class="konfirmasi" name="reservasi" disabled>
                            Konfirmasi Reservasi
                        </button>
                    </div>
            </div>
            <input type="text" id="jaminput" name="jam" hidden required>
            <input type="text" id="idmejainput" name="idmeja" hidden required>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tombolbooking = document.querySelectorAll('.booking');
            const dot = document.querySelectorAll('.dot');
            const status = document.querySelectorAll('.tersedia');
            const konfirmasi = document.getElementById('konfirmasi');
            const jam = document.querySelectorAll('.jam');
            const idmeja = document.querySelectorAll('.idmeja');
            const jaminput = document.getElementById('jaminput');
            const idmejainput = document.getElementById('idmejainput');
            
            let selectedCount = 0;
            const maxSelection = 1;
            
            tombolbooking.forEach((button, index) => {
                button.addEventListener('click', function() {
                    const dotselected = dot[index];
                    const statusselected = status[index];
                    const jamselected = jam[index];
                    const idmejaselected = idmeja[index];
                    if (this.classList.contains('selected')) {
                        // Deselect
                        this.classList.remove('selected');
                        dotselected.classList.remove('selected');
                        statusselected.classList.remove('selected');
                        konfirmasi.disabled = true;
                        jaminput.removeAttribute('value');
                        idmejainput.removeAttribute('value');
                        selectedCount--;
                    } else {
                        // Check if we can select more
                        if (selectedCount < maxSelection) {
                            this.classList.add('selected');
                            dotselected.classList.add('selected');
                            statusselected.classList.add('selected');
                            statusselected.textContent = 'Dipilih';
                            const datajam = jamselected.getAttribute('value')
                            const dataidmeja = idmejaselected.getAttribute('value')
                            jaminput.setAttribute('value', datajam)
                            idmejainput.setAttribute('value', dataidmeja)
                            konfirmasi.disabled = false;
                            selectedCount++;
                        } else {
                            alert('Maksimal hanya dapat memilih ' + maxSelection + ' nomor meja');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>