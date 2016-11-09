<?php
class DBManager{

  function getConnection(){
    
	// sarif add here at test_git_3
	// sarif add here now (9/11/2016 6:20PM) at test_git_2
   
    // using PDO approach
    $conn = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8mb4', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    return $conn;
    
  }
}
?>