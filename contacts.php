<?php
  require_once 'dbmanager.php';
?>
<?php
class Contacts{
/*
CREATE TABLE contacts(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contactTypeId int,	
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100),
    ic VARCHAR(100),
    address VARCHAR(200),
    city VARCHAR(100),
    state VARCHAR(50),
    postcode VARCHAR(50),
    mobile VARCHAR(50),
    office VARCHAR(50),
    home VARCHAR(50),
    fax VARCHAR(50),
    email VARCHAR(100),
    createdDate DATETIME,
    createdId int
);

*/
  
  var $id;
  var $contactTypeId;
  var $firstName;
  var $lastName;
  var $ic;
  var $address;
  var $city;
  var $state;
  var $postcode;
  var $mobile;
  var $office;
  var $home;
  var $fax;
  var $email;
  var $createdDate;
  var $createdId;
  
  
  function selectAll(){
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    $sql_stmt = "SELECT * FROM contacts order by id desc";

    //create an empty array that will eventually contain the list of users
    $contact_list=array();

    //iterate each row in retval
    foreach($conn->query($sql_stmt) as $dbfield) {
      //instantiate a user object
      $contact = new Contacts();      

      //initialize fields of user object with the columns retrieved from the query
      $contact->id = $dbfield['id'];
      $contact->contactTypeId = $dbfield['contactTypeId'];
      $contact->firstName = $dbfield['firstName'];
      $contact->lastName = $dbfield['lastName'];
      $contact->ic = $dbfield['ic'];
      $contact->address = $dbfield['address'];
      $contact->city = $dbfield['city'];
      $contact->state = $dbfield['state'];
      $contact->postcode = $dbfield['postcode'];
      $contact->mobile = $dbfield['mobile'];
      $contact->office = $dbfield['office'];
      $contact->home = $dbfield['home'];
      $contact->fax = $dbfield['fax'];
      $contact->email = $dbfield['email'];
      $contact->createdDate = $dbfield['createdDate'];
      $contact->createdId = $dbfield['createdId'];
      
      //add the user object in the array
      $contact_list[] = $contact;
    }

    //return the array
    return $contact_list;
  }
  
  function selectById(){
  	
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    $sql_stmt = "SELECT * FROM contacts WHERE id=?";
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute(array($this->id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = $stmt->rowCount();

    //iterate each row in retval
    foreach($rows as $dbfield) {
      
      //initialize fields of user object with the columns retrieved from the query
      $this->id = $dbfield['id'];
      $this->contactTypeId = $dbfield['contactTypeId'];
      $this->firstName = $dbfield['firstName'];
      $this->lastName = $dbfield['lastName'];
      $this->ic = $dbfield['ic'];
      $this->address = $dbfield['address'];
      $this->city = $dbfield['city'];
      $this->state = $dbfield['state'];
      $this->postcode = $dbfield['postcode'];
      $this->mobile = $dbfield['mobile'];
      $this->office = $dbfield['office'];
      $this->home = $dbfield['home'];
      $this->fax = $dbfield['fax'];
      $this->email = $dbfield['email'];
      $this->createdDate = $dbfield['createdDate'];
      $this->createdId = $dbfield['createdId'];
      
    }

  }
}
?>