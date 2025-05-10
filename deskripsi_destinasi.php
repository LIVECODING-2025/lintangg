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


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deskripsi Destinasi</title>
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
            <div class="herlo-content" style="color: white;">
                <p class="harga" style="text-align:center;">Harga <strong>Rp.<?= number_format($data["harga"] , 0, ',', '.'); ?></strong></p>
                <h1 class="judul">Explore <?= $data["nama_wisata"]; ?></</h1>
                <p class="lokasi">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= $data["lokasi"]; ?>
                </p>
                <button class="pesan-tiket-btn" onclick="openPopup()">Pesan Tiket</button>
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
        <h3>Harga <strong>Rp. 30.000</strong></h3>
        <input type="text" class="form-input" name="nama" placeholder="Name" required>
        <div class="form-row">
          <input type="date" class="form-input" name="tanggal_booking" placeholder="Tanggal Book" required>
          <input type="text" class="form-input" name="notelfon" placeholder="NoTelfon">
        </div>
        <input type="text" class="form-input" name="nama_wisata" placeholder="Nama Wisata" required>
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
