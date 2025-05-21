<?php
include ("function.php");

// Ambil ID dari URL
$id = $_GET['id'];

// Query ambil data berdasarkan id
$query = "SELECT * FROM data_wisataa WHERE id = $id";
$result = mysqli_query($koneksi, $query);

// Ubah hasil menjadi array asosiatif
$data = mysqli_fetch_assoc($result);

// Simpan pemesanan jika form disubmit
if (isset($_POST['submit_booking'])) {
  $nama = $_POST['nama'];
  $tanggal_booking = $_POST['tanggal_booking'];
  $notelfon = $_POST['notelfon'];
  $nama_wisata = $_POST['nama_wisata'];
  $id = $_GET['id'] ?? null; // ID dari URL

  if ($nama && $tanggal_booking && $notelfon && $nama_wisata) {
      $insert = "INSERT INTO data_userr (nama, tanggal_booking, notelfon, nama_wisata) 
                 VALUES ('$nama', '$tanggal_booking', '$notelfon', '$nama_wisata')";
      if (mysqli_query($koneksi, $insert)) {
          // Redirect ke tiket.php dengan id
          header("Location: tiket.php?id=$id");
          exit(); // penting agar redirect berjalan sempurna
      } else {
          echo "Gagal menyimpan: " . mysqli_error($koneksi);
      }
  } else {
      echo "<script>alert('Semua kolom wajib diisi.');</script>";
  }
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
    <title>Deskripsi Destinasi Piknik'in.Aja</title>
    <link rel="stylesheet" href="style1.css" id="paragraf 5">
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
            <input type="text" placeholder="Search">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </div>
        <button class="login-btn"><a href="logout.php" style="text-decoration: none; color:white;">Logout</a></button>
    </div>
  </nav>

<!-- Header Hero -->
    <section class="herrlo">
          <div class="overlay">
            <div class="herrlo-content" style="color: white;">
                <p class="harga" style="text-align:center;">Harga <strong>Rp.<?= number_format($data["harga"] , 0, ',', '.'); ?></strong></p>
                <h1 class="judul">Explore <?= $data["nama_wisata"]; ?></</h1>
                <p class="lokasi">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= $data["lokasi"]; ?>
                </p>
                <button class="pesan-tiket-btn" style="display: block; margin: 20px auto 0;" onclick="openPopup()">Pesan Tiket</button>
            </div> 
          </div>
    </section>

<!-- Popup -->
<div class="popup-overlay" id="popup">
  <div class="popup-container">
    <button class="close-btn" onclick="closePopup()">×</button> <!-- pindahkan ke sini -->
    <div class="popup-left">
      <h2>Pesan Wisata ini</h2>
      <p>Pesan tiket anda yang tak terlupakan hari ini! Untuk pertanyaan atau saran pribadi, jangan ragu untuk menghubungi kami.</p>
      <div class="contact">
        <p>📞 0895-2518-0744</p>
        <p>✉️ <a href="mailto:ExploreJatim@gmail.com">ExploreJatim@gmail.com</a></p>
      </div>
    </div>
    <form method="POST" action="">
      <div class="popup-right">
        <h3>Harga <strong>Rp<?= number_format($data["harga"] , 0, ',', '.'); ?></strong></h3>
        <input type="text" class="form-input" name="nama" placeholder="Name" required>
        <div class="form-row">
          <input type="date" class="form-input" name="tanggal_booking" placeholder="Tanggal Book" required>
          <input type="text" class="form-input" name="notelfon" placeholder="NoTelfon">
        </div>
        <input type="text" class="form-input" name="nama_wisata" placeholder="Nama Wisata" required value="<?= $data['nama_wisata'] ?>">
        <button class="booking-btn" type="submit" name="submit_booking">Booking</button>
      </div>
    </form>
  </div>
</div>


<!-- Script -->
<script>
  function openPopup() {
    document.getElementById('popup').style.display = 'flex';
  }
  function closePopup() {
    document.getElementById('popup').style.display = 'none';
  }
</script>

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
