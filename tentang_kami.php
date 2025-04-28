<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Eksplor Wisata</title>
    <link rel="stylesheet" href="style.css" id="paragraf 6">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">Piknik'in.Aja</div>
        <nav class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            
            <div class="dropdown">
                <button class="dropbtn">Destinasi ▼</button>
                <div class="dropdown-content">
                    <a href="kategori_pantai.php">Pantai</a>
                    <a href="kategori_gunung.php">Gunung</a>
                    <a href="kategori_airterjun.php">Air Terjun</a>
                </div>
            </div>

            <a href="#">Tentang Kami</a>
        </nav>
        <div class="search-loginn">
            <div class="search-boxx">
                <input type="text" placeholder="Search">
                <button class="search-btnn">Search</button>
            </div>
            <button class="login-btn">Login</button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="herloo">
        <h2>KENALI KAMI</h2>
        <h1>Tentang Kami</h1>
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

    <!-- About Section -->
    <section class="about">
        <h2>Kami Mengenalkan Banyak Wisata<br>Alam Yang Ada Di Jawa Timur</h2>
        <div class="about-content">
            <img src="foto/deskripsi kami.png" alt="Wisata Alam">
            <p>
                Explor Wisata gerbang Anda menuju petualangan tak terlupakan di provinsi Jawa Timur yang indah. 
                Dengan pengalaman bertahun-tahun dan hasrat untuk bepergian, kami memperkenalkan wisata yang 
                memamerkan keindahan di jawa timur yang menakjubkan, budaya yang semarak, dan sejarah yang kaya. 
                Baik menjelajahi pegunungan yang megah, danau yang tenang, atau distrik pasar yang ramai, rencana 
                perjalanan kami melayani semua minat. Dengan anda nya sistem kami, kami membuat anda lebih mudah, 
                kami bangga dengan layanan yang luar biasa dan pengalaman unik mengenang abadi. Temukan petualangan anda!
            </p>
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
