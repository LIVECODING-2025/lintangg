<?php
session_start();
require 'function.php';

if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'user') {
    header("Location: login.php");
    exit;
}

$wisata = query("SELECT * FROM data_wisataa WHERE kategori = 'Pantai'");

if (isset($_POST["cari_dashboard"])) {
    $wisata = cari_dashboard($_POST["keyword"]);
}

//ulasan 
$pesan = ""; // variabel untuk menyimpan notifikasi

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['simpan'])) {
    $kritik = htmlspecialchars($_POST['kritik']);
    $saran = htmlspecialchars($_POST['saran']);

    $query = "INSERT INTO data_ulasan (kritik, saran) VALUES (?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $kritik, $saran);

    if ($stmt->execute()) {
        $pesan = "Komentar berhasil dikirim!";
    } else {
        $pesan = "Gagal menyimpan komentar: " . $stmt->error;
    }

    $stmt->close();
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css user/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>Dashboard Piknik'in.Aja</title>
</head>
<body>
  <nav>
    <div class="logo">Piknik’In.Aja</div>

    <input type="checkbox" id="toggle-menu">
    <label for="toggle-menu" class="hamburger">
      <div></div>
      <div></div>
      <div></div>
    </label>

    <div class="nav-links">
      <a href="dashboard.php" style="font-weight: bold;">Dashboard</a>

      <!-- Dropdown Destinasi -->
      <div class="dropdown">
        <label for="drop-destinasi">Destinasi</label>
        <input type="checkbox" id="drop-destinasi">
        <div class="dropdown-content">
          <a href="kategori_pantai.php">Pantai</a>
          <a href="kategori_gunung.php">Gunung</a>
          <a href="kategori_airterjun.php">AirTerjun</a>
        </div>
      </div>

      <a href="tentang_kami.php">Tentang Kami</a>
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

    <!-- Ganti tombol logout dengan dropdown profil -->
    <div class="profile-dropdown">
        <img src="foto/profile real.png" class="profile-img-nav" alt="Profile">
        <div class="dropdown-content">
            <a href="form_edit_profile.php">Profil Saya</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

  </nav>

  <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <p class="subtitle">Explore Jatim</p>
            <h1>Nikmatilah Alam Yang Indah Dan Romantis</h1>
            <button class="explore-btn">
                <a href="#kategori" style="color: #013220; text-decoration: none;">Lebih Lanjut</a>
            </button>
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

    <!-- Explore Section -->
<section class="explore-section">
  <div class="explore-container">
    <div class="explore-text">
      <h2>EXPLORE WISATA JATIM</h2>
      <p>
        Kami Mengenalkan wisata yang unik dan berkesan, menyediakan pengalaman yang kaya di Jawa Timur yang indah.
        Dengan berkomitmen untuk menghadirkan perjalanan yang luar biasa, aman, dan mengasyikkan, membantu Anda
        menjelajahi keindahan wisata di Jawa Timur.
      </p>
    </div>
    <div class="explore-images">
      <img src="foto/explore wisata 2.jpeg" alt="Pantai">
      <img src="foto/explore wisata 1.jpeg" alt="Gunung">
      <img src="foto/explore wisata 3.jpeg" alt="Gunung Berapi">
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
                <a href="kategori_pantai.php" class="btn-detail">Detail</a>
            </div>
        </div>
        <div class="card">
            <img src="foto/kategori air terjun baru.jpeg" alt="Wisata Air Terjun">
            <div class="card-text"> 
                <h3>Wisata Air Terjun</h3>
                <a href="kategori_airterjun.php" class="btn-detail">Detail</a>
            </div>
        </div>
        <div class="card">
            <img src="foto/kategori gunung baru.jpeg" alt="Wisata Gunung">
            <div class="card-text">
                <h3>Wisata Gunung</h3>
                <a href="kategori_gunung.php" class="btn-detail">Detail</a>
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
        <div class="top-listt">
        <?php foreach( $wisata as $row) : ?>
            <div class="kategori-itemm">
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
                <form action="#" method="POST">
                    <input type="text" name="kritik" placeholder="Kritik'an Anda" required>
                    <input type="text" name="saran" placeholder="Saran Anda" required>
                    <button type="submit" name="simpan">Simpan</button>
                </form>
                <?php if (!empty($pesan)): ?>
                    <script>
                        alert("<?= $pesan ?>");
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </footer>
</body>
</html>
