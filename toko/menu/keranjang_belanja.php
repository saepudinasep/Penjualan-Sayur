<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Keranjang Belanja</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive mb-4">
            <table id="itemTable" class="table table-bordered text-center small" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM tb_cart c JOIN tb_produk p ON c.produk_id=p.produk_id WHERE toko_id='$user[toko_id]' AND jenis='nBuy'");
                    $no = 1;
                    $cek = mysqli_num_rows($q);
                    if ($cek < 1) {
                    ?>
                        <tr>
                            <td colspan="6">
                                <center>
                                    Tidak ada barang di Keranjang !
                                    <a href="?menu=market" class="btn btn-sm btn-success">Silahkan Pergi ke Market.</a>
                                </center>
                            </td>
                        </tr>
                        <?php
                    } else {
                        while ($data = mysqli_fetch_array($q)) {
                        ?>
                            <tr class="clickable-row">
                                <td>
                                    <?= $no++; ?>
                                    <input type="text" value="<?= $data['cart_id']; ?>" class="cart" hidden>
                                </td>
                                <td>
                                    <input type="text" value="<?= $data['produk_id']; ?>" class="produk_id" hidden>
                                    <input type="text" value="<?= $data['stok']; ?>" class="stok" hidden>
                                    <?= $data['nama_produk']; ?>
                                </td>
                                <td>
                                    <input type="text" class="form-control harga" name="harga" value="<?= $data['harga_jual']; ?>" id="harga" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control jumlah" name="jumlah" id="jumlah" value="<?= $data['qty']; ?>" min="0">
                                </td>
                                <td class="itemSubtotal">
                                    Total
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="?menu=keranjang_belanja" class="btn btn-info">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        <button class="btn btn-danger del" id="del" data-id="<?= $data['cart_id']; ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <?php
            if ($cek == 0) {
            } else {
            ?>
                <div class="row">
                    <div class="col-2 offset-8">
                        <p id="grandTotal">Total Keseluruhan: Rp. 30,000</p>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success" id="checkout">Checkout</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var quantityInputs = document.querySelectorAll(".jumlah");
        // var priceInputs = document.querySelectorAll(".harga");
        const insertButton = document.getElementById("checkout");
        const dataTable = document.getElementById("itemTable");

        insertButton.addEventListener("click", function() {
            var rows_total = document.querySelectorAll("#itemTable tbody tr");

            var total_harga = 0;

            rows_total.forEach(function(row) {
                var total = parseFloat(row.querySelector(".jumlah").value) * parseFloat(row.querySelector(".harga").value);

                total_harga += total;
            });

            var toko_id = "<?= $user['toko_id']; ?>";
            // var total_harga = $("#grandTotal").val();

            // console.log(toko_id +
            //     ' dan ' + total_harga);

            $.ajax({
                url: "ajax/payment.php",
                type: "POST",
                data: {
                    toko_id: toko_id,
                    total_harga: total_harga
                },
                success: function(data) {
                    // console.log(data);
                    if (data === "Success") {
                        // Ambil data dari tabel
                        const rows = dataTable.querySelectorAll("tr");
                        const detailsToInsert = [];
                        // const qty = 0;
                        for (let i = 1; i < rows.length; i++) { // Mulai dari baris kedua
                            const cells = rows[i].getElementsByTagName("td");
                            const harga = rows[i].querySelector(".harga"); // Mengambil input teks
                            const jumlah = rows[i].querySelector(".jumlah"); // Mengambil input teks
                            const produk_id = rows[i].querySelector(".produk_id"); // Mengambil input teks
                            const stok = rows[i].querySelector(".stok"); // Mengambil input teks
                            const cart = rows[i].querySelector(".cart"); // Mengambil input teks
                            const rowData = [];
                            // for (let j = 0; j < cells.length; j++) {
                            //     rowData.push(cells[j].innerText);
                            // }
                            // Menambahkan nilai input teks ke dalam rowData
                            rowData.push(cells[0].innerText); // No 0
                            rowData.push(cells[1].innerText); // Produk 1
                            rowData.push(harga.value); // Harga 2
                            rowData.push(jumlah.value); // Jumlah 3
                            rowData.push(cells[4].innerText); // Subtotal 4
                            rowData.push(cart.value); // Cart Id 5
                            rowData.push(produk_id.value); // Produk Id 6
                            const qty = stok.value - jumlah.value;
                            rowData.push(qty); // Qty 7
                            detailsToInsert.push(rowData);
                        }

                        // console.log(detailsToInsert);

                        // console.log(detailsToInsert);
                        // Kirim data ke server melalui AJAX
                        fetch("ajax/detail_payment.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify(detailsToInsert),
                                // data: detailsToInsert
                            })
                            .then(response => response.text())
                            .then(data => {
                                // terakhir tampilkan ini
                                // console.log("Data inserted:", data);
                                // if (data === "Success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Produk berhasil diCheckout.',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Redirect ke halaman selanjutnya
                                        location.href = '?menu=keranjang_belanja';
                                    } else {
                                        window.location.reload();
                                    }
                                });
                                // } else {
                                //     console.log("Gagal" + data);
                                // }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                            });
                    } else {
                        console.log("Gagal Payment");
                    }
                    // console.log('Response from server: ' + response);
                    // This function will be called if the request is successful
                    // $('#response').html('Response from server: ' + response);
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Berhasil!',
                    //     text: 'Produk berhasil dimasukkan ke keranjang.',
                    //     confirmButtonText: 'OK'
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         // Redirect ke halaman selanjutnya
                    //         location.href = '?menu=keranjang_belanja';
                    //     } else {
                    //         window.location.reload();
                    //     }
                    // });
                },
                error: function(xhr, status, error) {
                    // This function will be called if the request encounters an error
                    console.error('AJAX request error:', error);
                }
            });
        });



        quantityInputs.forEach(function(input) {
            input.addEventListener("input", function() {
                updateRowTotal(input.closest("tr"));
            });


        });

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount).replace(/\D00$/, '');
        }

        function updateRowTotal(row) {
            var quantity = parseFloat(row.querySelector(".jumlah").value);
            var price = parseFloat(row.querySelector(".harga").value);
            var total = quantity * price;

            row.querySelector(".itemSubtotal").textContent = formatCurrency(total);

            calculateTableTotal();
        }

        function calculateTableTotal() {
            var rows = document.querySelectorAll("#itemTable tbody tr");

            var grandTotal = 0;

            rows.forEach(function(row) {
                var total = parseFloat(row.querySelector(".jumlah").value) * parseFloat(row.querySelector(".harga").value);

                grandTotal += total;
            });

            document.getElementById('grandTotal').textContent = 'Total Keseluruhan: ' + formatCurrency(grandTotal);
        }

        // priceInputs.forEach(function(input) {
        //     input.addEventListener("input", function() {
        //         updateRowTotal(input.closest("tr"));
        //     });
        // });
        // calculateTableTotal(); // Menghitung total saat halaman dimuat
        var rows = document.querySelectorAll("#itemTable tbody tr");

        rows.forEach(function(row) {
            updateRowTotal(row);
        });
        calculateTableTotal(); // Hitung total keseluruhan saat halaman dimuat
    });





    $(".del").click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Produk ini akan dihapus dari daftar Keranjang Belanja Anda!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                var id = $(this).data('id');
                $.ajax({
                    url: '?menu=delete_belanja',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Berhasil Di Delete',
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                location.href = "?menu=keranjang_belanja";
                            }
                        })
                    }
                });

            }
        })
    });
</script>