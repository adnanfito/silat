<?php
$valid_extensions = array('pdf'); // valid extensions
$path = '../document/surat_balasan/'; // upload directory
$path_to_db = 'document/surat_balasan/'; //upload to db
$maxsize = 512 * 1024; // Max. 512 Kb

// Pengecekan apakah form telah diisi semua atau belum
if(!empty($_POST['jabatan']) && !empty($_POST['alamat']) && !empty($_POST['domisili']) && !empty($_POST['mulai'])
&& !empty($_POST['selesai']) && !empty($_POST['lembaga']) && !empty($_POST['kota']) && !empty($_POST['semester'])
&& !empty($_POST['telp']) && !empty($_POST['judul'])  &&  $_FILES['file'])
{
    $file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    // get uploaded file's extension
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    // can upload same file using rand function
    $final_file = rand(1000,1000000).$file;
    // check's valid format
    if(in_array($ext, $valid_extensions)) 
    { 
        $path = $path.strtolower($final_file);
        $path_to_db = $path_to_db.strtolower($final_file);
        // Check's valid size
        if($_FILES['file']['size'] <= $maxsize){
            if(move_uploaded_file($tmp,$path)) 
            {
                $jabatan = $_POST['jabatan'];
                $alamat = $_POST['alamat'];
                $nama = $_POST['nama'];
                $nim = $_POST['nim'];
                $domisili = $_POST['domisili'];
                $mulai = date('Y-m-d', strtotime($_POST['mulai']));
                $selesai = date('Y-m-d', strtotime($_POST['selesai']));
                $lembaga = $_POST['lembaga'];
                $kota = $_POST['kota'];
                $semester = $_POST['semester'];
                $telp = $_POST['telp'];
                $judul = $_POST['judul'];
    
                //include database configuration file
                include_once '../config.php';
                //insert form data in the database
                try {
                    mysqli_query($con,"INSERT INTO surat_tugas (
                        nim,
                        nama_mhs,
                        judul,
                        tgl_pengajuan,
                        semester,
                        domisili,
                        no_hp,
                        tgl_mulai,
                        tgl_selesai,
                        pimpinan,
                        lembaga,
                        kota,
                        alamat_lembaga,
                        surat_balasan,
                        status) VALUES (
                            $nim,
                            '$nama',
                            '$judul',
                            curdate(),
                            $semester,
                            '$domisili',
                            '$telp',
                            '$mulai',
                            '$selesai',
                            '$jabatan',
                            '$lembaga',
                            '$kota',
                            '$alamat',
                            '".$path_to_db."',
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