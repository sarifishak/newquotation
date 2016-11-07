<?php
  require_once 'dbmanager.php';
?>
<?php
class QuotationNotes{
/*
CREATE TABLE quotationNotes(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quotationId int,
    note VARCHAR(200),
    createdDate DATETIME ,
    createdId int
);
*/
  
  var $id;
  var $quotationId;
  var $note;
  var $createdDate;
  var $createdId;
  
  
  function selectAll(){
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    $sql_stmt = "SELECT * FROM quotationnotes order by id desc";

    //create an empty array that will eventually contain the list of users
    $quotationNotes_list=array();
    
    //iterate each row in retval
    foreach($conn->query($sql_stmt) as $dbfield) {
      //instantiate a user object
      $quotationNotes = new QuotationNotes();      

      //initialize fields of user object with the columns retrieved from the query
      $quotationNotes->id = $dbfield['id'];
      $quotationNotes->quotationId = $dbfield['quotationId'];
      $quotationNotes->note = $dbfield['note'];
      $quotationNotes->createdDate = $dbfield['createdDate'];
      $quotationNotes->createdId = $dbfield['createdId'];
      
      //add the user object in the array
      $quotationNotes_list[] = $quotationNotes;
    }

    //return the array
    return $quotationNotes_list;
  }

  function selectAllByQuotationId(){
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    $stmt = $conn->prepare("SELECT * FROM quotationnotes WHERE quotationId=?");
    $stmt->execute(array($this->quotationId));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = $stmt->rowCount();

    //create an empty array that will eventually contain the list of users
    $quotationNotes_list=array();

    foreach($rows as $dbfield) {
      //instantiate a user object
      $quotationNotes = new QuotationNotes();      

      //initialize fields of user object with the columns retrieved from the query
      $quotationNotes->id = $dbfield['id'];
      $quotationNotes->quotationId = $dbfield['quotationId'];
      $quotationNotes->note = $dbfield['note'];
      $quotationNotes->createdDate = $dbfield['createdDate'];
      $quotationNotes->createdId = $dbfield['createdId'];
      
      //add the user object in the array
      $quotationNotes_list[] = $quotationNotes;
    }

    //return the array
    return $quotationNotes_list;
  }
    
  function selectById(){
  	
    $dbm = new DBManager();
    $conn = $dbm->getConnection();
    $stmt = $conn->prepare("SELECT * FROM quotationnotes WHERE id=?");
    $stmt->execute(array($this->id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = $stmt->rowCount();

    foreach($rows as $dbfield) {
      
      //initialize fields of user object with the columns retrieved from the query
      $this->id = $dbfield['id'];
      $this->quotationId = $dbfield['quotationId'];
      $this->note = $dbfield['note'];
      $this->createdDate = $dbfield['createdDate'];
      $this->createdId = $dbfield['createdId'];
      
    }

  }
}
?>