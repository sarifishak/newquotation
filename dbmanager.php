<?php
class DBManager{

  function getConnection(){

    /* 
    // this for using cloud connection
    $services = getenv("VCAP_SERVICES");
    $services_json = json_decode($services,true);
    $mysql_config = $services_json["cleardb"][0]["credentials"];

    $db = $mysql_config["name"];
    $host = $mysql_config["hostname"];
    $port = $mysql_config["port"];
    $username = $mysql_config["username"];
    $password = $mysql_config["password"];
    
    
    $conn = mysql_connect($host . ':' . $port, $username, $password);
    if(! $conn ){
      die('Could not connect:db=' .$db . ',host=' . $host . ',port=' . $port . ',username=' . $username . ',password=' . $password . ',error=' . mysqli_error($conn));
    }
    */
    
    // this for using local connection

    $db = "ad_a42b01dedd03768"; 
    $host = "localhost";
    $port = "3306";
    // this setting for VM
    $username = "shima";
    $password = "p@ssw0rd";
    
    //this setting for my local
    //$username = "sarif";
    //$password = "norlaily*282";
 
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