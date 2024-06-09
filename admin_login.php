<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Title pada tab -->
    <title>SILAT | Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/plugin/css/bootstrap.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/login.css" />
    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="container vh-100">
        <div class="wrapper fadeInDown align-item-center">
            <div id="formContent">
                <!-- Tabs Titles -->

                <!-- Icon -->
                <div class="fadeIn first mt-4">
                    <img src="assets/image/logo.png" id="icon" alt="User Icon" />
                    <h5 class="text-primary-emphasis">ADMIN SILAT</h5>
                </div>

                <!-- Login Form -->
                <form id="login" method="post">
                    <input type="text" class="fadeIn second" name="username" placeholder="Username" />
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password" />
                    <input type="submit" class="fadeIn fourth mt-3" value="Log In" name="login" />
                </form>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="assets/plugin/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugin/js/bootstrap.bundle.min.js"></script>
    <!-- Sweet Alrert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Activate Sweet Alert -->
    <script>
    // Melakukan request secara asyncronus menggunakan AJAX Jquery ke ajax/login.php
    $(document).on('submit', '#login', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("login_admin", true);

        $.ajax({
            type: "POST",
            url: "ajax/admin-login.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                var res = jQuery.parseJSON(response);
                if (res.status == 200) { //status sukses
                    Swal.fire({
                        icon: "success",
                        title: "Sukses!",
                        text: "Login Sukses!",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        top.location.href =
                            'admin_page.php'; // redirect ke halaman index.php
                    });

                } else if (res.status == 404) { //status  gagal username atau password salah
                    Swal.fire({
                        icon: "error",
                        title: "Login Gagal!",
                        text: "Username atau Password Salah!",
                        showConfirmButton: true,
                    })
                }
            }
        });

    });
    </script>
</body>

</html>