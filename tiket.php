<?php
include("function.php");

// Cek apakah id tersedia di URL
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan di URL.");
}

// Ambil dan sanitasi id
$id = intval($_GET['id']);

// Query ambil data berdasarkan id
$query = "SELECT * FROM data_wisata WHERE id = $id";
$result = mysqli_query($koneksi, $query);

// Cek error SQL
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

// Ubah hasil menjadi array asosiatif
$data = mysqli_fetch_assoc($result);
?>


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

<!-- Header Hero -->
    <section class="herrlo">
          <div class="overlay">
            <div class="herrlo-content">
                <p class="harga">Harga <strong>Rp.<?= number_format($data["harga"] , 0, ',', '.'); ?></strong></p>
                <h1 class="judul">Explore <?= $data["nama_wisata"]; ?></</h1>
                <p class="lokasi">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= $data["lokasi"]; ?>
                </p>
                <!-- Popup tiket -->
                <div>
                    <button class="pesan-tiket-btn" onclick="document.getElementById('popupTiket').style.display='flex'">Lihat Tiket</button>

                    <div id="popupTiket" class="popup-overlay">
                        <div class="popup-content">
                            <button class="btn-close" onclick="document.getElementById('popupTiket').style.display='none'">&times;</button>
                            <h2>Tiket Kamu</h2>

                <!-- Gambar tiket dari database -->
                            <img src="foto/<?= $data["tiket"]; ?>" alt="Tiket" id="gambarTiket">

                <!-- Link unduh sesuai nama file dari database -->
                            <a href="foto/<?= $data["tiket"]; ?>" download="<?= 'Tiket_' . pathinfo($data['tiket'], PATHINFO_FILENAME) . '.jpg'; ?>" class="btn-download">
                                Unduh Tiket
                            </a>
                        </div>
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
          <li>✅ <?= $data["deskripsi"]; ?></li>
          <li>✅ <?= $data["deskripsi 2"]; ?></li>
          <li>✅ <?= $data["deskripsi 3"]; ?></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Foto Section -->
<section class="foto-section">
  <div class="container">
    <div class="foto">
      <h2>Foto</h2>
      <hr class="divider">
      <div class="foto-masonry">
        <img src="foto/<?= $data['gambar_deskrpsi']; ?>" alt="Foto 1">
        <img src="foto/<?= $data['gambar_deskripsi_2']; ?>" alt="Foto 2">
        <img src="foto/<?= $data['gambar_deskrpsi_3']; ?>" alt="Foto 3">
        <img src="foto/<?= $data['gambar_deskrpsi_4']; ?>" alt="Foto 4">
        <img src="foto/<?= $data['gambar_deskrpsi_5']; ?>" alt="Foto 5">
        <img src="foto/<?= $data['gambar_deskrpsi_6']; ?>" alt="foto 6">
        <img src="foto/<?= $data['gambar_deskrpsi_7']; ?>" alt="Foto 7">
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
