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

// Registrasi
function registrasi($data) {
    global $koneksi;

    $username = mysqli_real_escape_string($koneksi, $data['username']);
    $password = mysqli_real_escape_string($koneksi, $data['password']);
    $nama = mysqli_real_escape_string($koneksi, $data['nama']);
    
    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO data_login (username, password, nama) VALUES ('$username', '$password_hash', '$nama')";
    
    return mysqli_query($koneksi, $query);
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

