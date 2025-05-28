<?php
session_start();
require 'function.php';

if (!isset($_SESSION['id_user'])) {
    die("Anda belum login. <a href='login.php'>Login di sini</a>");
}

// Pastikan user sudah login dan session id_user tersedia
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    tampilkanRiwayatTiket($koneksi, $id_user);
} else {
    echo "Anda harus login untuk melihat riwayat tiket.";
}

$result = null;
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $result = tampilkanRiwayatTiket($koneksi, $id_user);
} else {
    echo "Anda harus login untuk melihat riwayat tiket.";
}

// Ambil username yang sedang login
$username = $_SESSION['username'];

// Jalankan pembaruan status tiket yang sudah kedaluwarsa
updateTiketKedaluwarsa($koneksi);

// Hapus tiket hangus (jika perlu)
$jumlahHangus = hapusTiketHangus($koneksi);

// Ambil data riwayat tiket user
$query = "SELECT u.nama_wisata, u.tanggal_booking, u.status, w.id AS id 
          FROM data_userr u
          JOIN data_wisataa w ON u.nama_wisata = w.nama_wisata
          WHERE u.username = '$username'";
$result = mysqli_query($koneksi, $query);

// Fungsi untuk update status tiket kedaluwarsa
function updateTiketKedaluwarsa($koneksi) {
    $today = date('Y-m-d');
    $sql = "UPDATE data_userr SET status = 'hangus' WHERE tanggal_booking < ? AND status = 'booked'";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $stmt->close();
}

