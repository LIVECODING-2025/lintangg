<?php
session_start();
require 'function.php';

if (!isset($_SESSION['id_user'])) {
    die("Anda belum login. <a href='login.php'>Login di sini</a>");
}

$id_user = intval($_SESSION['id_user']);

// Query data user
$data = query("SELECT * FROM data_login WHERE id_user = $id_user");

if (!$data || count($data) === 0) {
    die("Data pengguna tidak ditemukan.");
}

//edit profile
$data = query("SELECT * FROM data_login WHERE id_user = $id_user");

if (!empty($data)) {
    $result = $data[0]; // Ambil data pertama dari array
    $id_user = $result['id_user'];
    $nama = $result['nama'];
    $username = $result['username'];
} else {
    die("Data pengguna tidak ditemukan.");
}

// Masukkan data dalam database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($koneksi, $_POST['alamat']) : '';
    $notelfon = isset($_POST['notelfon']) ? mysqli_real_escape_string($koneksi, $_POST['notelfon']) : '';

    $query = "UPDATE data_login SET alamat='$alamat', notelfon='$notelfon' WHERE id_user=$id_user";
    mysqli_query($koneksi, $query) or die("Query gagal: " . mysqli_error($koneksi)); // ✅ FIXED
}

//Edit nama dan username
if (isset($_POST['submit'])) {
    $id_user = htmlspecialchars($_POST['id_user']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);

    // Update data wisata
    $query = mysqli_query($koneksi, "UPDATE data_login SET nama = '$nama', username = '$username' WHERE id_user = '$id_user'");

    if ($query) {
        $_SESSION['pesan'] = [
            'type' => 'berhasil',
            'isi' => 'Data Berhasil Diedit'
        ];
        header("location:profile.php");
        exit();
    } else {
        $_SESSION['pesan'] = [
            'type' => 'gagal',
            'isi' => 'Data Tidak Berhasil Diedit'
        ];
        header("location:form_edit_profile.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Edit Profile Piknik'In.Aja</title>
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
    <a href="profile.php">Profil Saya</a>
  </div>
</div>


  </nav>

  <div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 sidebar">
      <a href="form_edit_profile.php" class="active" class="sidebar-link"><i class="fas fa-user-edit me-2"></i>Edit Profil</a>
      <div class="sidebar-section-title">TAMBAHAN</div>
      <a href="riwayat_tiket.php" class="sidebar-link"><i class="bi bi-bell me-2"></i>Riwayat Tiket</a>
      <a href="profile.php" class="sidebar-link"><i class="bi bi-person me-2"></i>User Info</a>
      <a href="logout.php" class="sidebar-link"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
    </div>

    <!-- Content -->
    <div class="col-md-9 col-lg-10 py-4">
      <div class="d-flex align-items-center gap-4 mb-4 px-3 px-md-5">
        <img src="foto/profile real.png" alt="Profile" class="profile-img"/>
        <div>
          <?php
            if (!empty($data) && is_array($data)) {
            $row = $data[0];
          ?>
          <h5 class="mb-1"><?php echo htmlspecialchars($row["username"]); ?></h5>
          <p class="text-muted mb-0">Hi, <?php echo htmlspecialchars($row["username"]); ?></p>
          <?php
          } else {
            echo '<h5 class="mb-1">Data tidak ditemukan</h5>';
            echo '<p class="text-muted mb-0">Hi, Guest</p>';
          }
          ?>
        </div>
      </div>

    <form action="" method="POST">
      <div class="row">
        <!-- Kiri -->
        <div class="col-md-5 px-5">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label> 
            <input type="text" name="username" class="form-control" id="nama" placeholder="isi nama lengkap anda" value="<?= htmlspecialchars(limitWords($result['username'] ?? '')) ?>">          
          </div>
          <div class="mb-3">
            <label for="telepon" class="form-label">Nomor Telepon</label>
            <input type="text" name="notelfon" class="form-control" id="telepon" placeholder="isi nomor telepon anda">
          </div>
        </div>

        <!-- Kanan -->
        <div class="col-md-5 px-5">
          <div class="mb-3">
            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" id="namaLengkap" placeholder="isi nama lengkap anda" value="<?= htmlspecialchars(limitWords($result['nama'] ?? '')) ?>">
          </div>
          <div class="mb-3">
            <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
            <input type="text" name="alamat" class="form-control" id="alamatLengkap" placeholder="isi alamat lengkap anda">
          </div>
        </div>
      </div>

      <!-- Tombol Save -->
      <div class="row">
        <div class="col mt-4 mb-4">
          <input type="hidden" name="id_user" value="<?= $id_user ?>">
          <button type="submit" name="submit" class="btn px-5 py-2" style="background-color: #013220; margin-left: 420px; color: white;">
            Simpan Data
          </button>
        </div>
      </div>
    </form>
    </div> <!-- end content -->
  </div> <!-- end row -->
</div> <!-- end container -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>
