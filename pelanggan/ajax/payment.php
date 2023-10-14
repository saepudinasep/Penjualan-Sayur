<?php
include "../../inc/koneksi.php";
session_start();

if (isset($_POST['pelanggan_id']) && isset($_POST['total_harga'])) {


    // $qprofile = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE username = '$_SESSION[username]'");
    // $profile = mysqli_fetch_array($qprofile);

    // $quser = mysqli_query($koneksi, "SELECT * FROM tb_toko WHERE user_id = '$profile[user_id]'");
    // $user = mysqli_fetch_array($quser);

    // # code...
    // // Step 3: Ambil data dari HTTP POST request
    $pelanggan_id = $_POST['pelanggan_id'];
    $total_harga = $_POST['total_harga'];

    // Step 4: Simpan data produk ke tabel keranjang di database
    $qTransaksi = "INSERT INTO tb_transaksi(pelanggan_id, total_harga) VALUES('$pelanggan_id', '$total_harga')";
    $Transaksi = mysqli_query($koneksi, $qTransaksi);

    if ($Transaksi) {
        $lastInsertID = $koneksi->insert_id;
        $_SESSION['id_transaksi'] = $lastInsertID;
        echo "Success";
    } else {
        error_log($Transaksi);
    }
    // echo "Success";
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
