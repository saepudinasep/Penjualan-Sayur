<?php

$qjumlah = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE penjual_id='$profile[user_id]'");
$jumlah = mysqli_num_rows($qjumlah);

?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Product</h1>
</div>

<!-- <a href="?menu=add_product" class="btn btn-sm btn-primary mb-2">
    <span class="icon text-white-50">
        <i class="fas fa-plus-circle"></i>
    </span>
    Add Data
</a> -->
<a href="?menu=product" class="btn btn-sm btn-secondary mb-2">
    <span class="icon text-white-50">
        <i class="fas fa-sync"></i>
    </span>
    Refresh
</a>

<div class="row justify-content-between">

    <div class="col-lg-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Data Product
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $jumlah; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fab fa-apple fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <!-- Search -->
        <form method="POST">
            <div class="input-group">
                <input type="text" name="inputan" class="form-control border-primary small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button name="cari" class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive mb-4">
            <table class="table table-bordered text-center small" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // pagging
                    $batas = 10;
                    $hal = ceil($jumlah / $batas);
                    $page = (isset($_GET['hal'])) ? $_GET['hal'] : 1;
                    $posisi = ($page - 1) * $batas;
                    // end pagging
                    $no = 1 + $posisi;
                    // $inputan = $_POST['inputan'];
                    if (isset($_POST['cari'])) {
                        if ($_POST['inputan'] == "") {
                            $q = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE penjual_id='$profile[user_id]' limit $posisi, $batas");
                        } elseif ($_POST['inputan'] !== "") {
                            $q = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE nama_produk LIKE '%$_POST[inputan]%' AND penjual_id='$profile[user_id]' limit $posisi, $batas");
                        }
                    } else {
                        $q = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE penjual_id='$profile[user_id]' limit $posisi, $batas");
                    }
                    $cek = mysqli_num_rows($q);

                    if ($cek < 1) {
                    ?>
                        <tr>
                            <td colspan="7">
                                <center>
                                    Data tidak Tersedia !
                                    <a href="" class="btn btn-sm btn-success"><i class="fas fa-sync-alt"></i></a>
                                </center>
                            </td>
                        </tr>
                        <?php
                    } else {
                        while ($data = mysqli_fetch_array($q)) {
                        ?>
                            <tr class="clickable-row">
                                <td><?= $no++; ?></td>
                                <td><?= $data['nama_produk']; ?></td>
                                <td><?= $data['deskripsi_produk']; ?></td>
                                <td>RP. <?= number_format($data['harga_beli'], 0, ",", "."); ?></td>
                                <td>RP. <?= number_format($data['harga_jual'], 0, ",", "."); ?></td>
                                <td><?= $data['stok']; ?></td>
                                <td>
                                    <a href="?menu=edit_product&productId=<?= $data['produk_id']; ?>" class="btn btn-sm btn-success">
                                        <span class="icon text-white-75">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a>
                                    <!-- <button type="button" class="btn btn-sm btn-danger del" id="del" data-id="<?= $data['produk_id']; ?>">
                                        <span class="icon text-white-75">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </button> -->
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                for ($i = 1; $i <= $hal; $i++) {
                ?>
                    <li class="page-item <?php if ($page == $i) {
                                                echo "active";
                                            } ?>"><a class="page-link" href="?menu=product&hal=<?= $i; ?>"><?= $i; ?></a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
        <!-- end of pagination -->
    </div>
</div>


<script>
    $(document).ready(function() {

        $(".del").click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Semua yang berhubungan dengan produk ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var id = $(this).data('id');
                    $.ajax({
                        url: '?menu=delete_product',
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
                                    location.href = "?menu=product";
                                }
                            })
                        }
                    });

                }
            })
        });
    });
</script>