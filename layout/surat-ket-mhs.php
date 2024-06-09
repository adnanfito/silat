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
                    <h1 class="py-2 px-3 rounded-lg">PENGAJUAN SURAT KETERANGAN MAHASISWA</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <!-- <div class="card-header">
        <h3 class="card-title">Select2 (Default Theme)</h3>
    </div> -->
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="" method="POST" id="form">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="nama">Nama Mahasiswa :</label>
                                    <input class="form-control" type="text" value="<?= $mhs['nama'] ?>" id="nama"
                                        disabled />
                                    <input type="hidden" name="nama" value="<?= $mhs['nama'] ?>" />
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="departemen">Departemen :</label>
                                    <input class="form-control" type="text" value="<?= $mhs['departemen'] ?>"
                                        id="departemen" disabled />
                                    <input type="hidden" name="departemen" value="<?= $mhs['departemen'] ?>">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="domisili">Alamat / Address :</label>
                                    <input class="form-control" type="text" name="domisili" id="domisili"
                                        placeholder="Alamat di Semarang misal : Jalan Prof. Soedarto, SH" />
                                </div>
                                <!-- /.form-group -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Semester :</label>
                                            <select class="form-control select2bs4" name="semester" style="width: 100%">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birth">TGL lahir / Date of Birth :</label>
                                            <input type="date" class="form-control datetimepicker-input" id="birth"
                                                value="<?= $mhs['tgl_lahir'] ?>" disabled />
                                            <input type="hidden" name="birth" value="<?= $mhs['tgl_lahir'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="place">Tempat Lahir / Place :</label>
                                    <input class="form-control" type="text" name="place" id="place"
                                        placeholder="Tempat Lahir" />
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nim">NIM :</label>
                                    <input class="form-control" type="text" value="<?= $mhs['nim'] ?>" id="nim"
                                        disabled />
                                    <input type="hidden" name="nim" value="<?= $mhs['nim'] ?>">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="prostud">Program Studi :</label>
                                    <input class="form-control" type="text" value="<?= $mhs['prodi'] ?>" id="prodi"
                                        disabled />
                                    <input type="hidden" name="prodi" value="<?= $mhs['prodi'] ?>">
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="telp">No WhatsApp Aktif :</label>
                                    <input class="form-control" type="text" placeholder="Misal 0813123456" name="telp"
                                        id="telp" />
                                </div>
                                <!-- /.form-group -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Tahun Akademik :</label>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select class="form-control select2bs4" name="ta1" style="width: 100%">
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                            </select>
                                        </div>
                                    </div>
                                    /
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select class="form-control select2bs4" name="ta2" style="width: 100%">
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="tujuan-surat">Tujuan dibuatnya surat :</label>
                                    <input class="form-control" type="text" name="tujuan-surat" id="tujuan-surat"
                                        placeholder="Tujuan dibuatnya surat" />
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <p class="text-sm">*NB : Silahkan diisi jika membutuhkan Surat Keterangan Mahasiswa
                            Versi Inggris / Jika tidak dikosongkan.</p>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label for="tujuan-surat-eng">Tujuan dibuatnya surat (Untuk Surat Ket MHS Ver
                                Inggris) :</label>
                            <input class="form-control" type="text" name="tujuan-surat-eng" id="tujuan-surat-eng"
                                placeholder="This information is given to" />
                        </div>

                        <div class="w-50">
                            <input class="btn btn-primary" type="submit" value="Simpan" />
                            <div class="btn btn-secondary" onclick="reset()" style="cursor: pointer;">Reset</div>
                    </form>
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
        url: "ajax/surat-ket-mhs.php",
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
            }
        },
    });
});
</script>