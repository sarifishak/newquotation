<?php
  require_once 'dbmanager.php';
?>
<?php
class UserTypes{
/*
CREATE TABLE userTypes(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,	
    userType VARCHAR(100) NOT NULL,
    defaultPage VARCHAR(200) NOT NULL
);
*/
  
  var $id;
  var $userType;
  var $defaultPage;
  var $foundRecord;
  
  function selectAll(){
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    $sql_stmt = "SELECT * FROM usertypes order by id desc";

    //create an empty array that will eventually contain the list of users
    $usertype_list=array();
    
    foreach($conn->query($sql_stmt) as $dbfield) {
        //instantiate a user object
        $usertype = new UserTypes();      
        
        //initialize fields of user object with the columns retrieved from the query
        $usertype->id = $dbfield['id'];
        $usertype->userType = $dbfield['userType'];
        $usertype->defaultPage = $dbfield['defaultPage'];
        
        //add the user object in the array
        $usertype_list[] = $usertype;
    }
    //return the array
    return $usertype_list;
  }
  
  function selectById(){
  	
    $dbm = new DBManager();
    $conn = $dbm->getConnection();
    
    $sql_stmt = "SELECT * FROM usertypes WHERE id=?";
    
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute(array($this->id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = $stmt->rowCount();
    
    //iterate each row in retval
    if ($row_count > 0) {
        foreach($rows as $dbfield) break; //just to get the 1st array
        $this->foundRecord=true;
        $this->userType = $dbfield['userType'];
        $this->defaultPage = $dbfield['defaultPage'];
    }

    //return the array
    return $this->foundRecord;
  }
}
?>