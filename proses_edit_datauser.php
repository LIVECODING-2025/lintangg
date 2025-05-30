<?php
session_start();
include("function.php"); // Pastikan file ini berisi koneksi $koneksi

if (isset($_POST['submit'])) {
    // Ambil dan sanitasi input
    $id_produk        = htmlspecialchars($_POST['id']);
    $username         = htmlspecialchars($_POST['username']);
    $tanggal_booking  = htmlspecialchars($_POST['tanggal_booking']);
    $notelfon         = htmlspecialchars($_POST['notelfon']);
    $nama_wisata      = htmlspecialchars($_POST['nama_wisata']);
    $status           = htmlspecialchars($_POST['status']);

    // Cek data lama
    $query = mysqli_query($koneksi, "SELECT * FROM data_userr WHERE id = '$id_produk'");
    $data_lama = mysqli_fetch_assoc($query);

    if (!$data_lama) {
        $_SESSION['pesan'] = ['type' => 'gagal', 'isi' => 'Data tidak ditemukan.'];
        header("location:admin.php");
        exit();
    }

    // Update data
    $update = mysqli_query($koneksi, "UPDATE data_userr SET 
        nama_wisata        = '$nama_wisata',
        username           = '$username',
        tanggal_booking    = '$tanggal_booking',
        notelfon           = '$notelfon',
        status             = '$status'
        WHERE id           = '$id_produk'
    ");

    if ($update) {
        $_SESSION['pesan'] = ['type' => 'berhasil', 'isi' => 'Data berhasil diperbarui.'];
    } else {
        $_SESSION['pesan'] = ['type' => 'gagal', 'isi' => 'Gagal memperbarui data.'];
    }

    header("location:data_pemesanan.php");
    exit();
}
?>
