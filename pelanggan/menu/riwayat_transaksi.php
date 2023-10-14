<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaksi Masuk</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
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
                        <th>Tanggal</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT *
                    FROM tb_transaksi t
                    JOIN tb_detailtransaksi dp ON t.transaksi_id = dp.transaksi_id
                    JOIN tb_produk p ON dp.produk_id = p.produk_id
                    WHERE t.pelanggan_id='$user[pelanggan_id]'");
                    $no = 1;
                    $cek = mysqli_num_rows($q);
                    if ($cek < 1) {
                    ?>
                        <tr>
                            <td colspan="6">
                                <center>
                                    Tidak ada Transaksi !
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
                                </td>
                                <td><?= $data['nama_produk']; ?></td>
                                <td>
                                    Rp. <?= number_format($data['harga_jual'], 0, ",", "."); ?>
                                </td>
                                <td>
                                    <?= $data['jumlah_beli']; ?>
                                </td>
                                <td class="itemSubtotal">
                                    <?php
                                    echo date("Y-m-d", strtotime($data['tanggal_transaksi']));
                                    ?>
                                </td>
                                <!-- <td>
                                    <div class="btn-group">
                                        <a href="?menu=keranjang_belanja" class="btn btn-info">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        <button class="btn btn-danger del" id="del" data-id="<?= $data['cart_id']; ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td> -->
                            </tr>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>