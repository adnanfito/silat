<?php
    require '../config.php';
    if(isset($_POST['login'])) //dilakukan pengecekan apakah user telah pencet tombol login
    {
        // Menghindari Injection (Sistem Keamanan)
        $nim = mysqli_real_escape_string($con, $_POST['nim']);
        $pass = mysqli_real_escape_string($con, $_POST['pass']);
    
        $query = "SELECT * FROM mahasiswa where nim ='$nim' and  password='$pass'";
        $query_run = mysqli_query($con, $query);
            // 
        if(mysqli_num_rows($query_run) == 1)
        {
            session_start();
            $mhs = mysqli_fetch_array($query_run);
            $_SESSION['nim'] = $nim;
            $_SESSION['login'] = TRUE;
            $_SESSION['nama'] = $mhs['nama'];
    
            $res = [
                 'status' => 200,
                'message' => 'Student Fetch Successfully by nim',
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 404,
                'message' => 'Student Id Not Found'
            ];
            echo json_encode($res);
            return;
        }
    
    }

   