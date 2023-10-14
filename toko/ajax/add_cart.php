<?php
include "../../inc/koneksi.php";
session_start();

if (isset($_POST['produk_id']) && isset($_POST['jumlah'])) {


    $qprofile = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE username = '$_SESSION[username]'");
    $profile = mysqli_fetch_array($qprofile);

    $quser = mysqli_query($koneksi, "SELECT * FROM tb_toko WHERE user_id = '$profile[user_id]'");
    $user = mysqli_fetch_array($quser);

    # code...
    // Step 3: Ambil data dari HTTP POST request
    $produk_id = $_POST['produk_id'];
    $jumlah = $_POST['jumlah'];

    // Step 4: Simpan data produk ke tabel keranjang di database
    $qCart = "INSERT INTO tb_cart(toko_id, produk_id, qty, jenis) VALUES('$user[toko_id]', '$produk_id', '$jumlah', 'nBuy')";
    $Cart = mysqli_query($koneksi, $qCart);

    if ($Cart) {
        echo "berhasil";
    } else {
        error_log($Cart);
    }
} else {
    // If the request is not a POST request or data is not present, handle the error
    http_response_code(400);
    echo 'Bad Request';
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
//     $inputData = $_POST['data'];

//     // Process the data as needed, e.g., save it to a database, perform calculations, etc.

//     // Return a response (e.g., you can echo a message)
//     echo 'Data received successfully!';
// } else {
//     // If the request is not a POST request or data is not present, handle the error
//     http_response_code(400);
//     echo 'Bad Request';
// }
