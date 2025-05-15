<?php

$koneksi = mysqli_connect("localhost","root","","wisata");

function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows [] = $row;
    }
    return $rows;
}

function registrasi($data) {
    global $koneksi;

    $username = mysqli_real_escape_string($koneksi, $data['username']);
    $password = mysqli_real_escape_string($koneksi, $data['password']);
    $nama = mysqli_real_escape_string($koneksi, $data['nama']);

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

    // Query pencarian berdasarkan nama_wisata dan lokasi
    $query = "SELECT * FROM data_wisataa 
              WHERE nama_wisata LIKE '%$keyword%' 
              OR lokasi LIKE '%$keyword%'";
    
    return query($query); // Asumsikan 'query()' adalah fungsi untuk menjalankan SQL
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
?>

