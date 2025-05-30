<?php
session_start();
include("function.php");

if (isset($_POST["submit"])) {
    $nama_wisata = strtoupper($_POST["nama_wisata"]);
    $lokasi = $_POST["lokasi"];
    $harga = $_POST["harga"];
    $kategori = $_POST["kategori"];
    $deskripsi = $_POST["deskripsi"];
    $deskripsi2 = $_POST["deskripsi2"];
    $deskripsi3 = $_POST["deskripsi3"];

    $target_dir = "foto/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    function uploadFile($field_name, $target_dir) {
        if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] == 0) {
            $file_tmp = $_FILES[$field_name]['tmp_name'];
            $file_name = basename($_FILES[$field_name]['name']);
            $target_file = $target_dir . $file_name;
            $check = getimagesize($file_tmp);

            if ($check !== false) {
                if (move_uploaded_file($file_tmp, $target_file)) {
                    return $file_name;
                }
            }
        }
        return null; // jika gagal upload
    }

    // Upload semua gambar
    $gambar = uploadFile("gambar", $target_dir);
    $tiket = uploadFile("tiket", $target_dir);
    $gambar_deskripsi = uploadFile("gambar_deskripsi", $target_dir);
    $gambar_deskripsi_2 = uploadFile("gambar_deskripsi_2", $target_dir);
    $gambar_deskrpsi_3 = uploadFile("gambar_deskrpsi_3", $target_dir);
    $gambar_deskrpsi_4 = uploadFile("gambar_deskrpsi_4", $target_dir);
    $gambar_deskrpsi_5 = uploadFile("gambar_deskrpsi_5", $target_dir);
    $gambar_deskrpsi_6 = uploadFile("gambar_deskrpsi_6", $target_dir);
    $gambar_deskrpsi_7 = uploadFile("gambar_deskrpsi_7", $target_dir);

    // Validasi upload gambar utama
    if (!$gambar || !$tiket) {
        echo "Gagal mengupload gambar utama atau tiket.";
        exit();
    }

    $query = "INSERT INTO data_wisataa 
        (nama_wisata, harga, tiket, gambar, deskripsi, deskripsi2, deskripsi3, kategori, lokasi,
        gambar_deskripsi, gambar_deskripsi_2, gambar_deskrpsi_3, gambar_deskrpsi_4,
        gambar_deskrpsi_5, gambar_deskrpsi_6, gambar_deskrpsi_7)
        VALUES 
        ('$nama_wisata', '$harga', '$tiket', '$gambar', '$deskripsi', '$deskripsi2', '$deskripsi3', '$kategori', '$lokasi',
        '$gambar_deskripsi', '$gambar_deskripsi_2', '$gambar_deskrpsi_3', '$gambar_deskrpsi_4',
        '$gambar_deskrpsi_5', '$gambar_deskrpsi_6', '$gambar_deskrpsi_7')";

    if ($koneksi->query($query) === TRUE) {
        $_SESSION['pesan'] = ['type' => 'berhasil', 'isi' => 'Data Berhasil Dinputkan'];
    } else {
        $_SESSION['pesan'] = ['type' => 'gagal', 'isi' => 'Data Tidak Berhasil Dinputkan'];
    }

    header("location:admin.php");
    exit();
}
?>
