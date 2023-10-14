<!-- Form Product -->
<div class="card shadow mb-4 form-student">
    <div class="card-header text-center">
        <h1 class="h4 mb-0 text-gray-800">Form Product</h1>
    </div>
    <div class="card-body">
        <form method="POST" id="form_data" class="" onsubmit="return validateForm()">
            <div class="row g-3">
                <div class="col-md-6 mb-4">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Produk">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <input type="text" class="form-control" id="harga_beli" name="harga_beli" oninput="formatRupiah('harga_beli')" placeholder="Rp. 10.000">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="harga_jual" class="form-label">Harga Jual</label>
                    <input type="text" class="form-control" id="harga_jual" name="harga_jual" readonly>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" placeholder="10" min="0">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="desk" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control" id="desk" name="desk" rows="3"></textarea>
                    <p class="text-small text-muted mt-2">Maksimum text <span id="text-address"> 150 karakter </span></p>
                </div>
            </div>

            <script>
                // Fungsi untuk memformat angka menjadi format Rupiah (Rp. 10.000)
                function formatRupiah(inputId) {
                    var hargaInput = document.getElementById(inputId);
                    var hargaValue = hargaInput.value.replace(/\./g, '').replace(/\D/g, '');
                    var formattedValue = formatRupiahNumber(hargaValue);
                    hargaInput.value = formattedValue;
                    calculateHargaJual();
                }

                // Fungsi untuk memformat angka menjadi format Rupiah (Rp. 10.000) dengan tanda titik sebagai pemisah ribuan
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


                // Fungsi untuk memeriksa bahwa semua input terisi dengan benar sebelum mengirimkan data ke server
                function validateForm() {
                    var namaProduk = document.getElementById("nama").value;
                    var hargaBeli = document.getElementById("harga_beli").value;
                    var hargaJual = document.getElementById("harga_jual").value;

                    // Contoh validasi sederhana: pastikan nama produk tidak kosong
                    if (namaProduk.trim() === "") {
                        alert("Harap isi nama produk!");
                        return false;
                    }

                    // Cek apakah nama produk sudah ada di database (Anda harus mengganti bagian ini dengan metode sesuai dengan database Anda)
                    // Contoh sederhana: cek melalui array produk
                    var produkList = [
                        <?php
                        $q = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE penjual_id='$profile[user_id]'");
                        while ($data = mysqli_fetch_array($q)) {
                            echo "'$data[nama_produk]',";
                        }
                        ?>
                    ];

                    if (produkList.includes(namaProduk)) {
                        var konfirmasi = confirm("Nama produk sudah ada di database. Apakah Anda ingin menambahkan stok ke produk yang sudah ada?");
                        if (!konfirmasi) {
                            return false;
                        }
                        // Swal.fire({
                        //     title: 'Nama produk sudah ada di database.',
                        //     text: 'Apakah Anda ingin menambahkan stok ke produk yang sudah ada?',
                        //     icon: 'question',
                        //     showCancelButton: true,
                        //     confirmButtonText: 'Ya',
                        //     cancelButtonText: 'Tidak',
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         // Tindakan jika tombol 'Ya' ditekan
                        //         // Lanjutkan dengan tindakan yang diinginkan di sini
                        //     } else if (result.dismiss === Swal.DismissReason.cancel) {
                        //         // Tindakan jika tombol 'Tidak' ditekan atau peringatan ditutup
                        //         // Lanjutkan dengan tindakan yang diinginkan di sini
                        //     }
                        // });
                    }

                    return true;
                }

                // console.log(produkList);
            </script>
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

            $qproduct = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE nama_produk='$nama' AND penjual_id='$profile[user_id]'");
            $product = mysqli_fetch_array($qproduct);

            if ($nama == $product['nama_produk']) {
        ?>
                <?php
                // $qIdProduct = mysqli_query($koneksi, "SELECT produk_id FROM tb_produk WHERE nama_produk='$nama'");
                // $IdProduct = mysqli_fetch_array($qIdProduct);
                $stok = $stok + $product['stok'];
                // update stok produk jika nama sudah ada di database
                $updateStokProduk = mysqli_query(
                    $koneksi,
                    "UPDATE `tb_produk` SET
                    `stok`='" . mysqli_real_escape_string(
                        $koneksi,
                        $stok
                    ) . "' WHERE produk_id='$product[produk_id]'"
                );

                if ($updateStokProduk) {
                ?>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Stok Berhasil diTambahkan.',
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
            } else {
                $qUser = "INSERT INTO tb_produk(nama_produk, harga_beli, harga_jual, stok, deskripsi_produk, penjual_id) VALUES('$nama', '$harga_beli', '$harga_jual', '$stok', '$desk', '$profile[user_id]')";
                $User = mysqli_query($koneksi, $qUser);

                if ($User) {
                ?>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Produk Berhasil diTambahkan.',
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
        }
        ?>



    </div>


</div>
<!-- end of form student -->