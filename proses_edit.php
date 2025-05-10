<?php
session_start();
include ("function.php");

if (isset($_POST['submit'])) {
    $id_produk = htmlspecialchars($_POST['id']);
    $nama_wisata = htmlspecialchars($_POST['nama_wisata']);
    $harga = htmlspecialchars($_POST['harga']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    // Ambil nama gambar lama dari database
    $wisata = mysqli_query($koneksi, "SELECT gambar FROM data_wisataa WHERE id = '$id_produk'");
    $result = mysqli_fetch_assoc($wisata);
    $gambar_lama = $result['gambar'];

    // Cek apakah ada gambar baru yang diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "gambar/";

        // Buat folder jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["gambar"]["name"] === $gambar_lama) {
                $gambar_baru = $gambar_lama;
            } else {
                if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                    if (!empty($gambar_lama) && file_exists($target_dir . $gambar_lama)) {
                        unlink($target_dir . $gambar_lama);
                    }
                    $gambar_baru = basename($_FILES["gambar"]["name"]);
                } else {
                    $_SESSION['pesan'] = [
                        'type' => 'gagal',
                        'isi' => 'Gambar gagal diupload.'
                    ];
                    header("location:admin.php");
                    exit();
                }
            }
        } else {
            $_SESSION['pesan'] = [
                'type' => 'gagal',
                'isi' => 'File bukan gambar.'
            ];
            header("location:admin.php");
            exit();
        }
    } else {
        $gambar_baru = $gambar_lama;
    }

    // Update data wisata
    $query = mysqli_query($koneksi, "UPDATE data_wisataa SET nama_wisata = '$nama_wisata', harga = '$harga', kategori = '$kategori', lokasi = '$lokasi', deskripsi = '$deskripsi', gambar = '$gambar_baru' WHERE id = '$id_produk'");

    if ($query) {
        $_SESSION['pesan'] = [
            'type' => 'berhasil',
            'isi' => 'Data Berhasil Diedit'
        ];
        header("location:admin.php");
        exit();
    } else {
        $_SESSION['pesan'] = [
            'type' => 'gagal',
            'isi' => 'Data Tidak Berhasil Diedit'
        ];
        header("location:admin.php");
        exit();
    }
}
?>