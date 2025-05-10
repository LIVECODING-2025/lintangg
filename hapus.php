<?php
session_start();
// Koneksi ke database
include 'function.php'; // Pastikan file koneksi ada

// Mendapatkan ID dari URL
if (isset($_GET['hapus'])) {
    $id = $_GET['id'];

    // Ambil nama file gambar dari database berdasarkan ID produk
    $query_gambar = mysqli_query($koneksi, "SELECT gambar FROM data_wisataa WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query_gambar);
    
    if ($data) {
        $nama_gambar = $data['gambar']; // Misalnya kolom gambar di database adalah 'gambar'
        $path_gambar = "foto/" . $nama_gambar; // Folder tempat gambar disimpan

        // Hapus data produk dari database
        $query = mysqli_query($koneksi, "DELETE FROM data_wisataa WHERE id = '$id'");
        
        if ($query) {
            // Cek apakah file gambar ada di folder sebelum dihapus
            if (file_exists($path_gambar)) {
                // Hapus file gambar dari folder
                unlink($path_gambar);
            }
            $_SESSION['pesan'] = [
        
                'type' => 'berhasil',
    
                'isi' => 'Data Berhasil Dihapus'
            ];
            // Redirect ke halaman setelah produk dihapus
            header("Location:admin.php");
            exit();
        } else {
            $_SESSION['pesan'] = [
        
                'type' => 'gagal',
    
                'isi' => 'Data Tidak Berhasil Dihapus'
            ];
            // Redirect ke halaman setelah produk dihapus
            header("Location:admin.php");
        }
    } else {
        echo "Produk tidak ditemukan!";
    }
}
?>
