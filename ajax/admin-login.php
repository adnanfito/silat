<?php
require '../config.php';
if(isset($_POST['login_admin']))
{
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);

    $query = "SELECT * FROM admin where username ='$username' and password='$pass'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        session_start();
        $mhs = mysqli_fetch_array($query_run);
        $_SESSION['username'] = $username;
        $_SESSION['isAdmin'] = TRUE;

        $res = [
            'status' => 200,
            'message' => 'Admin Fetch Successfully by username',
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Admin Id Not Found'
        ];
        echo json_encode($res);
        return;
    }

}