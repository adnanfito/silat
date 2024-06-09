<?php
    session_start();
    session_unset();
    session_destroy();

    $res = [
        'status' => 200,
       'message' => 'Sukses Logout!',
   ];
   echo json_encode($res);
   return;