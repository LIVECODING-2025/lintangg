<?php
session_start();
include ("function.php");

// Fungsi untuk format rupiah
function rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Query untuk mengambil data dari tabel produk, mengurutkan berdasarkan id secara menurun
$data = mysqli_query($koneksi, 'SELECT * FROM data_wisataa ORDER BY id DESC');

// Mendapatkan pesan dari session
$pesan = isset($_SESSION['pesan']) ? $_SESSION['pesan'] : NULL;

// Menghapus pesan dari session setelah diambil
unset($_SESSION['pesan']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Piknik'in.Aja</title>

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

<div id="wrapper">
    <ul class="navbar-nav sidebar sidebar-dark accordion custom-sidebar" id="accordionSidebar" style="background-color: #013220;">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
            <div class="sidebar-brand-icon rotate-n-10">
                <img src="foto/logo admin real.png" alt="Logo" style="width: 160px; height: 30px; margin-top: 10px;">
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
                <span>Tambah Wisata</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="data_pemesanan.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Data Pemesanan</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="admin.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Daftar Wisata</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <ul class="navbar-nav ml-auto">
                    <?php
                    $query = $koneksi->query("SELECT * FROM data_userr");
                    while ($row = $query->fetch_assoc()):
                    ?>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" alt="Profile" style="width: 40px; height: 40px;">
                            </a>
                            <?php endwhile ?>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <!-- Link to trigger the logout modal -->
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                        </li>
                </ul>
            </nav>

            <div class="container-fluid">
                <h1 class="h3 mb-2 text-gray-800">Tabel</h1>
                <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #013220;">Data Wisata</h6>
                </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if ($pesan && $pesan['type'] === 'berhasil') { ?>
                                <div class="alert alert-success" role="alert">
                                    <?= $pesan['isi']; ?>
                                </div>
                            <?php } else if ($pesan && $pesan['type'] === 'gagal') { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $pesan['isi']; ?>
                                </div>
                            <?php } ?>
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Wisata</th>
                                    <th>Harga</th>
                                    <th>Gambar</th>
                                    <th>Deskripsi</th>
                                    <th>Lokasi</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($data)) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= $row['nama_wisata']; ?></td>
                                        <td><?= rupiah($row['harga']); ?></td> <!-- Harga diformat ke Rupiah -->
                                        <td class="text-center"><img src="foto/<?= $row['gambar']; ?>" alt=""
                                                                        width="100px"></td>
                                        <td><?= $row['deskripsi']; ?></td>
                                        <td><?= $row['lokasi']; ?></td>
                                        <td><?= $row['kategori']; ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <form action="form_edit.php" method="get"
                                                      onsubmit="return confirm('Apa Anda ingin mengedit data wisata ini?');">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    <button type="submit" name="edit" class="btn" style="background-color: #013220; color: white;">
                                                        <i class="ti ti-edit text-center"></i>
                                                    </button>
                                                </form>
                                                <form action="hapus.php" method="get"
                                                      onsubmit="return confirm('Apa Anda ingin menghapus data wisata ini?');">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    <button type="submit" name="hapus" class="btn" style="background-color: #690B22; color: white;">
                                                        <i class="ti ti-trash text-center"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="js/demo/datatables-demo.js"></script>

</body>
</html>
