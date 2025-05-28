<?php 
include ("function.php");

$wisata = query("SELECT * FROM data_wisataa WHERE kategori = 'AirTerjun'");

if (isset($_POST["cari_kategori_airterjun"])) {
    $wisata = cari_kategori_airterjun($_POST["keyword"]);
}

if (isset($_POST["cari_kategori_airterjun_lokasi"])) {
    $keyword = $_POST["keyword"];
    $kategori = $_POST["kategori"]; // contoh: 'AirTerjun'
    $wisata = cari_kategori_airterjun_lokasi($keyword, $kategori);
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Destinasi Piknik'in.Aja</title>
  <link rel="stylesheet" href="css user/style6.css" id="paragraf 6"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</head>
<style>
  .heroooo{
    background: url('foto/bg kategori air terjun.jpeg') no-repeat center/cover;
  }

  /* responsif */
@media (max-width: 768px) {
  .top-destination,
  .kategori {
    padding: 20px;
  }

  .heroooo {
    height: 50px;
  }

  .top-destination,
  .h2 {
    font-size: 13px;
  }

  .kategori-list,
  .top-list {
    flex-direction: column;
    gap: 20px;
    padding: 0;
    align-items: center;
  }

  .kategori-item {
    width: 100%;
    max-width: 300px;
  }

  .kategori-item button {
    width: 90%;
    padding: 10px;
    font-size: 16px;
  }
}
</style>
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
    <a href="dashboard.php">Dashboard</a>
    <div class="dropdown" id="destinasi-dropdown">
      <label onclick="toggleDestinasiDropdown(event)" style="font-weight: bold;">Destinasi</label>
      <div class="dropdown-content" id="destinasi-menu">
        <a href="kategori_pantai.php">Pantai</a>
        <a href="kategori_gunung.php">Gunung</a>
        <a href="kategori_airterjun.php" style="font-weight: bold;">AirTerjun</a>
      </div>
    </div>
    <a href="tentang_kami.php">Tentang Kami</a>
  </div>

  <div class="search-login">
    <div class="search-box">
      <form action="" method="POST">
        <input type="text" placeholder="Search" name="keyword">
        <button name="cari_kategori_airterjun" class="search-icon">
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
  <section class="heroooo" style="height: 80vh;">
    <h2 style="margin-top: 180px;">EXPLORE JATIM</h2>
    <h1>Destinasi</h1>
  </section>

  <!-- Search Bar -->
  <form action="" method="POST">
    <section class="search-bar">
      <i class="fas fa-map-marker-alt"></i>
      <input
        type="text"
        placeholder="kemana kamu pergi?"
        name="keyword"
        required
      />
      <input type="hidden" name="kategori" value="AirTerjun" />
      <button class="search-btnn" name="cari_kategori_airterjun_lokasi">
        Search
      </button>
      <div class="dropdownn">
        <button class="dropbtnn">All Categories</button>
        <div class="dropdown-contentt">
          <a href="kategori_pantai.php" data-category="pantai">Pantai</a>
          <a href="kategori_gunung.php" data-category="gunung">Gunung</a>
          <a href="#" data-category="air-terjun">Air Terjun</a>
        </div>
      </div>
    </section>
  </form>

  <!-- Destinasi -->
  <section class="top-destination">
    <h2>Destinasi Explore Jawa Timur</h2>
    <div class="top-list">
      <?php foreach ($wisata as $row) : ?>
        <div class="kategori-item">
          <img src="foto/<?php echo $row["gambar"]; ?>" alt="" />
          <h3><?php echo $row["nama_wisata"]; ?></h3>
          <h4><?php echo $row["lokasi"]; ?></h4>
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
        <p>
          Kami mengenalkan wisata unik dan berkesan, memberikan pengalaman
          yang kaya di provinsi jawa timur yang indah.
        </p>
        <div class="social-icons">
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-facebook-f"></i></a>
        </div>
      </div>

      <div class="footer-section">
        <h3>Contact Info</h3>
        <p>No 53, JL. Mawar Raya,<br />Kab. Bandung</p>
        <p><i class="fas fa-phone"></i> 0895-2518-0744</p>
        <p>
          <i class="fas fa-envelope"></i>
          <a href="mailto:ExploreJatim@gmail.com">ExploreJatim@gmail.com</a>
        </p>
      </div>

      <div class="footer-section">
        <h3>Ulasan Anda</h3>
        <form action="#" method="POST">
          <input type="text" name="kritik" placeholder="Kritik'an Anda" required />
          <input type="text" name="saran" placeholder="Saran Anda" required />
          <button type="submit" name="simpan">Simpan</button>
        </form>
        <?php if (!empty($pesan)) : ?>
          <script>
            alert("<?= $pesan ?>");
          </script>
        <?php endif; ?>
      </div>
    </div>
  </footer>
</body>
</html>

