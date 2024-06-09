<?php 
    require '../config.php';
    session_start();
    $nim = $_SESSION['nim'];
    // Melakukan Query  ke Database untuk mengisikan data mahasiswa
    //  Secara otomatis pada input yang disabled
    $query = "SELECT * FROM mahasiswa where nim ='$nim'";
    // Menjalankan Query
    $query_run = mysqli_query($con, $query);
    // Melakukan fetching array untuk menampilkan data dengan array asosiatif
    $mhs = mysqli_fetch_array($query_run);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="mx-auto text-center">
                    <h1 class="py-2 px-3 rounded-lg">PENGAJUAN SURAT TUGAS KP</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="form">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jabatan">Jabatan yang dituju :</label>
                                    <input class="form-control" type="text"
                                        placeholder="Jabatan yang dituju misal : HRD / Rektor" name="jabatan"
                                        id="jabatan" />
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="alamat">Alamat Lembaga :</label>
                                    <input class="form-control" type="text"
                                        placeholder="Alamat lembaga yang dituju misal : Jalan Prof. Soedarto, SH"
                                        name="alamat" id="alamat" />
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="nama">Nama Mahasiswa :</label>
                                    <input class="form-control" type="text" id="nama" value="<?= $mhs['nama'] ?>"
                                        disabled />
                                    <input type="hidden" name="nama" value="<?= $mhs['nama'] ?>" />
                                </div>
                                <!-- /.form-group -->
                                <div class=" form-group">
                                    <label for="domisili">Alamat Mahasiswa :</label>
                                    <input class="form-control" type="text" name="domisili" id="domisili"
                                        placeholder="Alamat di Semarang misal : Jalan Prof. Soedarto, SH" />
                                </div>
                                <!-- /.form-group -->
                                <!-- Date -->
                                <div class="form-group w-50">
                                    <label>Tanggal mulai KP :</label>
                                    <div class="input-group date" id="mulai">
                                        <input type="date" class="form-control datetimepicker-input" name="mulai" />
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lembaga">Lembaga yang dituju :</label>
                                    <input class="form-control" type="text"
                                        placeholder="Lembaga yang dituju misal : Universitas Diponegoro" name="lembaga"
                                        id="lembaga" />
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="kota">Kota/Kabupaten yang dituju :</label>
                                    <input class="form-control" type="text"
                                        placeholder="Kota tempat lembaga yang dituju misal : Semarang" name="kota"
                                        id="kota" />
                                </div>
                                <!-- /.form-group -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nim">NIM :</label>
                                            <input class="form-control" type="text" id="nim" value="<?= $mhs['nim'] ?>"
                                                disabled />
                                            <input type="hidden" name="nim" value="<?= $mhs['nim'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Semester :</label>
                                            <select class="form-control" style="width: 100%" name="semester">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="telp">No HP :</label>
                                    <input class="form-control" type="text" placeholder="Misal 0813123456" name="telp"
                                        id="telp" />
                                </div>
                                <!-- Date -->
                                <div class="form-group w-50">
                                    <label>Tanggal Selesai KP :</label>
                                    <div class="input-group date" id="selesai">
                                        <input type="date" class="form-control datetimepicker-input" name="selesai" />
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label for="judul">Judul KP (Rencana boleh/Kosong boleh) :</label>
                            <input class="form-control" type="text" placeholder="Judul KP" name="judul" id="judul" />
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label for="file">Surat Balasan dari Perusahaan[pdf..max 500kb]:</label>
                            <div>
                                <input type="file" id="file" name="file" />
                            </div>
                        </div>
                        <p class="text-sm">
                            Ket: <br />
                            *Periksa data-data sebelum disimpan, pastikan surat balasan dari perusahaan
                            diupload.
                        </p>
                        <div class="w-50">
                            <input class="btn btn-primary" type="submit" value="Simpan" />
                    </form>
                    <div class="btn btn-secondary reset" style="cursor: pointer" onclick="reset()">Reset</div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
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

function reset() {
    $("#form")[0].reset();
    Toast.fire({
        icon: 'success',
        title: 'Form Berhasil Direset!'
    })
}
$('#form').submit(function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    // Melakukan request ke ajax/surat-tugas.php dengan method post
    $.ajax({
        url: "ajax/surat-tugas.php",
        type: "POST",
        data: new FormData(this), // Mengirimkan data form
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
            var res = JSON.parse(response); // Melakukan parse JSON
            if (res.status == 200) { //status sukses
                $("#form")[0].reset();
                Toast.fire({
                    icon: 'success',
                    title: 'Pengajuan Sukses!'
                })
            } else if (res.status == 403) { //status jika form belum terisi semua
                Toast.fire({
                    icon: 'warning',
                    title: 'Harap isi semua terlebih dahulu!'
                })
            } else if (res.status == 402) { //status jika berkas tidak sesuai ketentuan
                Toast.fire({
                    icon: 'warning',
                    title: 'Harap Upload Berkas Sesuai Dengan Ketentuan!'
                })
            } else if (res.status == 401) { //status jika berkas tidak sesuai ketentuan
                Toast.fire({
                    icon: 'warning',
                    title: 'Ukuran File Terlalu Besar!'
                })
            }
        },
    });
});
</script>