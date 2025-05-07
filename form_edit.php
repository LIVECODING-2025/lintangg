<?php
include ("function.php");

if(isset($_GET['edit'])){
$id = $_GET['id'];


$wisata = mysqli_query($koneksi,"SELECT * FROM data_wisata where id = '$id'");

if($result = mysqli_fetch_assoc($wisata)){
    $id = $result['id'];
    $nama_wisata = $result['nama_wisata'];
    $harga = $result ['harga'];
    $gambar = $result ['gambar'];
    $deskripsi = $result ['deskripsi'];
    $lokasi = $result ['lokasi'];
    $kategori = $result ['kategori'];
};


}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Piknik'in.Aja Admin</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css admin/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion custom-sidebar" id="accordionSidebar" style="background-color: #013220;">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
            <div class="sidebar-brand-icon rotate-n-10">
                <img src="Frame 23.png" alt="Logo" style="width: 150px; height: 100px;">
            </div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- Heading -->
        <div class="sidebar-heading">
               Tambahan
        </div>
        <li class="nav-item">
            <a class="nav-link" href="form_tambahproduk.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Tambah Produk</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="admin.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Tabel</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
    </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

                <!-- Topbar -->

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <h1 class="h3 mb-2 text-gray-800">Tabel</h1><br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold" style="color: #013220;">Form</h6>
    </div>
    <div class="card-body">
        <form action="proses_edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id;?>">
            <div class="row mb-3">
                <label for="nama_wisata" class="form-label col-sm-2">Nama Wisata</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" value="<?= $nama_wisata;?>" autofocus>
                </div>
            </div>
            <div class="row mb-3">
                <label for="harga" class="form-label col-sm-2">harga</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="harga" name="harga" value="<?= $harga;?>" autofocus>
                </div>
            </div>
            <div class="row mb-3">
                <label for="gambar" class="form-label col-sm-2">Gambar</label>
                <div class="col-sm-10">
                <input type="file" class="form-control" id="gambar" name="gambar">
                <!-- Tampilkan nama gambar yang sudah ada -->
                <?php if (!empty($gambar)): ?>
                    <p>Gambar saat ini: <strong><?= $gambar ?></strong></p>
                    <img src="foto/<?= $gambar ?>" alt="Preview Gambar" style="max-width: 200px;">
                <?php endif; ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="deskripsi" class="form-label col-sm-2">Deskripsi</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= $deskripsi?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="lokasi" class="form-label col-sm-2">Lokasi</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?= $lokasi;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="kategori" class="form-label col-sm-2">Kategori</label>
                <div class="col-sm-10">
                    <select class="form-control" id="kategori" name="kategori">
                    <option value="">Pilih Kategori</option>
                    <option <?= $kategori  === 'Gunung' ? 'selected' : ''; ?> value="Gunung">Gunung</option>
                    <option <?= $kategori  === 'AirTerjun' ? 'selected' : ''; ?> value="AirTerjun">Air Terjun</option>
                    <option <?= $kategori  === 'Pantai' ? 'selected' : ''; ?> value="Pantai">Pantai</option>
            </select>
        </div>
    </div>
            <button type="submit" class="btn" style="background-color: #013220; color: white;" name="submit">Ubah</button>
        </form>
    </div>
</div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin Ingin Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Keluar" di bawah jika Anda siap mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>
</html>