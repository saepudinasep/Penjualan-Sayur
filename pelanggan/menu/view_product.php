<?php
$qPelanggan = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan WHERE pelanggan_id='$_SESSION[id_toko]'");
$Pelanggan = mysqli_fetch_array($qPelanggan);


$qProduk = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE produk_id='$_SESSION[id_product]'");
$produk = mysqli_fetch_array($qProduk);

?>

<!-- Product section-->
<!-- <section class="py-5"> -->
<div class="container px-4 px-lg-5 my-5">
    <div class="row gx-4 gx-lg-5 align-items-center">
        <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg" alt="..." /></div>
        <div class="col-md-6">
            <!-- <div class="small mb-1">SKU: BST-498</div> -->
            <input type="text" name="" id="produk_id" value="<?= $produk['produk_id'] ?>" hidden>
            <h1 class="display-5 fw-bolder"><?= $produk['nama_produk']; ?></h1>
            <div class="fs-5 mb-5">
                <span class="text-decoration-line-through">RP. <?= number_format($produk['harga_jual'], 0, ",", "."); ?></span>
                <!-- <span>$40.00</span> -->
            </div>
            <p class="lead">
                <?= $produk['deskripsi_produk']; ?>
            </p>
            <div class="d-flex">
                <input class="form-control text-center me-3" id="jumlah" type="num" value="1" min="1" style="max-width: 3rem; margin-right:5px" />
                <button class="btn btn-outline-dark flex-shrink-0" id="add_cart">
                    <i class="bi-cart-fill me-1"></i>
                    Add Cart
                </button>
            </div>
        </div>
    </div>
</div>
<div id="response"></div>
<script>
    $(document).ready(function() {
        $("#add_cart").click(function() {
            var produk_id = $("#produk_id").val();
            var jumlah = $("#jumlah").val();

            console.log(produk_id);
            console.log(jumlah);

            $.ajax({
                url: "ajax/add_cart.php",
                type: "POST",
                data: {
                    produk_id: produk_id,
                    jumlah: jumlah
                },
                success: function(response) {
                    // This function will be called if the request is successful
                    // $('#response').html('Response from server: ' + response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk berhasil dimasukkan ke keranjang.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect ke halaman selanjutnya
                            location.href = '?menu=keranjang_belanja';
                        } else {
                            window.location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // This function will be called if the request encounters an error
                    console.error('AJAX request error:', error);
                }
            });

        });
    });
</script>
<!-- </section> -->
<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            $q = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE penjual_id='$Pelanggan[user_id]' AND produk_id!='$_SESSION[id_product]'");
            while ($data = mysqli_fetch_array($q)) {
            ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?= $data['nama_produk']; ?></h5>
                                <!-- Product price-->
                                RP. <?= number_format($data['harga_jual'], 0, ",", "."); ?>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="?menu=view_product&productId=<?= $data['produk_id']; ?>">Lihat Produk</a></div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>