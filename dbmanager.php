<?php
class DBManager{

  function getConnection(){
    
	// sarif add here at test_git_3
	
	// sarif add here also at test_git_3 at 9/11/2016 6:21PM
   
    // using PDO approach
    $conn = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8mb4', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    return $conn;
    
  }
}
?>