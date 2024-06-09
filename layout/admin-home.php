<?php

require '../config.php';

$query = "SELECT * FROM surat_tugas";
// Menjalankan Query
$query_run = mysqli_query($con, $query);
$result = NULL;
// Melakukan fetching array untuk menampilkan data dengan array asosiatif
while($zRow = mysqli_fetch_array($query_run))
{
    $row = array();
    $row['id'] = $zRow['id'];
    $row['nim'] = $zRow['nim'];
    $row['nama'] = $zRow['nama_mhs'];
    $row['jenis_surat'] = 'Surat Tugas KP';
    $row['jenis'] = 'ST';
    $row['tgl'] = $zRow['tgl_pengajuan'];
    $row['status'] = $zRow['status'];
    $result[] = $row;
}

// query data surat izin KP
$query = "SELECT * FROM surat_izin_kp";
// Menjalankan Query
$query_run = mysqli_query($con, $query);
// Melakukan fetching array untuk menampilkan data dengan array asosiatif
while($zRow = mysqli_fetch_array($query_run))
{
    $row = array();
    $row['id'] = $zRow['id'];
    $row['nim'] = $zRow['nim'];
    $row['nama'] = $zRow['nama_mhs'];
    $row['jenis_surat'] = 'Surat Izin KP';
    $row['jenis'] = 'SI';
    $row['tgl'] = $zRow['tgl_pengajuan'];
    $row['status'] = $zRow['status'];
    $result[] = $row;
}

// Query data surat ket mhs
$query = "SELECT * FROM surat_ket_mhs";
// Menjalankan Query
$query_run = mysqli_query($con, $query);
// Melakukan fetching array untuk menampilkan data dengan array asosiatif
while($zRow = mysqli_fetch_array($query_run))
{
    $row = array();
    $row['id'] = $zRow['id'];
    $row['nim'] = $zRow['nim'];
    $row['nama'] = $zRow['nama_mhs'];
    $row['jenis_surat'] = 'Surat Keterangan Mahasiswa';
    $row['jenis'] = 'SKM';
    $row['tgl'] = $zRow['tgl_pengajuan'];
    $row['status'] = $zRow['status'];
    $result[] = $row;
}
?>
<div class="content-wrapper">

    <!-- Main Content -->
    <section class="content mx-4 pt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pengajuan Surat Mahasiswa</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-3 ">
                        <?php if(!$result){?>
                        <center>Belum Ada Data Pengajuan Surat.</center>
                        <?php }else{ ?>
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Jenis Surat</th>
                                    <th>Diajukan Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach($result as $data) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td><?= $data['jenis_surat'] ?></td>
                                    <td><?= $data['tgl'] ?></td>
                                    <?php if($data['status'] == 'pending'){ ?>
                                    <td><span class="badge bg-warning px-2 py-2">Proses</span></td>
                                    <?php }else if($data['status'] == 'setuju') {  ?>
                                    <td><span class="badge bg-success px-2 py-2">Disetujui</span></td>
                                    <?php }else if($data['status'] == 'proses_ttd') {  ?>
                                    <td><span class="badge bg-warning px-2 py-2">Sedang Ditandatangani Rektor</span>
                                    </td>
                                    <?php }else { ?>
                                    <td><span class="badge bg-danger px-2 py-2">Ditolak</span></td>
                                    <?php } ?>
                                    <?php if($data['jenis'] == 'ST'){ ?>
                                    <td><button class="btn btn-primary" data-key="<?= $data['id']?>"
                                            onclick="detail_tugas(this)">Cek
                                            Detail</button></td>
                                    <?php }else if($data['jenis'] == 'SI'){ ?>
                                    <td><button class="btn btn-primary" data-key="<?= $data['id']?>"
                                            onclick="detail_izin(this)">Cek
                                            Detail</button></td>
                                    <?php }else{ ?>
                                    <td><button class="btn btn-primary" data-key="<?= $data['id']?>"
                                            onclick="detail_ket(this)">Cek
                                            Detail</button></td>
                                    <?php } ?>
                                </tr>
                                <?php 
                                $i++;
                            } ?>
                            </tbody>
                            <?php } ?>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->

<!-- Contoh Data Key -->
<!-- <select data - key="1" name="brand[1]"> ... </select> -->
<script>
function detail_tugas(obj) {
    var key = $(obj).data("key");
    $.ajax({
        type: "POST",
        url: "layout/detail-surat-tugas.php",
        data: {
            id: key
        },
        // contentType: false,
        success: function(data) {
            $('.main-content').html(data);
        }
    });
}

function detail_izin(obj) {
    var key = $(obj).data("key");
    $.ajax({
        type: "POST",
        url: "layout/detail-surat-izin.php",
        data: {
            id: key
        },
        // contentType: false,
        success: function(data) {
            $('.main-content').html(data);
        }
    });
}

function detail_ket(obj) {
    var key = $(obj).data("key");
    $.ajax({
        type: "POST",
        url: "layout/detail-surat-ket.php",
        data: {
            id: key
        },
        // contentType: false,
        success: function(data) {
            $('.main-content').html(data);
        }
    });
}
</script>