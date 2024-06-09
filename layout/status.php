<?php 
    require '../config.php';
    session_start();
    // Mengambil data nim dari session
    $nim = $_SESSION['nim'];

    // Variabel untuk pengecekan total jumlah data
    $all_num_rows = 0;
    // Variable untuk menampung semua data
    $result = [];
    
    // query data surat tugas
    $query = "SELECT * FROM surat_tugas where nim ='$nim'";
    // Menjalankan Query
    $query_run = mysqli_query($con, $query);
    // Pengecekan apakah data ada atau tidak
    if(mysqli_num_rows($query_run) > 0){        
        // Melakukan fetching array untuk menampilkan data dengan array asosiatif
        while($zRow = mysqli_fetch_array($query_run))
        {
            $row = array();
            $row['jenis'] = 'Surat Tugas KP';
            $row['tgl'] = $zRow['tgl_pengajuan'];
            $row['status'] = $zRow['status'];
            $row['berkas'] = $zRow['surat_jadi'];
            $result[] = $row;
            $all_num_rows++;
        }
    }

    // query data surat izin KP
    $query = "SELECT * FROM surat_izin_kp where nim ='$nim'";
    // Menjalankan Query
    $query_run = mysqli_query($con, $query);
    // Pengecekan apakah data ada atau tidak
    if(mysqli_num_rows($query_run) > 0){  
        // Melakukan fetching array untuk menampilkan data dengan array asosiatif
        while($zRow = mysqli_fetch_array($query_run))
        {
            $row = array();
            $row['jenis'] = 'Surat Izin KP';
            $row['tgl'] = $zRow['tgl_pengajuan'];
            $row['status'] = $zRow['status'];
            $row['berkas'] = $zRow['surat_jadi'];
            $result[] = $row;
            $all_num_rows++;
        }
    }

    // Query data surat ket mhs
    $query = "SELECT * FROM surat_ket_mhs where nim ='$nim'";
    // Menjalankan Query
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) > 0){ 
        // Melakukan fetching array untuk menampilkan data dengan array asosiatif
        while($zRow = mysqli_fetch_array($query_run))
        {
            $row = array();
            $row['jenis'] = 'Surat Keterangan Mahasiswa';
            $row['tgl'] = $zRow['tgl_pengajuan'];
            $row['status'] = $zRow['status'];
            $row['berkas'] = $zRow['surat_jadi'];
            $result[] = $row;
            $all_num_rows++;
        }
    }
?>
<div class="content-wrapper pt-2">
    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Status Pengajuan Surat</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-3">
                        <?php if($all_num_rows == 0){?>
                        <center>Belum Ada Data Pengajuan Surat.</center>
                        <?php }else{ ?>
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
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
                                    <td><?= $data['jenis'] ?></td>
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
                                    <?php if(is_null($data['berkas'])){ ?>
                                    <td>-</td>
                                    <?php }else { ?>
                                    <td><a href="<?= $data['berkas'] ?>" class="btn btn-primary"
                                            download="<?= $data['jenis']; ?>_<?= $_SESSION['nama'];?>"
                                            onclick="alert()">Unduh</a></td>
                                    <?php } ?>
                                </tr>
                                <?php 
                                    $i++;
                                } ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>

<script>
// Inisialisasi Toast
var Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000
});

function alert() {
    Toast.fire({
        icon: 'success',
        title: 'Berkas Berhasil Diunduh!'
    })
}
</script>