<?php 
include ("function.php");

$wisata = query("SELECT * FROM data_wisata WHERE kategori = 'Pantai'");

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Explore Jatim - Destinasi</title>
  <link rel="stylesheet" href="style2.css" id="paragraf 4">
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
                    <a href="#">Pantai</a>
                    <a href="kategori_gunung.php">Gunung</a>
                    <a href="kategori_airterjun.php">Air Terjun</a>
                </div>
            </div>

            <a href="tentang_kami.php">Tentang Kami</a>
        </nav>
        <div class="search-loginn">
            <div class="search-boxxx">
                <input type="text" placeholder="Search">
                <button class="search-btnnn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button class="login-btnn">Logout</button>
        </div>
    </header>

<!-- Hero Section -->
    <section class="heroo">
        <h2>EXPLORE JATIM</h2>
        <h1>Destinasi</h1>
    </section>

<!-- Search Bar -->
    <section class="search-bar">
        <i class="fas fa-map-marker-alt"></i>
        <input type="text" placeholder="kemana kamu pergi?">
        <button class="search-btn">Search</button>
        <div class="dropdownn">
            <button class="dropbtnn">All Categories</button>
            <div class="dropdown-contentt">
                <a href="#" data-category="pantai">Pantai</a>
                <a href="kategori_gunung.php" data-category="gunung">Gunung</a>
                <a href="kategori_airterjun.php" data-category="air-terjun">Air Terjun</a>
            </div>
        </div>
    </section>

<!-- Destinasi -->
    <section class="top-destination">
        <h2>Destinasi Explore Jawa Timur</h2>
        <div class="top-list">
        <?php foreach( $wisata as $row) : ?>
            <div class="kategori-item">
                <img src="foto/<?php echo $row["gambar"]; ?>" alt="">
                <h3><?php echo $row ["nama_wisata"]; ?></h3>
                <h4><?php echo $row ["lokasi"]; ?></h4>
                <p>Htm. <?php echo number_format($row["harga"], 0, ',', '.'); ?></p>
                <button>
                    <a href="deskripsi_destinasi.php?id=<?= $row["id"]; ?>">Detail</a>
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
