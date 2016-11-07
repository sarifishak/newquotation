<?php
  require_once 'dbmanager.php';
?>
<?php
class ContactTypes{
/*
CREATE TABLE contactTypes(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,	
    contactType VARCHAR(100) NOT NULL
);
*/
  
  var $id;
  var $contactType;
  
  function selectAll(){
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    $sql_stmt = "SELECT * FROM contacttypes order by id desc";

    //create an empty array that will eventually contain the list of users
    $contactType_list=array();

    //iterate each row in retval
    foreach($conn->query($sql_stmt) as $dbfield) {
      //instantiate a user object
      $contactType = new ContactTypes();      

      //initialize fields of user object with the columns retrieved from the query
      $contactType->id = $dbfield['id'];
      $contactType->contactType = $dbfield['contactType'];
      
      //add the user object in the array
      $contactType_list[] = $contactType;
    }

    //return the array
    return $contactType_list;
  }
}
?>