<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Gunung Argopuro</title>
    <link rel="stylesheet" href="style.css" id="paragraf 5">
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

<!-- Header Hero -->
    <section class="herlo">
        <div class="overlay">
            <div class="herlo-content">
                <p class="harga">Harga <strong>Rp. 30.000</strong></p>
                <h1 class="judul">Explore Gunung Argopuro</h1>
                <p class="lokasi">
                    <i class="fas fa-map-marker-alt"></i>
                    perbatasan Probolinggo, Situbondo, Jember, dan Bondowoso.
                </p>
            </div>
        </div>
    </section>

<!-- Tentang -->
<section class="info-section">
  <div class="container">
    <div class="tentang">
      <h2>Tentang</h2>
      <hr class="divider">
      <div class="sorotan">
        <h3>Sorotan</h3>
        <ul>
          <li>✅ Pemandangan Pegunungan yang Memukau</li>
          <li>✅ Pemandangan menakjubkan di danau'nya</li>
          <li>✅ Taman Tepi Danau yang Tenang: Bersantailah dan nikmati pemandangan danau yang damai.</li>
        </ul>
        <p>
          Lokasi Bersejarah: Jelajahi kekayaan sejarah situs Argopuro. 
          Aktivitas Petualangan: Kesenangan luar ruangan yang mendebarkan di lingkungan yang indah.
        </p>
      </div>
    </div>
  </div>
</section>

<section class="foto-section">
  <div class="container">
    <div class="foto">
      <h2>Foto</h2>
      <hr class="divider">
      <div class="foto-masonry">
        <img src="foto/Argopuro 1.png" alt="Foto 1">
        <img src="foto/Argopuro 2.png" alt="Foto 2">
        <img src="foto/Argopuro 3.png" alt="Foto 3">
        <img src="foto/Argopuro 4.png" alt="Foto 4">
        <img src="foto/Argopuro 5.png" alt="Foto 5">
        <img src="foto/Argopuro 7.png" alt="Foto 7">
        <img src="foto/Argopuro 6.png" alt="foto 6">
      </div>
    </div>
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
