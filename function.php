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

    $username = strtolower(stripcslashes($data["username"]));  
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $nama = $data["nama"];

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($koneksi, "INSERT INTO data_loginn (username, password,nama) VALUES ('$username','$password', '$nama')" );

    return mysqli_affected_rows($koneksi);
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

