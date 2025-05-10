<?php
include ("function.php");

$wisata = query("SELECT * FROM data_wisataa WHERE kategori = 'Pantai'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style2.css" id="paragraf 3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">Piknik'in.Aja</div>
        <nav class="nav-links">
            <a href="#">Dashboard</a>
            
            <div class="dropdown">
                <button class="dropbtn">Destinasi ▼</button>
                <div class="dropdown-content">
                    <a href="login.php">Pantai</a>
                    <a href="login.php">Gunung</a>
                    <a href="login.php">Air Terjun</a>
                </div>
            </div>

            <a href="login.php">Tentang Kami</a>
        </nav>
        <div class="search-loginn">
            <div class="search-boxxx">
                <input type="text" placeholder="Search">
                <button class="search-btnnn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button class="login-btnn">Login</button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
    <div class="hero-content">
            <p class="subtitle">Explore Jatim</p>
            <h1>Nikmatilah Alam Yang Indah<br>Dan Romantis</h1>
            <button class="explore-btn">Lebih Lanjut</button>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stat-item">
            <h2>+100</h2>
            <p>Tur Menarik<br>Di Jawa Timur</p>
        </div>
        <div class="stat-item">
            <h2>+50</h2>
            <p>Klien dari<br>seluruh dunia</p>
        </div>
        <div class="stat-item">
            <h2>+120</h2>
            <span>⭐⭐⭐⭐⭐</span>
            <p>Trip Memuaskan</p>
        </div>
    </section>

    <!-- Explore Selection -->
    <section class="explore-section">
        <div class="explore-container">
            <div class="explore-images">
                <img src="foto/gambar 2.png" alt="Pantai">
                <img src="foto/GUNUNG BROMO 1.png" alt="Gunung">
                <img src="foto/gambar 3.png" alt="Gunung Berapi">
            </div>
            <div class="explore-text">
            <h2>EXPLORE WISATA JATIM</h2>
            <p>
                Kami Mengenalkan wisata yang unik dan berkesan, menyediakan pengalaman yang kaya di Jawa Timur yang indah.
                Dengan berkomitmen untuk menghadirkan perjalanan yang luar biasa, aman, dan mengasyikkan, membantu Anda
                menjelajahi keindahan wisata di Jawa Timur.
            </p>
            </div>
        </div>
    </section>

    <!-- Kategori Wisata -->
    <section class="kategori-wisata">
        <h2>Kategori Wisata</h2>
        <div class="card-container">
            <div class="card">
            <img src="foto/kategori pantai.png" alt="Wisata Pantai">
            <div class="card-text">
                <h3>Wisata Pantai</h3>
                <a href="login.php" class="btn-detail">Detail</a>
            </div>
        </div>
        <div class="card">
            <img src="foto/kategori air terjun.png" alt="Wisata Air Terjun">
            <div class="card-text">
                <h3>Wisata Air Terjun</h3>
                <a href="login.php" class="btn-detail">Detail</a>
            </div>
        </div>
        <div class="card">
            <img src="foto/kategori gunung.png" alt="Wisata Gunung">
            <div class="card-text">
                <h3>Wisata Gunung</h3>
                <a href="login.php" class="btn-detail">Detail</a>
            </div>
        </div>
        </div>
    </section>

    <!-- Wisata Jatim -->
    <section class="wisata-jatim">
        <div class="container-wisata">
            <div class="wisata-text">
                <h2>Wisata Jawa Timur</h2>
                <p>
                    Kami Mengenalkan wisata yang unik dan berkesan, menyediakan pengalaman yang kaya di Jawa Timur yang indah.
                    Dengan berkomitmen untuk menghadirkan perjalanan yang luar biasa, aman, dan mengasyikkan, membantu Anda
                    menjelajahi keindahan wisata di Jawa Timur.
                </p>
            </div>
            <div class="wisata-images">
                <img src="foto/gambar 1.png" alt="Gunung">
                <img src="foto/gambar 2 (1).png" alt="Pantai">
                <img src="foto/gambar 3 (1).png" alt="Air Terjun">
            </div>
        </div>
    </section>

    <!-- Top Destination Section -->
    <section class="top-destination">
        <h2>Top Destination</h2>
        <div class="top-list">
        <?php foreach( $wisata as $row) : ?>
            <div class="kategori-item">
                <img src="foto/<?php echo $row["gambar"]; ?>" alt="">
                <h3><?php echo $row ["nama_wisata"]; ?></h3>
                <h5><?php echo $row ["lokasi"]; ?></h5>
                <p>Htm. <?php echo number_format($row["harga"], 0, ',', '.'); ?></p>
                <button>
                    <a href="login.php?id=<?= $row["id"]; ?>">Detail</a>
                </button>
            </div>
        <?php endforeach; ?>  
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Explore</h3>
                <p>Kami mengenalkan wisata unik dan berkesan, memberikan pengalaman yang kaya di provinsi jawa timur yang indah.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Contact Info</h3>
                <p>No 53, JL. Mawar Raya,<br>Kab. Bandung</p>
                <p><i class="fas fa-phone"></i> 0895-2518-0744</p>
                <p><i class="fas fa-envelope"></i> <a href="mailto:ExploreJatim@gmail.com">ExploreJatim@gmail.com</a></p>
            </div>

            <div class="footer-section">
                <h3>Ulasan Anda</h3>
                <form action="#">
                    <input type="text" placeholder="Kritik'an Anda" required>
                    <input type="text" placeholder="Saran Anda" required>
                    <button type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </footer>

</body>
</html>