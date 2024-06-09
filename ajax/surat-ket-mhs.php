<?php
// Pengecekan apakah form telah diisi semua atau belum
if(!empty($_POST['domisili']) && !empty($_POST['semester']) && !empty($_POST['place'])
&& !empty($_POST['ta1']) && !empty($_POST['ta2']) && !empty($_POST['tujuan-surat']) && !empty($_POST['telp']))
{
    $domisili = $_POST['domisili'];
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $prodi = $_POST['prodi'];
    $departemen = $_POST['departemen'];
    $place = $_POST['place'];
    $birth = date('Y-m-d', strtotime($_POST['birth']));
    $ta1 = $_POST['ta1'];
    $ta2 = $_POST['ta2'];
    $semester = $_POST['semester'];
    $telp = $_POST['telp'];
    $tujuan = $_POST['tujuan-surat'];

    $tahun_akademik = $ta1. "/" .$ta2;  // Menggabungkan TA1 dan TA2 menjadi tahun akademik
    //include database configuration file
    include_once '../config.php';
    //insert form data in the database
    try {
        if(!empty($_POST['tujuan-surat-eng'])){
            $tujuan_eng = $_POST['tujuan-surat-eng']; //Query jika tujuan surat english diisi
            mysqli_query($con,"INSERT INTO surat_ket_mhs ( 
                nim,
                nama_mhs,
                prodi,
                departemen,
                semester,
                tempat_lahir,
                tgl_lahir,
                domisili,
                no_wa,
                tahun_akademik,
                tujuan_surat,
                tujuan_surat_eng,
                tgl_pengajuan,
                status) VALUES (
                    $nim,
                    '$nama',
                    '$prodi',
                    '$departemen',
                    $semester,
                    '$place',
                    '$birth',
                    '$domisili',
                    '$telp',
                    '$tahun_akademik',
                    '$tujuan',
                    '$tujuan_eng',
                    curdate(),
                    'pending');");
        }else{
            // Query jika hanya tujuan surat saja yang diisi
            mysqli_query($con,"INSERT INTO surat_ket_mhs (
                nim,
                nama_mhs,
                prodi,
                departemen,
                semester,
                tempat_lahir,
                tgl_lahir,
                domisili,
                no_wa,
                tahun_akademik,
                tujuan_surat,
                tgl_pengajuan,
                status) VALUES (
                    $nim,
                    '$nama',
                    '$prodi',
                    '$departemen',
                    $semester,
                    '$place',
                    '$birth',
                    '$domisili',
                    '$telp',
                    '$tahun_akademik',
                    '$tujuan',
                    curdate(),
                    'pending');");
        }
        
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