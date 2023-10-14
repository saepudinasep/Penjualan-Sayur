<?php
session_start();
require "inc/koneksi.php";


// cek cookie
if (isset($_COOKIE['username']) && isset($_COOKIE['user_type'])) {
    $username = $_COOKIE['username'];
    $user_type = $_COOKIE['user_type'];

    // ambil user_type berdasarkan username
    $result = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE username = '$username'");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan user_type
    if ($user_type === $row['user_type']) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_type'] = $row['user_type'];
    }
}

if (isset($_SESSION["login"])) {
    if (@$_SESSION['username'] != "") {
        if ($_SESSION['user_type'] == "Toko") {
            header('location:toko/');
        } elseif ($_SESSION['user_type'] == "Pasar") {
            header('location:pasar/');
        } elseif ($_SESSION['user_type'] == "Pelanggan") {
            header('location:pelanggan/');
        }
    }
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

    <title>Aplikasi Penjualan - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="assets/img/portfolio/nanas.jpg" class="img-thumbnail" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter Username...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="flogin" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                    <?php
                                    if (isset($_POST['flogin'])) {
                                        $user = $_POST['username'];
                                        $pass = $_POST['password'];

                                        $qlogin = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE username='$user' AND password='$pass'");
                                        $cek = mysqli_num_rows($qlogin);
                                        $data = mysqli_fetch_array($qlogin);
                                        // cek apakah data ada
                                        if ($cek < 1) {
                                    ?>
                                            <hr>
                                            <div class="text-center text-danger">
                                                Maaf Username atau Password Tidak Cocok
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $("#username").addClass("is-invalid");
                                                    $("#password").addClass("is-invalid");
                                                });
                                            </script>
                                            <?php
                                        } else {
                                            // set session
                                            $_SESSION['login'] = true;
                                            $_SESSION['username'] = $data['username'];
                                            $_SESSION['user_type'] = $data['user_type'];

                                            // cek remember me
                                            if (isset($_POST['remember'])) {
                                                // buat cookie yang disimpan selama 1 minggu
                                                setcookie('username', $data['username'], time() + (30 * 24 * 60 * 60), "/");
                                                setcookie('user_type', $data['user_type'], time() + (30 * 24 * 60 * 60), "/");
                                            }

                                            if ($user == $data['username']) {
                                                if ($pass = $data['password']) {
                                                    if ($data['user_type'] == 'Toko') {
                                                        header('location:toko/');
                                                    } elseif ($data['user_type'] == 'Pasar') {
                                                        header('location:pasar/');
                                                    } elseif ($data['user_type'] == 'Pelanggan') {
                                                        header('location:pelanggan/');
                                                    }
                                                } else {
                                            ?>
                                                    <hr>
                                                    <div class="text-center text-danger">
                                                        Maaf Password Tidak Cocok
                                                    </div>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $("#username").addClass("is-valid");
                                                            $("#password").addClass("is-invalid");
                                                        });
                                                    </script>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <hr>
                                                <div class="text-center text-danger">
                                                    Maaf Username Tidak Cocok
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $("#username").addClass("is-invalid");
                                                        $("#password").addClass("is-valid");
                                                    });
                                                </script>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <hr>
                                    <!-- <div class="text-center">
                                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                                    </div> -->
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

</body>

</html>