// Fungsi untuk hapus tiket yang statusnya sudah hangus
function hapusTiketHangus($koneksi) {
    $sql = "DELETE FROM data_userr WHERE status = 'hangus'";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    $jumlahHangus = $stmt->affected_rows;
    $stmt->close();
    return $jumlahHangus;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Tiket Piknik'In.Aja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <?php if ($jumlahHangus > 0): ?>
  <div id="popup-alert" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 9999;">
    <div style="background: white; padding: 30px 20px; border-radius: 12px; max-width: 400px; width: 90%; box-shadow: 0 4px 12px rgba(0,0,0,0.2); text-align: center;">
      <h5 style="color: #0A3D2C;">Tiket Hangus</h5>
      <p><?= $jumlahHangus ?> tiket telah hangus karena melebihi tanggal booking dan telah dihapus.</p>
      <button onclick="closePopup()" style="background-color: #0A3D2C; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">OK</button>
    </div>
  </div>
  <script>
    function closePopup() {
      const popup = document.getElementById('popup-alert');
      popup.style.display = 'none';
    }
  </script>
<?php endif; ?>
  <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'poppins', sans-serif;
        background: #fff;
        overflow-x: hidden;
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 28px;
      margin: 0px 60px;
      background-color: #fff;
      flex-wrap: wrap;
      position: relative;
    }

    .logo {
      font-weight: bold;
      font-size: 22px;
      color: #0A3D2C;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 40px;
      flex-wrap: wrap;
    }

    .nav-links a,
    .nav-links label {
      text-decoration: none;
      color: #0A3D2C;
      font-size: 16px;
      cursor: pointer;
    }

    .dropdown {
      position: relative;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      top: 40px;
      left: 0;
      min-width: 160px;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
      z-index: 999;
      border-radius: 6px;
    }

    .dropdown-content a {
      display: block;
      padding: 12px 16px;
      color: #013220;
      text-decoration: none;
      font-size: 16px;
    }

    .dropdown-content a:hover {
      background-color: #f0f0f0;
    }

    .search-login {
      display: flex;
      align-items: center;
      gap: 16px;
      position: relative;
    }

    .search-box {
      position: relative;
    }

    .search-box input {
      padding: 10px 40px 10px 14px;
      border: none;
      border-radius: 6px;
      background-color: #f0f0f0;
      font-size: 14px;
      color: #333;
      width: 200px;
    }

    .search-icon {
      position: absolute;
      right: 12px;
      top: 45%;
      background: transparent;
      border: none;
      color: #013220;
      transform: translateY(-50%);
      width: 18px;
      height: 18px;
      pointer-events: none;
    }

    .profile-dropdown {
      position: relative;
    }

    .profile-img-nav {
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
      box-shadow: 0 0 2px rgba(0,0,0,0.15);
      width: 32px;
      height: 32px;
      cursor: pointer;
    }

    .profile-dropdown .dropdown-content {
      right: 0;
      left: auto;
      top: 40px;
      min-width: 120px;
      max-width: 180px;
      width: auto;
      padding: 6px 0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      border-radius: 6px;
      background-color: white;
      z-index: 1000;
      overflow: hidden;
      display: none;
    }

    .profile-dropdown .dropdown-content a {
      display: block;
      padding: 10px 16px;
      color: #013220;
      text-decoration: none;
      font-size: 14px;
    }

    .profile-dropdown .dropdown-content a:hover {
      background-color: #f0f0f0;
    }

    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
    }

    .hamburger div {
      width: 28px;
      height: 3px;
      background: #333;
    }

    #toggle-menu {
      display: none;
    }

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

    .profile-box {
      position: relative;
      margin: auto;
      background-color: #fff;
      border-radius: 12px;
      padding: 30px 40px;
      box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.2); /* Bayangan ke atas */
      z-index: 10;
      width: 90%;
      max-width: 800px;
    }

    @media (max-width: 768px) {
    .profile-box {
        top: 30px;
    }
    }

    @media (max-width: 480px) {
    .profile-box {
        top: 30px;
    }
    }

    /* Hero */
    .heroo {
        height: 80vh;
        color: white;
        background: url('foto/bg deskripsi wisata.jpeg') no-repeat center/cover;
        text-align: center;
        padding: 60px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .overlay {
      position: absolute; /* Tambahkan ini */
      top: 40;
      left: 0;
      width: 100%;
      height: 80%;
      background: rgba(0, 0, 0, 0.4); /* efek gelap */
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1;
    }

    /* Tambahan agar teks tidak terlalu besar di layar kecil */
    .heroo h2 {
        font-size: 50px;
        margin-top: -30px;
    }

    /* Responsif: untuk layar berukuran kecil (mobile) */
    @media (max-width: 768px) {
    .heroo {
        padding: 40px 15px;
        height: 70vh;
    }

    .overlay {
      height: 400px;
    }

    .heroo h2 {
        margin-top: 100px;
        font-size: 20px;
    }

    .heroo h1 {
        font-size: 32px;
        margin-top: -5px;
    }
    }

    @media (max-width: 480px) {
    .heroo {
        height: 60vh;
    }

    .heroo h2 {
        margin-top: 50px;
        font-size: 18px;
    }

    .heroo h1 {
        font-size: 26px;
    }
}
  </style>
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
    <a href="dashboard.php">Dashboard</a>
    <a href="tentang_kami.php">Tentang Kami</a>
    <div class="dropdown" id="destinasi-dropdown">
      <label onclick="toggleDestinasiDropdown(event)">Destinasi</label>
      <div class="dropdown-content" id="destinasi-menu">
        <a href="kategori_pantai.php">Pantai</a>
        <a href="kategori_gunung.php">Gunung</a>
        <a href="kategori_airterjun.php">AirTerjun</a>
      </div>
    </div>
    <a href="riwayat_tiket.php" style="font-weight: bold;">Riwayat Tiket</a>
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
  <section class="heroo">
    <div class="overlay">
        <h2>Riwayat Tiket</h2>
    </div>
  </section>

  <!-- Box yang mengambang di atas hero -->
  <div class="profile-box" style="margin-top: -150px;">
    <div class="container">
      <div class="rounded-4">
        <h4 class="fw-bold mb-2">Riwayat Tiket Anda</h4>
        <div class="row">
          <?php
          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
          ?>
            <div class="col-12 col-md-6 col-lg-5 mb-4">
              <a href="tiket_riwayat.php?id=<?= urlencode($row['id']) ?>" class="text-decoration-none text-dark">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                  <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                      <h6 class="fw-bold mb-1"><?= htmlspecialchars($row['nama_wisata']) ?></h6>
                      <small class="text-muted"><?= htmlspecialchars($row['tanggal_booking']) ?></small>
                    </div>
                    <i class="fa-solid fa-ticket fa-lg text-danger"></i>
                  </div>
                </div>
              </a>
            </div>
          <?php
              }
          } else {
              echo '<div class="col-12"><p class="text-muted">Belum ada riwayat pemesanan.</p></div>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>
