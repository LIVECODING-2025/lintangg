<?php
session_start();
include("function.php");

// Validasi id di URL
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']);

// Ambil data wisata berdasarkan ID
$query = "SELECT * FROM data_wisataa WHERE id = $id";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Piknik'in.Aja</title>
    <link rel="stylesheet" href="css user/style1.css" id="paragraf 5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
        <a href="dashboard.php">Dashboard</a>

        <!-- Dropdown Destinasi -->
        <div class="dropdown">
          <label for="drop-destinasi" style="font-weight: bold;">Destinasi</label>
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
                            <h4 style="color: black;">Tiket Kamu</h4>

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
        <img src="foto/<?= $data['gambar_deskripsi']; ?>" alt="Foto 1">
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