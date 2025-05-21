<?php 
include ("function.php");

$wisata = query("SELECT * FROM data_wisataa WHERE kategori = 'Gunung'");

if (isset($_POST["cari_kategori_gunung"])) {
    $wisata = cari_kategori_gunung($_POST["keyword"]);
}

if (isset($_POST["cari_kategori_gunung_lokasi"])) {
    $keyword = $_POST["keyword"];
    $kategori = $_POST["kategori"]; // contoh: 'gunung'
    $wisata = cari_kategori_gunung_lokasi($keyword, $kategori);
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Destinasi Piknik'in.Aja</title>
  <link rel="stylesheet" href="style6.css" id="paragraf 5">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
    .herooo{
        background: url('foto/bg kategori gunung.jpeg') no-repeat center/cover;
    }
</style>
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
      <a href="dashboard.php">Dashboard</a>

      <!-- Dropdown Destinasi -->
      <div class="dropdown">
        <label for="drop-destinasi" style="font-weight: bold;">Destinasi</label>
        <input type="checkbox" id="drop-destinasi">
        <div class="dropdown-content">
          <a href="kategori_pantai.php">Pantai</a>
          <a href="kategori_gunung.php" style="font-weight: bold;">Gunung</a>
          <a href="kategori_airterjun.php">AirTerjun</a>
        </div>
      </div>

      <a href="tentang_kami.php">Tentang Kami</a>
    </div>

    <div class="search-login">
        <div class="search-box">
            <input type="text" placeholder="Search">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </div>
        <button class="login-btn"><a href="logout.php" style="text-decoration: none; color:white;">Logout</a></button>
    </div>
  </nav>

<!-- Hero Section -->
    <section class="herooo">
        <h2>EXPLORE JATIM</h2>
        <h1>Destinasi</h1>
    </section>

<!-- Search Bar -->
    <form action="" method="POST">
        <section class="search-bar">
            <i class="fas fa-map-marker-alt"></i>
            <input type="text" placeholder="kemana kamu pergi?" name="keyword">
            <input type="hidden" name="kategori" value="Gunung"> <!-- Ganti sesuai kategori -->
            <button class="search-btnn" name="cari_kategori_gunung_lokasi">Search</button>
            <div class="dropdownn">
                <button class="dropbtnn">All Categories</button>
                <div class="dropdown-contentt">
                    <a href="kategori_pantai.php" data-category="pantai">Pantai</a>
                    <a href="#" data-category="gunung">Gunung</a>
                    <a href="kategori_airterjun.php" data-category="air-terjun">Air Terjun</a>
                </div>
            </div>
        </section>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.querySelector('.dropdownn');
        const button = document.querySelector('.dropbtnn');

        button.addEventListener('click', function (e) {
            e.stopPropagation(); // Hindari penutupan karena klik
        dropdown.classList.toggle('active');
        });

    // Tutup dropdown saat klik di luar
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
        dropdown.classList.remove('active');
        }
        });
    });
    </script>

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
