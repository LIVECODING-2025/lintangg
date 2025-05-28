<?php
include ("function.php");

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
    <title>Profile Piknik'in.Aja</title>
    <link rel="stylesheet" href="css user/style7.css" id="paragraf 7">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
  @media (max-width: 768px) {
      nav {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin: 0 20px;
        padding: 10px;
      }

      .logo {
        order: 1;
      }

      .hamburger {
        display: flex;
        order: 2;
      }

      .nav-links {
        display: none;
        width: 100%;
        flex-direction: column;
        gap: 30px;
        order: 3;
        padding: 10px 0;
        margin-top: 10px;
      }

      .search-login {
        display: none;
        width: 100%;
        flex-direction: row;
        align-items: center;
        gap: 10px;
        order: 4;
        padding: 10px 0;
      }

      #toggle-menu:checked ~ .nav-links,
      #toggle-menu:checked ~ .search-login {
        display: flex;
      }

      .search-box {
        flex-grow: 1;
      }

      .search-box input {
        width: 100%;
      }

      .profile-dropdown {
        position: relative;
        margin-top: 0;
        align-self: center;
      }

      .profile-dropdown .dropdown-content {
        position: absolute;
        right: 0;
        top: 40px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      }

      .dropdown-content {
        position: absolute;
        box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
      }
    }
</style>
<body>
<nav>
  <div class="logo">Piknik'In.Aja</div>

  <input type="checkbox" id="toggle-menu">
  <label for="toggle-menu" class="hamburger">
    <div></div>
    <div></div>
    <div></div>
  </label>

  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <div class="dropdown" id="destinasi-dropdown">
      <label onclick="toggleDestinasiDropdown(event)">Destinasi</label>
      <div class="dropdown-content" id="destinasi-menu">
        <a href="kategori_pantai.php">Pantai</a>
        <a href="kategori_gunung.php">Gunung</a>
        <a href="kategori_airterjun.php">AirTerjun</a>
      </div>
    </div>
    <a href="tentang_kami.php" style="font-weight: bold;">Tentang Kami</a>
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
        <a href="profile.php">Profil Saya</a>
        <a href="logout.php" onclick="return confirmLogout(event)">Logout</a>
      </div>
    </div>

    <script>
      function confirmLogout(event) {
        const confirmation = confirm("Apakah Anda yakin ingin logout?");
        if (!confirmation) {
          event.preventDefault(); // Batalkan logout jika user klik Cancel
          return false;
        }
        // Jika user klik OK, link tetap berjalan ke logout.php
        return true;
      }
    </script>
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
    <section class="herlooooo" style="height: 80vh;">
        <h2 style="margin-top: 180px;">KENALI KAMI</h2>
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
            <img src="foto/foto tentang kami.jpeg" alt="Wisata Alam">
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
