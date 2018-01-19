<?php
class DBManager{

  function getConnection(){


    $db = "XXXXXXX"; 
    $host = "localhost";
    $port = "3306";
    // this setting for VM
    $username = "XXXXXX";
    $password = "XXXXXX";
    
    /*
    $conn = mysqli_connect($host,$username,$password,$db);

    // Check connection
    if (mysqli_connect_errno())
    {
      die('Could not connect:db=' .$db . ',host=' . $host . ',port=' . $port . ',username=' . $username . ',password=' . $password . ',error=' . mysqli_error($conn));
    }
    else {
        mysqli_select_db($db);
        return $conn;
    }
    */
    // using PDO approach
    $conn = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8mb4', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    return $conn;
    
  }
}
?>
