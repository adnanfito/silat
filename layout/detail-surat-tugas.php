<?php
if(isset($_POST['id'])){
    include '../config.php';
    $id = $_POST["id"];

    $query = "SELECT * FROM surat_tugas where id = $id";
    // Menjalankan Query
    $query_run = mysqli_query($con, $query);
    // Melakukan fetching array untuk menampilkan data dengan array asosiatif
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main Content -->
    <section class="content mx-4 pt-4">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Pengajuan Surat Tugas KP</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 65vh">
                        <table class="table table-hover">
                            <tbody>
                                <?php
                                    while($row = mysqli_fetch_array($query_run))
                                    {
                                        $id_surat = $row['id'];
                                 ?>
                                <tr>
                                    <td class="col-md-3">ID Surat</td>
                                    <td>:</td>
                                    <td><?= $row['id']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Jenis Surat</td>
                                    <td>:</td>
                                    <td>Surat Tugas KP</td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">NIM</td>
                                    <td>:</td>
                                    <td><?= $row['nim']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Nama Mahasiswa</td>
                                    <td>:</td>
                                    <td><?= $row['nama_mhs']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Semester</td>
                                    <td>:</td>
                                    <td><?= $row['semester']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Alamat MHS</td>
                                    <td>:</td>
                                    <td><?= $row['domisili']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">No HP</td>
                                    <td>:</td>
                                    <td><?= $row['no_hp']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Tanggal mulai KP</td>
                                    <td>:</td>
                                    <td><?= $row['tgl_mulai']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Tanggal selesai KP</td>
                                    <td>:</td>
                                    <td><?= $row['tgl_selesai']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Judul KP</td>
                                    <td>:</td>
                                    <td><?= $row['judul']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Jabatan yang dituju</td>
                                    <td>:</td>
                                    <td><?= $row['pimpinan']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Lembaga yang dituju</td>
                                    <td>:</td>
                                    <td><?= $row['lembaga']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Alamat Lembaga</td>
                                    <td>:</td>
                                    <td><?= $row['alamat_lembaga']; ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3">Kota/kabupaten yang dituju</td>
                                    <td>:</td>
                                    <td><?= $row['kota']; ?></td>
                                </tr>
                                <tr class="col-md-3">
                                    <td>Surat Balasan dari Perusahaan</td>
                                    <td>:</td>
                                    <td><a href="<?= $row['surat_balasan']; ?>" class="btn btn-primary"
                                            download="Surat Balasan Perusahaan_<?= $row['nama_mhs']; ?>">Unduh
                                            File</a>
                                    </td>
                                </tr>
                                <?php if($row['status'] == 'setuju' || $row['status'] == 'ditolak'){
                                    ?>
                                <tr class="col-md-3">
                                    <td>Aksi</td>
                                    <td>:</td>
                                    <td>
                                        -
                                    </td>
                                </tr>
                                <?php 
                                     }else{
                                        ?>
                                <tr class="col-md-3">
                                    <td>Aksi</td>
                                    <td>:</td>
                                    <td>
                                        <button class="btn btn-success"
                                            onclick="setuju(<?= $id_surat ?>)">Setuju</button>
                                        <button class="btn btn-warning" onclick="tandatangan(<?= $id_surat ?>)">Proses
                                            Tandatangan</button>
                                        <button class="btn btn-danger" onclick="tolak(<?= $id_surat ?>)">Tolak</button>
                                    </td>
                                </tr>
                                <?php
                                     }
                                }
                                 ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>

<script>
function setuju(id) {
    (async () => {
        const {
            value: file
        } = await Swal.fire({
            title: "Pilih Berkas",
            input: "file",
            inputAttributes: {
                "accept": ".pdf"
            }
        });
        if (file) {
            var formData = new FormData();
            var data = $('.swal2-file')[0].files[0];
            formData.append("berkas", data);
            formData.append("id", id);
            $.ajax({
                method: 'post',
                url: 'ajax/upload-surat-tugas.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) { //status sukses
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Berkas Berhasil Diupload!",
                            showConfirmButton: true,
                        }).then((result) => {
                            top.location.href =
                                'admin_page.php';
                        });
                    } else if (res.status == 403) {
                        console.log("gagal upload");
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Berkas Gagal Diupload!",
                            showConfirmButton: true,
                        })
                    }
                },
                error: function() {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        }
    })()
}

function tolak(id) {
    Swal.fire({
        title: "Anda Yakin?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Tidak",
        confirmButtonText: "Ya, Tolak Pengajuan!"
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData();
            formData.append("id", id);
            $.ajax({
                method: 'post',
                url: 'ajax/tolak-surat-tugas.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) { //status sukses
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Pengajuan Berhasil Ditolak!",
                            showConfirmButton: true,
                        }).then((result) => {
                            top.location.href =
                                'admin_page.php';
                        });
                    } else if (res.status == 403) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            showConfirmButton: true,
                        })
                    }
                }
            })
        }
    });
}

function tandatangan(id) {
    Swal.fire({
        title: "Anda Yakin?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Tidak",
        confirmButtonText: "Ya, Ubah Status!"
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData();
            formData.append("id", id);
            $.ajax({
                method: 'post',
                url: 'ajax/ttd-surat-tugas.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) { //status sukses
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Status Berhasil Diubah!",
                            showConfirmButton: true,
                        }).then((result) => {
                            top.location.href =
                                'admin_page.php';
                        });
                    } else if (res.status == 403) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            showConfirmButton: true,
                        })
                    }
                }
            })
        }
    });
}
</script>
<!-- /.content-wrapper -->