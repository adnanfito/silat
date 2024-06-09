<?php

if(isset( $_FILES['berkas'] )) {
    $valid_extensions = array('pdf'); // valid extensions
    $path = '../document/berkas_jadi/surat-izin-kp/'; // upload directory
    $path_to_db = 'document/berkas_jadi/surat-izin-kp/';
    $id = $_POST['id'];
    
    $file = $_FILES['berkas']['name'];
    $tmp = $_FILES['berkas']['tmp_name'];
    // get uploaded file's extension
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    // can upload same file using rand function
    $final_file = rand(1000,1000000).$file;
    // check's valid format
    if(in_array($ext, $valid_extensions)) 
    { 
        $path = $path.strtolower($final_file);
        $path_to_db = $path_to_db.strtolower($final_file);
        if(move_uploaded_file($tmp,$path)) 
        {
            //include database configuration file
            include_once '../config.php';
            //Update form data in the database
            try{
                mysqli_query($con,"UPDATE surat_izin_kp SET surat_jadi = '".$path_to_db."', status = 'setuju' WHERE id = $id");
            }catch (mysqli_sql_exception $e){
                var_dump($e);
                exit; 
            }
            $res = [
                'status' => 200,
               'message' => 'Berkas Berhasil diupload',
           ];
           echo json_encode($res);
           return;
        }
        $res = [
            'status' => 403,
           'message' => 'Berkas gagal diupload',
        ];
        echo json_encode($res);
        return;
    }
}