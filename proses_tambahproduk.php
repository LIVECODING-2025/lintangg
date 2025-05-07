<?php
session_start();
include("function.php");

if (isset($_POST["submit"])) {
    $nama_wisata = strtoupper($_POST["nama_wisata"]);
    $lokasi = $_POST["lokasi"];
    $harga = $_POST["harga"];
    $kategori = $_POST["kategori"];
    $deskripsi = $_POST["deskripsi"];

    // Penanganan upload gambar
    $target_dir = "gambar/";
    
    // Cek apakah folder 'gambar/' ada, jika tidak buat folder tersebut
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file benar-benar gambar
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Maaf, file gambar tidak terupload.";
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = basename($_FILES["gambar"]["name"]);

            $query = "INSERT INTO data_wisata (nama_wisata, harga, gambar, deskripsi, kategori, lokasi)
                      VALUES ('$nama_wisata', '$harga', '$gambar', '$deskripsi', '$kategori', '$lokasi')";

            if ($koneksi->query($query) === TRUE) {
                $_SESSION['pesan'] = [
                    'type' => 'berhasil',
                    'isi' => 'Data Berhasil Dinputkan'
                ];
                header("location:admin.php");
                exit();
            } else {
                $_SESSION['pesan'] = [
                    'type' => 'gagal',
                    'isi' => 'Data Tidak Berhasil Dinputkan'
                ];
                header("location:admin.php");
                exit();
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file gambar.";
        }
    }
}
?>
