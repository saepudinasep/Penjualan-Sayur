<?php
session_start();
// $_SESSION = [];
// session_unset();
session_destroy();
// Menghapus cookie dengan nama 'nama_cookie'
setcookie('username', '', time() - 3600, '/');


// setcookie('username', '', time() - 3600);
setcookie('user_type', '', time() - 3600, '/');

header('location:../index.php');
// exit;
