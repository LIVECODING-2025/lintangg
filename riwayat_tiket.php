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

//menampilkan riwayat tiket ke halaman tiket untuk download
// Ambil username yang sedang login
$username = $_SESSION['username'];

// Ambil nama_wisata dan tanggal_booking dari userr, lalu ambil ID dari data_wisataa
$query = "SELECT u.nama_wisata, u.tanggal_booking, w.id AS id 
          FROM data_userr u
          JOIN data_wisataa w ON u.nama_wisata = w.nama_wisata
          WHERE u.username = '$username'";

$result = mysqli_query($koneksi, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Tiket Piknik'In.Aja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      padding: 15px 28px; /* Lebar padding diperbesar */
      width: 100%;
      background-color: #fff;
      flex-wrap: wrap;
      position: relative;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .logo {
        font-weight: bold;
        font-size: 22px;
        color: #013220;
        margin-left: 35px;
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
        color: #013220;
        font-size: 16px; /* Ukuran teks lebih besar */
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

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .search-login {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .search-box {
      position: relative;
    }

    .search-box input {
      padding: 10px 40px 10px 14px;
      border: none;
      margin-left: -35px;
      border-radius: 6px;
      background-color: #f0f0f0;
      font-size: 14px;
      color: #333;
      width: 220px;
    }

    .search-icon {
      position: absolute;
      right: 12px;
      top: 18px;
      background: transparent;
      border: none;
      transform: translateY(-50%);
      width: 18px;
      height: 18px;
      pointer-events: none;
    }

  .profile-img-nav {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
  }

  .profile-dropdown {
    position: relative;
  }

  .profile-dropdown .dropdown-content {
    right: 0;
    left: auto;
    top: 45px;
    min-width: 150px;
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

    .dropdown input[type="checkbox"] {
      display: none;
    }

    @media (max-width: 768px) {
      .hamburger {
        display: flex;
      }

      .nav-links,
      .search-login {
        display: none;
        width: 100%;
        flex-direction: column;
        margin-top: 12px;
      }

      #toggle-menu:checked ~ .nav-links,
      #toggle-menu:checked ~ .search-login {
        display: flex;
      }

      .nav-links a,
      .nav-links label {
        padding: 10px 0;
      }

      .dropdown-content {
        position: relative;
        box-shadow: none;
        border-radius: 0;
        background-color: #f9f9f9;
        top: 0;
      }

      .dropdown:hover .dropdown-content {
        display: none;
      }

      .dropdown input[type="checkbox"]:checked + .dropdown-content {
        display: block;
      }

      .search-box input {
        width: 100%;
      }

      .login-btn {
        width: 100%;
        text-align: center;
      }

      .btn button {
        margin-left: 20px;
      }
    }

    .sidebar {
      min-height: 100vh;
      background-color: #013220;
      padding-top: 20px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
    }

    .sidebar a.active {
      border-left: 3px solid green;
      font-weight: bold;
    }

    .profile-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
    }

    .sidebar-section-title {
      font-size: 0.75rem;  /* Ukuran kecil */
      text-transform: uppercase;
      color: #a0a0a0;       /* Abu-abu terang */
      font-weight: 600;
      margin: 1rem 0 0.5rem 0;
      padding-left: 0.5rem;
    }

    
  </style>
</head>
<body>
  <!-- Navbar -->
    <nav>
      <div class="logo-atas">
        <div class="logo">Piknik’In.Aja</div>
      </div>

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

  <!-- Profile Dropdown -->
<div class="dropdown profile-dropdown">
  <label for="drop-profile" class="profile-toggle">
    <img src="foto/profile real.png" alt="Profile" class="profile-img-nav">
  </label>
  <input type="checkbox" id="drop-profile">
  <div class="dropdown-content dropdown-end">
    <a href="form_edit_profile.php">Profil Saya</a>
  </div>
</div>


  </nav>

    <div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 sidebar">
      <a href="form_edit_profile.php" class="sidebar-link"><i class="fas fa-user-edit me-2"></i>Edit Profil</a>
      <div class="sidebar-section-title">TAMBAHAN</div>
      <a href="riwayat_tiket.php" class="active sidebar-link"><i class="bi bi-bell me-2"></i>Riwayat Tiket</a>
      <a href="profile.php" class="sidebar-link"><i class="bi bi-person me-2"></i>User Info</a>
      <a href="logout.php" class="sidebar-link"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
    </div>

    <!-- Konten Utama -->
    <div class="col-md-9 col-lg-10 p-4">
      <div class="row">
        <div class="col-12 mb-3">
          <h4 class="fw-bold">Riwayat Tiket Anda</h4>
        </div>

        <?php
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <div class="col-12 col-md-6 col-lg-3 mb-5">
              <a href="tiket_riwayat.php?id=<?= urlencode($row['id']) ?>" style="text-decoration: none; color: inherit;">
              <div class="card shadow-sm border-0 h-100">
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
