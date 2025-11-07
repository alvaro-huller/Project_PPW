<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Restoran</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/AdminPage.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                Resto Jawa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-menu-button me-2"></i>
                            Kelola Data Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-graph-up me-2"></i>
                            Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <h1>Dashboard</h1>
                <p class="lead">Selamat datang di dashboard admin restoran</p>
                <hr class="my-4">
                
                <h2 class="mt-5">Pesanan Terkini</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Meja</th>
                                <th>Menu</th>
                                <th>Waktu</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-1234</td>
                                <td>Meja 5</td>
                                <td>Nasi Gudeg, Es Teh, Ayam Goreng</td>
                                <td><i class="bi bi-clock"></i> 5 menit lalu</td>
                                <td>Rp 125.000</td>
                                <td><span class="badge status-neruongo">Neruongo</span></td>
                            </tr>
                            <tr>
                                <td>#ORD-1233</td>
                                <td>Meja 12</td>
                                <td>Soto Ayam, Nasi Putih, Es Jeruk</td>
                                <td><i class="bi bi-clock"></i> 12 menit lalu</td>
                                <td>Rp 85.000</td>
                                <td><span class="badge status-neruongo">Neruongo</span></td>
                            </tr>
                            <tr>
                                <td>#ORD-1232</td>
                                <td>Meja 3</td>
                                <td>Rawon, Tempe Goreng, Teh Hangat</td>
                                <td><i class="bi bi-clock"></i> 18 menit lalu</td>
                                <td>Rp 95.000</td>
                                <td><span class="badge status-dproser">Dproser</span></td>
                            </tr>
                            <tr>
                                <td>#ORD-1231</td>
                                <td>Meja 8</td>
                                <td>Pecel Lele, Nasi Putih, Es Kelapa</td>
                                <td><i class="bi bi-clock"></i> 25 menit lalu</td>
                                <td>Rp 110.000</td>
                                <td><span class="badge status-dproser">Dproser</span></td>
                            </tr>
                            <tr>
                                <td>#ORD-1230</td>
                                <td>Meja 15</td>
                                <td>Gado-gado, Lontong, Es Teh Manis</td>
                                <td><i class="bi bi-clock"></i> 32 menit lalu</td>
                                <td>Rp 75.000</td>
                                <td><span class="badge status-siap">Siap</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>