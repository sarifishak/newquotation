<?php

 class DBManager{

  function getConnection(){

    // this for using local connection

    $db = "newQuotation";
    $host = "localhost";
    $port = "3306";
    // this setting for VM
    $username = "root";
    $password = "admin1234";

    // using PDO approach
    $conn = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8mb4', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    return $conn;

  }
}

?>