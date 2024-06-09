<?php 
  require 'config.php';
  session_start();
  if(!isset($_SESSION['login'])){
    echo "<script>window.location.href='login.php';</script>"; //jika user belum login, diredirect ke halaman login
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SILAT</title>

    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets/plugin/css/OverlayScrollbars.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/plugin/css/adminlte.min.css" />

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="nav-link" style="cursor: pointer;" onclick="getPage(this,'home')">Home</div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light elevation-4 z-10 bg-white">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="assets/image/logo.png" alt="AdminLTE Logo" class="" style="opacity: 0.8" width="50" />
                <span class="px-2 brand-text font-weight-medium">SILAT</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-2 d-flex justify-content-center">
                    <div class="info">
                        <p class="d-block"><?=$_SESSION['nama'] ?></p>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-closed">
                            <a href class="nav-link parent" onclick="active(this)">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Pengajuan Surat
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <div class="nav-link" onclick="getPage(this, 'A')" style="cursor: pointer;">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Tugas KP</p>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <div class="nav-link" onclick="getPage(this, 'B')" style="cursor: pointer;">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Izin KP</p>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <div class="nav-link" onclick="getPage(this ,'C')" style="cursor: pointer;">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Ket Mahasiswa</p>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <div class="nav-link status" onclick="getPage(this, 'status')" style="cursor:pointer;">
                                <i class="nav-icon far fa-envelope"></i>
                                <p>Status Surat</p>
                            </div>
                        </li>
                        <li class="nav-item">
                            <hr>
                            <div class="nav-link" onclick="logout()" style="cursor:pointer;">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <p>Logout</p>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Main Content -->
        <!-- Content Wrapper. Contains page content -->
        <div class="main-content">

        </div>

        <!-- /.Content -->
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- Footer -->
    <?php include 'layout/footer.php' ?>
    <script>
    function active(obj) {
        $('.status').removeClass("active");
        $(obj).addClass("active");
    }

    function getPage(obj, stmt) {
        // Menonaktifkan Class Active pada navbar
        $('.nav-link').removeClass("active");
        // Routing pada navbar
        if (stmt == 'status') {
            $('.status').addClass("active");
            $.ajax({
                type: "POST",
                url: "layout/status.php",
                success: function(data) {
                    $('.main-content').html(data);
                }
            });
        } else if (stmt == 'A') {
            $('.parent').addClass("active");
            $(obj).addClass('active');
            $('.status').removeClass("active");
            $.ajax({
                type: "POST",
                url: "layout/surat-tugas.php",
                success: function(data) {
                    $('.main-content').html(data);
                }
            });
        } else if (stmt == 'B') {
            $('.parent').addClass("active");
            $(obj).addClass('active');
            $('.status').removeClass("active");
            $.ajax({
                type: "POST",
                url: "layout/surat-izin-kp.php",
                success: function(data) {
                    $('.main-content').html(data);
                }
            });
        } else if (stmt == 'C') {
            $('.parent').addClass("active");
            $(obj).addClass('active');
            $('.status').removeClass("active");
            $.ajax({
                type: "POST",
                url: "layout/surat-ket-mhs.php",
                success: function(data) {
                    $('.main-content').html(data);
                }
            });
        } else {
            $('.nav-link').removeClass("active");
            $.ajax({
                type: "POST",
                url: "layout/home.php",
                success: function(response) {
                    $('.main-content').html(response);
                }
            });
        }
    }

    function logout() {
        Swal.fire({
            title: "Anda Yakin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Tidak",
            confirmButtonText: "Ya!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'post',
                    url: 'ajax/logout.php',
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) { //status sukses
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "Berhasil Logout!",
                                showConfirmButton: true,
                            }).then((result) => {
                                top.location.href =
                                    'login.php';
                            });
                        } else if (res.status == 403) {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                showConfirmButton: true,
                            })
                        }
                    }
                })
            }
        });
    }

    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: "layout/home.php",
            success: function(response) {
                $('.main-content').html(response);
            }
        });
    })
    </script>
</body>

</html>