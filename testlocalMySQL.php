<?php
// mysqli

    $db = "ad_a42b01dedd03768"; 
    $host = "localhost";
    $port = "3306";
    $username = "sarif";
    $password = "norlaily*282";
    
    $con = mysqli_connect($host,$username,$password,$db);

    // Check connection
    if (mysqli_connect_errno())
      {
      die('Could not connect:db=' .$db . ',host=' . $host . ',port=' . $port . ',username=' . $username . ',password=' . $password . ',error=' . mysqli_error($conn));
      }
      else {
        echo "can connect maaa";
    }
    
    mysqli_select_db($db);


?>