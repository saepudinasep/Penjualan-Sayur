<?php
include "../../inc/koneksi.php";
session_start();

// Ambil data dari permintaan AJAX
$data = json_decode(file_get_contents("php://input"), true);

// Pastikan ada data yang dikirimkan
if (empty($data)) {
    echo "Error: No data received.";
    exit;
}

// Loop melalui data dan masukkan ke database
foreach ($data as $row) {
    $data1 = $row[0]; //No
    $data2 = $row[1]; //Produk
    $data3 = $row[2]; //Harga
    $data4 = $row[3]; //Jumlah
    $data5 = $row[4]; //Subtotal
    $data6 = $row[5]; //cart id
    $data7 = $row[6]; //Produk id
    $data8 = $row[7]; //Qty
    $harga_jual = $data3 + ($data3 * 0.2);


    $qprofile = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE username = '$_SESSION[username]'");
    $profile = mysqli_fetch_array($qprofile);

    // mengambil data produk
    $qProduct = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE nama_produk = '$data2'");
    $Product = mysqli_fetch_array($qProduct);

    // insert data detail transaksi
    $qDetailTransaksi = "INSERT INTO tb_detailtransaksi(transaksi_id, produk_id, jumlah_beli) VALUES('$_SESSION[id_transaksi]', '$Product[produk_id]', '$data4')";
    $DetailTransaksi = mysqli_query($koneksi, $qDetailTransaksi);
    if ($DetailTransaksi) {
        // insertProduk sesuai pelanggan_id
        $qInsertProduk = "INSERT INTO tb_produk(nama_produk, harga_beli, harga_jual, stok, penjual_id) VALUES('$data2', '$data3', '$harga_jual', '$data4', '$profile[user_id]')";
        $InsertProduk = mysqli_query($koneksi, $qInsertProduk);

        if ($InsertProduk) {
            $qProduk = "UPDATE tb_produk SET stok='$data8' WHERE produk_id='$data7'";
            $Produk = mysqli_query($koneksi, $qProduk);
            // update cart jenis=Buy
            $qUpdateCart = "UPDATE tb_cart SET jenis='buy' WHERE cart_id='$data6'";
            $UpdateCart = mysqli_query($koneksi, $qUpdateCart);
            // echo $qUpdateCart;
            // if ($UpdateCart) {
            //     echo "Success";
            // } else {
            //     error_log($UpdateCart);
            // }
        } else {
            error_log($InsertProduk);
        }
    } else {
        error_log($DetailTransaksi);
    }

    // echo $data1 . "<br>";
    // echo $Product['produk_id'] . "<br>";
    // echo $data3 . "<br>";
    // echo $data4 . "<br>";

    // $sql = "INSERT INTO your_table_name (column1, column2, column3) VALUES ('$data1', '$data2', '$data3')";

    // if ($conn->query($sql) !== true) {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
}
