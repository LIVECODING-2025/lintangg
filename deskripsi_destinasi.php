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
  $username = $_POST['username'];
  $tanggal_booking = $_POST['tanggal_booking'];
  $notelfon = $_POST['notelfon'];
  $nama_wisata = $_POST['nama_wisata'];
  $id = $_GET['id'] ?? null; // ID dari URL

  if ($username && $tanggal_booking && $notelfon && $nama_wisata) {
      $insert = "INSERT INTO data_userr (username, tanggal_booking, notelfon, nama_wisata) 
                 VALUES ('$username', '$tanggal_booking', '$notelfon', '$nama_wisata')";
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
    <link rel="stylesheet" href="css user/style1.css" id="paragraf 5">
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
      <label onclick="toggleDestinasiDropdown(event)" style="font-weight: bold;">Destinasi</label>
      <div class="dropdown-content" id="destinasi-menu">
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
        <input type="text" class="form-input" name="username" placeholder="Username" required>
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
          <li>✅ <?= $data["deskripsi2"]; ?></li>
          <li>✅ <?= $data["deskripsi3"]; ?></li>
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
