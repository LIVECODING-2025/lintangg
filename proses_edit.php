<?php
session_start();
include("function.php");

if (isset($_POST['submit'])) {
    $id_produk = htmlspecialchars($_POST['id']);
    $nama_wisata = htmlspecialchars($_POST['nama_wisata']);
    $harga = htmlspecialchars($_POST['harga']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $deskripsi2 = htmlspecialchars($_POST['deskripsi2']);
    $deskripsi3 = htmlspecialchars($_POST['deskripsi3']);

    // Ambil data lama
    $query = mysqli_query($koneksi, "SELECT * FROM data_wisataa WHERE id = '$id_produk'");
    $data_lama = mysqli_fetch_assoc($query);

    if (!$data_lama) {
        $_SESSION['pesan'] = ['type' => 'gagal', 'isi' => 'Data tidak ditemukan.'];
        header("location:admin.php");
        exit();
    }

    // Siapkan direktori upload
    $target_dir = "foto/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Fungsi untuk mengelola upload file
    function handleUpload($input_name, $file_lama, $target_dir) {
        if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
            $nama_baru = basename($_FILES[$input_name]["name"]);
            $path_baru = $target_dir . $nama_baru;
            $check = getimagesize($_FILES[$input_name]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $path_baru)) {
                    if (!empty($file_lama) && file_exists($target_dir . $file_lama)) {
                        unlink($target_dir . $file_lama);
                    }
                    return $nama_baru;
                } else {
                    $_SESSION['pesan'] = ['type' => 'gagal', 'isi' => "Gagal upload $input_name."];
                    header("location:admin.php");
                    exit();
                }
            } else {
                $_SESSION['pesan'] = ['type' => 'gagal', 'isi' => "$input_name bukan file gambar yang valid."];
                header("location:admin.php");
                exit();
            }
        }
        return $file_lama;
    }

    // Tangani semua file upload
    $gambar_baru             = handleUpload('gambar', $data_lama['gambar'], $target_dir);
    $tiket_baru              = handleUpload('tiket', $data_lama['tiket'], $target_dir);
    $gambar_deskripsi_baru   = handleUpload('gambar_deskripsi', $data_lama['gambar_deskripsi'], $target_dir);
    $gambar_deskripsi_2_baru = handleUpload('gambar_deskripsi_2', $data_lama['gambar_deskripsi_2'], $target_dir);
    $gambar_deskrpsi_3_baru = handleUpload('gambar_deskrpsi_3', $data_lama['gambar_deskrpsi_3'], $target_dir);
    $gambar_deskrpsi_4_baru = handleUpload('gambar_deskrpsi_4', $data_lama['gambar_deskrpsi_4'], $target_dir);
    $gambar_deskrpsi_5_baru = handleUpload('gambar_deskrpsi_5', $data_lama['gambar_deskrpsi_5'], $target_dir);
    $gambar_deskrpsi_6_baru = handleUpload('gambar_deskrpsi_6', $data_lama['gambar_deskrpsi_6'], $target_dir);
    $gambar_deskrpsi_7_baru = handleUpload('gambar_deskrpsi_7', $data_lama['gambar_deskrpsi_7'], $target_dir);

    // Update data
    $update = mysqli_query($koneksi, "UPDATE data_wisataa SET 
        nama_wisata         = '$nama_wisata',
        harga               = '$harga',
        kategori            = '$kategori',
        lokasi              = '$lokasi',
        deskripsi           = '$deskripsi',
        deskripsi2          = '$deskripsi2',
        deskripsi3          = '$deskripsi3',
        tiket               = '$tiket_baru',
        gambar              = '$gambar_baru',
        gambar_deskripsi    = '$gambar_deskripsi_baru',
        gambar_deskripsi_2  = '$gambar_deskripsi_2_baru',
        gambar_deskrpsi_3  = '$gambar_deskrpsi_3_baru',
        gambar_deskrpsi_4  = '$gambar_deskrpsi_4_baru',
        gambar_deskrpsi_5  = '$gambar_deskrpsi_5_baru',
        gambar_deskrpsi_6  = '$gambar_deskrpsi_6_baru',
        gambar_deskrpsi_7  = '$gambar_deskrpsi_7_baru'
        WHERE id = '$id_produk'
    ");

    if ($update) {
        $_SESSION['pesan'] = ['type' => 'berhasil', 'isi' => 'Data berhasil diperbarui.'];
    } else {
        $_SESSION['pesan'] = ['type' => 'gagal', 'isi' => 'Gagal memperbarui data.'];
    }

    header("location:admin.php");
    exit();
}
?>
