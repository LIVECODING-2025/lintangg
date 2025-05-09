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

    mysqli_query($koneksi, "INSERT INTO data_login (username, password,nama) VALUES ('$username','$password', '$nama')" );

    return mysqli_affected_rows($koneksi);
}
?>

