        <?php session_start() ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="text-center mx-auto">
                            <h1 class="bg-primary py-2 px-3 rounded-lg">Sistem Informasi Layanan Teknik</h1>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-semibold">Selamat Datang <?= $_SESSION['nama'] ?>!
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="callout callout-info">
                                        <h6>SILAT adalah Sistem Informasi Layanan Teknik yang melayani mahasiswa dalam
                                            melakukan pengajuan surat.</h6>
                                    </div>
                                    <div class="callout callout-info">
                                        <h6>Syarat pengajuan Surat :</h6>
                                        <ol>
                                            <li>Mahasiswa aktif Universitas Diponegoro</li>
                                            <li>Telah menempuh 85 SKS</li>
                                            <li>Telah memiliki tujuan instansi</li>
                                        </ol>
                                    </div>
                                    <div class="callout callout-info">
                                        <h6>Cara pengajuan Surat :</h6>
                                        <ol>
                                            <li>Mengisi form dengan benar berdasarkan ketentuan yang ada</li>
                                            <li>Mengupload berkas yang dibutuhkan</li>
                                            <li>Integer molestie lorem at massa</li>
                                            <li>Facilisis in pretium nisl aliquet</li>
                                            <li>Faucibus porta lacus fringilla vel</li>
                                            <li>Aenean sit amet erat nunc</li>
                                            <li>Eget porttitor lorem</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <footer class="main-footer">Copyright &copy; 2024 Silat. All rights reserved.</footer>