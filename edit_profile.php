<?php
session_start();
require 'function.php'; // pastikan koneksi ke DB

$id_user = $_SESSION['id_user'];
$data = query("SELECT * FROM data_login WHERE id_user = $id_user");

if (!$data || count($data) === 0) {
    die("Data pengguna tidak ditemukan.");
}

$user = $data[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $notelfon = htmlspecialchars($_POST['notelfon']);
    $fotoBaru = $user['foto'];

    // Proses upload foto jika ada file diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $namaFile = $_FILES['foto']['name'];
        $tmpName = $_FILES['foto']['tmp_name'];
        $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensiFile = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        if (in_array($ekstensiFile, $ekstensiValid)) {
            $namaBaru = uniqid() . '.' . $ekstensiFile;
            move_uploaded_file($tmpName, 'foto/' . $namaBaru);

            // Hapus foto lama jika bukan default
            if (!empty($user['foto']) && $user['foto'] !== 'default.png' && file_exists('foto/' . $user['foto'])) {
                unlink('foto/' . $user['foto']);
            }

            $fotoBaru = $namaBaru;
        }
    }

    $query = "UPDATE data_login SET 
                nama = '$nama',
                username = '$username',
                alamat = '$alamat',
                notelfon = '$notelfon',
                foto = '$fotoBaru'
              WHERE id_user = $id_user";

    if (mysqli_query($koneksi, $query)) {
        header("Location: profile.php");    
        exit;
    } else {
        echo "Gagal mengupdate profil: " . mysqli_error($koneksi);
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

    .edit-container {
        max-width: 600px;
        background-color: #f8f9fa; 
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

     /* Hero Section */
    .heroo {
      position: relative;
      height: 80vh;
      background: url('foto/profile tengah.jpg') no-repeat center/cover;
      color: white;
      text-align: center;
      padding: 60px 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      z-index: 1;
    }

    .heroo h2 {
      margin-top: 10px;
      font-size: 50px;
    }

    /* Profile Box floating */
    .profile-box {
      position: relative;
      top: -150px; /* Naik di atas hero */
      margin: auto;
      background-color: #fff;
      border-radius: 12px;
      padding: 30px 40px;
      box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.2); /* Bayangan ke atas */
      z-index: 10;
      width: 90%;
      max-width: 800px;
    }

    /* Gambar Profil */
    .profile-picture {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #ccc;
        position: absolute;
    }

    /* Responsif */
    @media (max-width: 768px) {
      .heroo {
        height: 70vh;
        padding: 40px 15px;
      }

      .heroo h2 {
        font-size: 32px;
      }

      .profile-box {
        top: -60px;
        padding: 20px;
        box-shadow: 0 -6px 20px rgba(0, 0, 0, 0.15);
      }
    }

    @media (max-width: 480px) {
      .heroo {
        height: 60vh;
      }

      .heroo h2 {
        font-size: 26px;
      }

      .profile-box {
        top: -50px;
        padding: 16px;
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
    <a href="riwayat_tiket.php">Riwayat Tiket</a>
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
  <div class="container">
    <div class="row">
        <h2>Edit Profile</h2>
    </div>
  </div>
</section>

<!-- Floating Profile Form -->
<section class="profile-box">
  <form method="POST" action="edit_profile.php" enctype="multipart/form-data">
    <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">

    <div class="text-center mb-4">
      <img src="foto/<?= htmlspecialchars($user['foto'] ?: 'default.png') ?>" alt="Foto Profil" class="profile-picture" style="position: static;">
    </div>

    <div class="mb-3">
      <label for="foto" class="form-label">Ganti Foto Profil</label>
      <input type="file" name="foto" id="foto" class="form-control">
      <small class="text-muted">Format: JPG, JPEG, PNG, WEBP. Max: ~2MB.</small>
    </div>

    <div class="mb-3">
      <label for="nama" class="form-label">Nama Lengkap</label>
      <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($user['nama']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="alamat" class="form-label">Alamat</label>
      <input type="text" name="alamat" id="alamat" class="form-control" value="<?= htmlspecialchars($user['alamat']) ?>">
    </div>

    <div class="mb-3">
      <label for="notelfon" class="form-label">No. Telepon</label>
      <input type="text" name="notelfon" id="notelfon" class="form-control" value="<?= htmlspecialchars($user['notelfon']) ?>">
    </div>

    <div class="d-grid gap-2">
      <button type="submit" name="submit" class="btn" style="background-color: #013220; color: white;">Simpan Perubahan</button>
      <a href="profile.php" class="btn btn-secondary">Kembali</a>
    </div>
  </form>
</section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>