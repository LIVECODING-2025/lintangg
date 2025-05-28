<?php
include ("function.php");

$wisata = query("SELECT * FROM data_wisataa WHERE kategori = 'Pantai'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Screen Piknik'in.Aja</title>
    <link rel="stylesheet" href="css user/style.css" id="paragraf 3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
</head>
<body>
   <!-- Navbar -->
  <nav>
  <div class="logo">Piknik'In.Aja</div>

  <input type="checkbox" id="toggle-menu">
  <label for="toggle-menu" class="hamburger">
    <div></div>
    <div></div>
    <div></div>
  </label>

  <div class="nav-links">
    <a href="dashboard.php" style="font-weight: bold;">Dashboard</a>
    <div class="dropdown" id="destinasi-dropdown">
      <label onclick="toggleDestinasiDropdown(event)">Destinasi</label>
      <div class="dropdown-content" id="destinasi-menu">
        <a href="login.php">Pantai</a>
        <a href="login.php">Gunung</a>
        <a href="login.php">AirTerjun</a>
      </div>
    </div>
    <a href="login.php">Tentang Kami</a>
  </div>

  <div class="search-login">
    <div class="search-box">
      <form action="" method="POST">
        <input type="text" placeholder="Search" name="keyword">
        <button name="cari_dashboard" class="search-icon">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
    <div class="profile-dropdown" id="profile-dropdown">
      <img src="foto/profile user.png" class="profile-img-nav" alt="Profile" onclick="toggleProfileDropdown(event)">
      <div class="dropdown-content" id="profile-menu">
        <a href="login.php">Login</a>
      </div>
    </div>
  </div>
</nav>
<script>
  function toggleProfileDropdown(event) {
    event.stopPropagation();
    const menu = document.getElementById("profile-menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
  }

  function toggleDestinasiDropdown(event) {
    event.stopPropagation();
    const menu = document.getElementById("destinasi-menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
  }

  // Tutup dropdown jika klik di luar
  document.addEventListener("click", function(event) {
    const profile = document.getElementById("profile-dropdown");
    const profileMenu = document.getElementById("profile-menu");
    const destinasi = document.getElementById("destinasi-dropdown");
    const destinasiMenu = document.getElementById("destinasi-menu");

    if (!profile.contains(event.target)) {
      profileMenu.style.display = "none";
    }
    if (!destinasi.contains(event.target)) {
      destinasiMenu.style.display = "none";
    }
  });
</script>

    <!-- Hero Section -->
    <section class="hero">
    <div class="hero-content">
            <p class="subtitle">Explore Jatim</p>
            <h1>Nikmatilah Alam Yang Indah<br>Dan Romantis</h1>
            <button class="explore-btn"><a href="#kategori" style="text-decoration: none; color: #092e23;">Lebih Lanjut</a></button>
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
                <img src="foto/explore wisata 2.jpeg" alt="Pantai">
                <img src="foto/explore wisata 1.jpeg" alt="Gunung">
                <img src="foto/explore wisata 3.jpeg" alt="Gunung">
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
    <section class="kategori-wisata" id="kategori">
        <h2>Kategori Wisata</h2>
        <div class="card-container" style="gap: 70px;">
            <div class="card">
            <img src="foto/kategori pntai baru.jpeg" alt="Wisata Pantai">
            <div class="card-text">
                <h3>Wisata Pantai</h3>
                <a href="login.php" class="btn-detail">Detail</a>
            </div>
        </div>
        <div class="card">
            <img src="foto/kategori air terjun baru.jpeg" alt="Wisata Air Terjun">
            <div class="card-text"> 
                <h3>Wisata Air Terjun</h3>
                <a href="login.php" class="btn-detail">Detail</a>
            </div>
        </div>
        <div class="card">
            <img src="foto/kategori gunung baru.jpeg" alt="Wisata Gunung">
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
                <img src="foto/wisata jawa timur 1.jpeg" alt="Gunung">
                <img src="foto/wisata jawa timur 2.jpeg" alt="Pantai">
                <img src="foto/wisata jawa timur 3.jpeg" alt="Air Terjun">
            </div>
        </div>
    </section>

    <!-- Top Destination Section -->
    <section class="top-destinationn">
        <h2>Top Destination</h2>
        <div class="top-listt" style="gap: 140px;">
        <?php foreach( $wisata as $row) : ?>
            <div class="kategori-itemm" style="max-width: 270px;">
                <img src="foto/<?php echo $row["gambar"]; ?>" alt="">
                <h3><?php echo $row ["nama_wisata"]; ?></h3>
                <h4><?php echo $row ["lokasi"]; ?></h4>
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