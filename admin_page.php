<?php
  session_start();
  if(!isset($_SESSION['isAdmin'])){
    echo "<script>window.location.href='admin_login.php';</script>"; //jika Admin belum login, diredirect ke halaman login
    exit;
  }
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/plugin/css/adminlte.min.css" />
</head>

<body class="layout-top-nav accent-lightblue" data-new-gr-c-s-check-loaded="14.1165.0" data-gr-ext-installed=""
    style="height: auto">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <div class="navbar-brand" style="cursor: pointer;" onclick="getPage(this,'home')">
                    <img src="assets/image/logo.png" alt="AdminLTE Logo" class="brand-image" style="opacity: 0.8" />
                    <span class="brand-text font-weight-light">ADMIN SILAT</span>
                </div>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <div class="nav-link" style="cursor: pointer;" onclick="getPage(this,'home')">Home</div>
                        </li>
                    </ul>
                    <div class="" onclick="logout()" style="cursor:pointer; margin: 0 0 0 auto">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout</span>
                    </div>
                </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="main-content"></div>
        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- Default to the left -->
            Copyright © 2024 SILAT. All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="assets/plugin/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugin/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/plugin/js/adminlte.min.js"></script>
    <!-- Sweet Alrert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                                    'admin_login.php';
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
            url: "layout/admin-home.php",
            success: function(response) {
                $('.main-content').html(response);
            }
        });
    })

    function getPage(obj, stmt) {
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
            $.ajax({
                type: "POST",
                url: "layout/admin-home.php",
                success: function(response) {
                    $('.main-content').html(response);
                }
            });
        }
    }
    </script>
</body>

</html>