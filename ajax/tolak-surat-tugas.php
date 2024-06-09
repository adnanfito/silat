<?php 

if(isset($_POST['id'])){
    $id = $_POST['id'];
    //include database configuration file
    include_once '../config.php';
    //Update form data in the database
    try{
        mysqli_query($con,"UPDATE surat_tugas SET status = 'ditolak' WHERE id = $id");
    }catch (mysqli_sql_exception $e){
        var_dump($e);
        exit; 
    }
    $res = [
        'status' => 200,
       'message' => 'Pengajuan Berhasil Ditolak',
   ];
   echo json_encode($res);
   return;
}
$res = [
    'status' => 404,
   'message' => 'error',
];
echo json_encode($res);
return;