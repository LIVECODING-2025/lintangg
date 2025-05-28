<?php

$koneksi = mysqli_connect("localhost","root","","wisata");

function query($query) {
  global $koneksi;
  $result = mysqli_query($koneksi, $query);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function registrasi($data) {
    global $koneksi;

    $username = mysqli_real_escape_string($koneksi, $data['username']);
    $password = mysqli_real_escape_string($koneksi, $data['password']);
    $nama = mysqli_real_escape_string($koneksi, $data['nama']);

    // Tolak username yang mengandung kata "admin" (case-insensitive)
    if (preg_match('/admin/i', $username)) {
        echo "<script>alert('Registrasi ditolak! Username tidak boleh mengandung kata \"admin\".');</script>";
        return false;
    }

    // Cek apakah username sudah ada
    $cek = mysqli_query($koneksi, "SELECT username FROM data_login WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return false;
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert ke database
    $query = "INSERT INTO data_login (username, password, nama) VALUES ('$username', '$password_hash', '$nama')";

    if (mysqli_query($koneksi, $query)) {
        // Registrasi sukses, redirect agar tidak insert ulang saat reload
        header("Location: login.php");
        exit;
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
        return false;
    }
}

function cari_dashboard($keyword) {
    // Escape keyword untuk mencegah SQL injection
    $keyword = htmlspecialchars($keyword);

    // Query pencarian berdasarkan nama_wisata dan lokasi, tetapi tetap dalam kategori Pantai
    $query = "SELECT * FROM data_wisataa 
              WHERE kategori = 'Pantai' AND 
              (nama_wisata LIKE '%$keyword%' 
              OR lokasi LIKE '%$keyword%')";

    return query($query);
}

function cari_kategori_pantai($keyword) {
    // Escape keyword untuk mencegah SQL injection
    $keyword = htmlspecialchars($keyword);

    // Query pencarian berdasarkan nama_wisata dan lokasi
    $query = "SELECT * FROM data_wisataa
              WHERE nama_wisata LIKE '%$keyword%'";
    
    return query($query); // Asumsikan 'query()' adalah fungsi untuk menjalankan SQL
}

function cari_kategori_pantai_lokasi($keyword, $kategori) {
    $keyword = htmlspecialchars($keyword);
    $kategori = htmlspecialchars($kategori);

    $query = "SELECT * FROM data_wisataa 
              WHERE kategori = '$kategori' 
              AND lokasi LIKE '%$keyword%'";

    return query($query); // Asumsikan fungsi query() sudah tersedia
}

function cari_kategori_airterjun($keyword) {
    // Escape keyword untuk mencegah SQL injection
    $keyword = htmlspecialchars($keyword);

    // Query pencarian berdasarkan nama_wisata dan lokasi
    $query = "SELECT * FROM data_wisataa 
              WHERE nama_wisata LIKE '%$keyword%'";
    
    return query($query); // Asumsikan 'query()' adalah fungsi untuk menjalankan SQL
}

function cari_kategori_airterjun_lokasi($keyword, $kategori) {
    $keyword = htmlspecialchars($keyword);
    $kategori = htmlspecialchars($kategori);

    $query = "SELECT * FROM data_wisataa 
              WHERE kategori = '$kategori' 
              AND lokasi LIKE '%$keyword%'";

    return query($query); // Asumsikan fungsi query() sudah tersedia
}

function cari_kategori_gunung($keyword) {
    // Escape keyword untuk mencegah SQL injection
    $keyword = htmlspecialchars($keyword);

    // Query pencarian berdasarkan nama_wisata dan lokasi
    $query = "SELECT * FROM data_wisataa 
              WHERE nama_wisata LIKE '%$keyword%'";
    
    return query($query); // Asumsikan 'query()' adalah fungsi untuk menjalankan SQL
}

function cari_kategori_gunung_lokasi($keyword, $kategori) {
    $keyword = htmlspecialchars($keyword);
    $kategori = htmlspecialchars($kategori);

    $query = "SELECT * FROM data_wisataa 
              WHERE kategori = '$kategori' 
              AND lokasi LIKE '%$keyword%'";

    return query($query); // Asumsikan fungsi query() sudah tersedia
}

// Fungsi batas kata
function limitWords($string, $limit = 10) {
    $words = explode(' ', $string);
    return implode(' ', array_slice($words, 0, $limit));
}

function tampilkanRiwayatTiket($koneksi, $id_user) {
    // Ambil username dari data_login
    $sql_user = "SELECT username FROM data_login WHERE id_user = ?";
    $stmt_user = $koneksi->prepare($sql_user);
    $stmt_user->bind_param("i", $id_user);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows === 0) {
        return null; // Tidak ditemukan
    }

    $username = $result_user->fetch_assoc()['username'];

    // Ambil riwayat tiket dari data_userr
    $sql = "SELECT nama_wisata, tanggal_booking FROM data_userr WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}
?>

