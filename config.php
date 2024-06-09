<?php
    $con =  mysqli_connect("localhost", "root","","db_silat");
     if (!$con) {
        die("<b>Connection Failed:</b>".mysqli_connect_error());
      }