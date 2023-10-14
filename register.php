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
    if ($user_type === hash('sha256', $row['role'])) {
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

    <title>Aplikasi Penjualan - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block">
                        <img src="assets/img/portfolio/nanas.jpg" class="img-thumbnail" alt="">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="userType">User Type:</label>
                                        <select id="userType" name="userType" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Pelanggan">Pelanggan</option>
                                            <option value="Pasar">Pasar</option>
                                            <option value="Toko">Toko</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama Lengkap">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="password_confirm" name="password_confirm" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <button type="submit" name="register" class="btn btn-primary btn-user btn-block">Register Account</button>
                            </form>
                            <?php
                            if (isset($_POST['register'])) {
                                $userType = $_POST['userType'];
                                $nama = $_POST['nama'];
                                $username = $_POST['username'];
                                $password = $_POST['password'];
                                $password_confirm = $_POST['password_confirm'];


                                if ($password == $password_confirm) {

                                    // Pengecekan apakah username sudah ada di database
                                    $checkQuery = "SELECT * FROM tb_users WHERE username = '$username'";
                                    $result = mysqli_query($koneksi, $checkQuery);

                                    if ($result->num_rows > 0) {
                                        echo "Username sudah digunakan. Silakan gunakan username lain.";
                                    } else {


                                        // insert user
                                        $q = "INSERT INTO tb_users(username, password, user_type) VALUES('$username', '$password', '$userType')";
                                        $insertUser = mysqli_query($koneksi, $q);

                                        // select user_id
                                        $query = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE username='$username'");
                                        $user = mysqli_fetch_array($query);
                                        $user_id = $user['user_id'];
                                        // set session
                                        $_SESSION['login'] = true;
                                        $_SESSION['username'] = $user['username'];
                                        $_SESSION['user_type'] = $user['user_type'];


                                        if ($insertUser) {

                                            // Jika username belum ada, masukkan data ke dalam database berdasarkan usertype
                                            switch ($userType) {
                                                case "Pelanggan":
                                                    $insertQuery = "INSERT INTO tb_pelanggan (user_id, nama_pelanggan) VALUES ('$user_id', '$nama')";
                                                    break;
                                                case "Pasar":
                                                    $insertQuery = "INSERT INTO tb_pasar (user_id, nama_pasar) VALUES ('$user_id', '$nama')";
                                                    break;
                                                case "Toko":
                                                    $insertQuery = "INSERT INTO tb_toko (user_id, nama_toko) VALUES ('$user_id', '$nama')";
                                                    break;
                                                default:
                                                    echo "User type tidak valid";
                                                    exit;
                                            }

                                            // insert pasar, toko, pelanggan
                                            $insert = mysqli_query($koneksi, $insertQuery);

                                            if ($insert) {
                                                if ($user['user_type'] == 'Toko') {
                                                    header('location:toko/');
                                                } elseif ($user['user_type'] == 'Pasar') {
                                                    header('location:pasar/');
                                                } elseif ($user['user_type'] == 'Pelanggan') {
                                                    header('location:pelanggan/');
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    echo "Password Harus sama!";
                                }
                            }
                            ?>
                            <hr>
                            <!-- <div class="text-center">
                                <a class="small" href="forgot-password.php">Forgot Password?</a>
                            </div> -->
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
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

    <script>
        $(document).ready(function() {
            // Fungsi untuk menutup collapse lain ketika collapse dibuka
            $('.btn').click(function() {
                var target = $(this).attr('data-target');
                $('.collapse').not(target).collapse('hide');
            });
        });
    </script>

</body>

</html>