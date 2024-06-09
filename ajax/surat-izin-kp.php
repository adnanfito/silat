<?php
session_start();
$valid_extensions = array('pdf'); // valid extensions
$path_prodi = '../document/permohonan_prodi/'; // upload directory
$path_krs = '../document/krs/'; // upload directory
$prodi_to_db = 'document/permohonan_prodi/'; //Upload to db
$krs_to_db = 'document/krs/'; // upload to db
$maxsize = 512 * 1024; // Max. 512 Kb

// Pengecekan apakah form telah diisi semua atau belum
if(!empty($_POST['keperluan']) && !empty($_POST['jabatan']) && !empty($_POST['alamat']) && !empty($_POST['domisili'])
&& !empty($_POST['mulai']) && !empty($_POST['selesai']) && !empty($_POST['instansi']) && !empty($_POST['kota']) && !empty($_POST['semester'])
&& !empty($_POST['ipk']) && !empty($_POST['sksk']) && !empty($_POST['telp']) && !empty($_POST['judul'])  &&  $_FILES['spprodi'] &&  $_FILES['krs'])
{
    $spprodi = $_FILES['spprodi']['name'];
    $spprodi_tmp = $_FILES['spprodi']['tmp_name'];
    $krs = $_FILES['krs']['name'];
    $krs_tmp = $_FILES['krs']['tmp_name'];
    // get uploaded file's extension
    $spprodi_ext = strtolower(pathinfo($spprodi, PATHINFO_EXTENSION));
    $krs_ext = strtolower(pathinfo($krs, PATHINFO_EXTENSION));
    // can upload same file using rand function
    $final_spprodi = rand(1000,1000000).$spprodi;
    $final_krs = rand(1000,1000000).$krs;
    // check's valid format
    if(in_array($spprodi_ext, $valid_extensions) && in_array($krs_ext, $valid_extensions)) 
    { 
        $path_prodi = $path_prodi.strtolower($final_spprodi);
        $prodi_to_db = $prodi_to_db.strtolower($final_spprodi);
        $path_krs = $path_krs.strtolower($final_krs);
        $krs_to_db = $krs_to_db.strtolower($final_krs);

        // Check's valid size
        if($_FILES['spprodi']['size'] <= $maxsize && $_FILES['krs']['size'] <= $maxsize){
            if(move_uploaded_file($spprodi_tmp, $path_prodi) && move_uploaded_file($krs_tmp, $path_krs)) 
            {
                $keperluan = $_POST['keperluan'];
                $jabatan = $_POST['jabatan'];
                $alamat = $_POST['alamat'];
                $domisili = $_POST['domisili'];
                $nama = $_SESSION['nama'];
                $nim = $_POST['nim'];
                $prodi = $_POST['prodi'];
                $departemen = $_POST['departemen'];
                $mulai = date('Y-m-d', strtotime($_POST['mulai']));
                $selesai = date('Y-m-d', strtotime($_POST['selesai']));
                $instansi = $_POST['instansi'];
                $kota = $_POST['kota'];
                $semester = $_POST['semester'];
                $ipk = $_POST['ipk'];
                $sksk = $_POST['sksk'];
                $telp = $_POST['telp'];
                $judul = $_POST['judul'];
    
                //include database configuration file
                include_once '../config.php';
                //insert form data in the database
                try {
                    mysqli_query($con,"INSERT INTO surat_izin_kp(
                        nim,
                        nama_mhs,
                        prodi,
                        departemen,
                        semester,
                        ipk,
                        sksk,
                        domisili,
                        no_wa,
                        judul,
                        tgl_pengajuan,
                        tgl_mulai,
                        tgl_selesai,
                        keperluan,
                        jabatan,
                        instansi,
                        kota,
                        krs,
                        surat_permohonan,
                        alamat_instansi,
                        status) VALUES (
                            $nim,
                            '".$nama."',
                            '".$prodi."',
                            '".$departemen."',
                            $semester,
                            '$ipk',
                            '$sksk',
                            '$domisili',
                            '$telp',
                            '$judul',
                            curdate(),
                            '$mulai',
                            '$selesai',
                            '$keperluan',
                            '$jabatan',
                            '$instansi',
                            '$kota',
                            '".$krs_to_db."',
                            '".$prodi_to_db."',
                            '$alamat',
                            'pending');");
                } catch (mysqli_sql_exception $e) { 
                    var_dump($e);
                    exit; 
                }
                
                //echo $insert?'ok':'err';
                $res = [
                    'status' => 200,
                   'message' => 'Data berhasil diupload',
               ];
    
               echo json_encode($res);
               return;
            }
        }else{
        // Jika ukuran terlalu besar
        $res = [
            'status' => 401,
           'message' => 'Ukuran File terlalu besar',
       ];
       echo json_encode($res);
       return;
        }
    } 
    else 
    {
        // Jika ekstensi salah
        $res = [
            'status' => 402,
           'message' => 'Ekstensi salah!',
       ];
       echo json_encode($res);
       return;
    }
} else {
    // Jika form belum terisi semua
    $res = [
        'status' => 403,
       'message' => 'Isi yang bener cok',
   ];
   echo json_encode($res);
   return;
}
?>