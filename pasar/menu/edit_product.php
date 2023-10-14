<?php
// $produkId = $_GET['produkId'];
$pProduk = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE produk_id = '$_SESSION[id_product]'");
$eProduk = mysqli_fetch_array($pProduk);

?>

<!-- Form Student -->
<div class="card shadow mb-4 form-student">
    <div class="card-header text-center">
        <h1 class="h4 mb-0 text-gray-800">Form Student</h1>
    </div>
    <div class="card-body">
        <form method="POST" id="form_data" class="">
            <div class="row g-3">
                <div class="col-md-6 mb-4">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" value="<?= $eProduk['nama_produk']; ?>" name="nama">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <input type="text" class="form-control" id="harga_beli" value="<?= $eProduk['harga_beli']; ?>" name="harga_beli" oninput="formatRupiah('harga_beli')">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="harga_jual" class="form-label">Harga Jual</label>
                    <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="<?= $eProduk['harga_jual']; ?>" readonly>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="text" class="form-control" id="stok" value="<?= $eProduk['stok']; ?>" name="stok" readonly>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="desk" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control" id="desk" name="desk" rows="3"><?= $eProduk['deskripsi_produk']; ?></textarea>
                    <p class="text-small text-muted mt-2">Maksimum text <span id="text-address"> 150 karakter </span></p>
                </div>
            </div>
            <!-- button -->
            <div class="row justify-content-center">
                <div class="col-md-3 mb-2">
                    <!-- <form method="POST"> -->
                    <button type="submit" class="btn btn-success w-50" id="save" name="save">
                        <span class="icon text-white-50">
                            <i class="fas fa-save" id="save2"></i>
                        </span>
                        <b id="text-save">Save</b>
                    </button>
                    <!-- </form> -->
                </div>

                <div class="col-md-3 mb-2">
                    <a href="?menu=product" class="btn btn-danger w-50">
                        <span class="icon text-white-50">
                            <i class="fas fa-undo"></i>
                        </span>
                        Cancel
                    </a>
                </div>
            </div>
            <!--  -->
        </form>
    </div>


</div>
<!-- end of form student -->

<script>
    // Fungsi untuk memformat angka menjadi format Rupiah (Rp. 10.000)
    function formatRupiah(inputId) {
        var hargaInput = document.getElementById(inputId);
        var hargaValue = hargaInput.value.replace(/\./g, '').replace(/\D/g, '');
        var formattedValue = formatRupiahNumber(hargaValue);
        hargaInput.value = formattedValue;
        calculateHargaJual();
    }

    // // Fungsi untuk memformat angka menjadi format Rupiah (Rp. 10.000) dengan tanda titik sebagai pemisah ribuan
    function formatRupiahNumber(angka) {
        var rupiah = "Rp. " + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return rupiah;
    }


    // Fungsi untuk menghitung harga jual berdasarkan harga beli (tanpa markup)
    function calculateHargaJual() {
        var hargaBeli = parseInt(document.getElementById("harga_beli").value.replace(/\./g, '').replace(/\D/g, ''));
        // Anda dapat menambahkan formula lain di sini untuk menghitung harga jual berdasarkan strategi bisnis Anda
        // Contoh sederhana: harga jual adalah dua kali harga beli
        var hargaJual = hargaBeli + (hargaBeli * 0.2);
        document.getElementById("harga_jual").value = formatRupiahNumber(hargaJual.toString());
    }
</script>


<?php
// Fungsi untuk mengonversi format Rupiah (misal: Rp. 10.000) ke angka (misal: 10000)
function convertToNumber($priceString)
{
    return intval(str_replace(['Rp. ', '.'], '', $priceString));
}
if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    $harga_beli = convertToNumber($_POST['harga_beli']);
    $harga_jual = convertToNumber($_POST['harga_jual']);
    $stok = $_POST['stok'];
    $desk = $_POST['desk'];

    $product = mysqli_query($koneksi, "UPDATE tb_produk SET nama_produk='$nama', harga_beli='$harga_beli', harga_jual='$harga_jual', deskripsi_produk='$desk' WHERE produk_id='$_SESSION[id_product]'");
    // $product = mysqli_fetch_array($qproduct);

    // $qUser = "INSERT INTO tb_produk(nama_produk, harga, stok, deskripsi_produk, penjual_id) VALUES('$nama', '$harga', '$stok', '$desk', '$profile[user_id]')";
    // $User = mysqli_query($koneksi, $qUser);

    if ($product) {
?>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Produk Berhasil diEdit.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman selanjutnya
                    location.href = '?menu=product';
                }
            });
        </script>

<?php
    }
}
?>