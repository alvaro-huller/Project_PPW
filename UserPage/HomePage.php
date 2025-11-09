<?php 

include "function.php";

if($_SESSION["Role"] != "Pelanggan" && $_SESSION["Role"] != "Admin") {
    echo "
            <script>
                alert('Anda Tidak Memiliki Akses');
                document.location.href = '../Index.php';
            </script>
        ";
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #5D4037;
            --primary-light: #FFF8E1;
            --accent-color: #8D6E63;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-dark);
        }
        
        .navbar {
            background-color: var(--primary-dark);
            height: 72px;
        }
        
        .navbar-brand {
            color: var(--primary-light) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .nav-link {
            color: var(--primary-light) !important;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: #FFD54F !important;
        }
        
        .btn-primary {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border: none;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #FFD54F;
            color: var(--primary-dark);
        }
        
        .hero-section {
            background-color: var(--primary-dark);
            color: var(--primary-light);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(93, 64, 55, 0.8), rgba(93, 64, 55, 0.9)), 
                        url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }
        
        .section-title {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 3px;
            background-color: var(--accent-color);
        }
        
        .menu-section {
            padding: 80px 0;
            background-color: #f9f5f0;
        }
        
        .menu-item {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 30px;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
        }
        
        .menu-item-img {
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        
        .menu-item-content {
            padding: 20px;
        }
        
        .menu-item-title {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }
        
        .menu-item-price {
            color: var(--accent-color);
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .about-section {
            padding: 80px 0;
            background-color: white;
        }
        
        .contact-section {
            padding: 80px 0;
            background-color: var(--primary-dark);
            color: var(--primary-light);
        }
        
        .contact-section .section-title {
            color: var(--primary-light);
        }
        
        .contact-section .section-title::after {
            background-color: var(--primary-light);
        }
        
        .footer {
            background-color: #2c1e17;
            color: var(--primary-light);
            padding: 40px 0;
        }
        
        .footer a {
            color: var(--primary-light);
            text-decoration: none;
        }
        
        .footer a:hover {
            color: #FFD54F;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
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
                        <a class="nav-link" href="#menu">Dafta Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary" href="Reservasi.php">Reservasi</a>
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
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Restaurant Interior" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="menu-section" id="menu">
        <div class="container">
            <h2 class="section-title text-center">Daftar Menu</h2>
            <div class="row">
                <!-- Menu Item 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="menu-item">
                        <div class="menu-item-img" style="background-image: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80');"></div>
                        <div class="menu-item-content">
                            <h4 class="menu-item-title">Gudeg</h4>
                            <p>Traditional Javanese dish made from young unripe jack fruit stewed for several hours with palm sugar and coconut milk.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="menu-item-price">$12.99</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="menu-item">
                        <div class="menu-item-img" style="background-image: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1981&q=80');"></div>
                        <div class="menu-item-content">
                            <h4 class="menu-item-title">Sate Ayam</h4>
                            <p>Chicken satay with peanut sauce, served with rice cakes and sweet soy sauce.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="menu-item-price">$10.99</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="menu-item">
                        <div class="menu-item-img" style="background-image: url('https://images.unsplash.com/photo-1563379926898-05f4575a45d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');"></div>
                        <div class="menu-item-content">
                            <h4 class="menu-item-title">Rawon</h4>
                            <p>Traditional beef soup from East Java, using keluak as the main seasoning.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="menu-item-price">$14.99</span>
                            </div>
                        </div>
                    </div>
                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>