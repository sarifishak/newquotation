<?php
  require_once 'dbmanager.php';
  require_once 'userTypes.php';
?>
<?php
class Users{
  // class 'User' is the standard class craeted. Whiles 'Users' is mine specially for this project
  
  var $id;
  var $username;
  var $password;
  var $lastname;
  var $firstname;
  var $userType;
  var $status;
  var $createdDate;
  var $createdId;
  var $userTypeData;

  function checkLogin(){
    $dbm = new DBManager();
    $conn = $dbm->getConnection();
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute(array($this->username, md5($this->password)));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = $stmt->rowCount();
    
    $found = false;

    foreach($rows as $dbfield) {
        $found = true;
        //initialize fields of this object with the columns retrieved from the query
        $this->id = $dbfield['id'];
        $this->username = $dbfield['username'];
        $this->password = $dbfield['password'];
        $this->lastname = $dbfield['lastName'];
        $this->firstname = $dbfield['firstName'];
        $this->userType = $dbfield['userType'];
        
        $this->status = $dbfield['status'];
        $this->createdDate = $dbfield['createdDate'];
        $this->createdId = $dbfield['createdId'];
        
    }
    
    // get the user type and its default page
    if($found == true) {
        $userTypes = new UserTypes();
        $userTypes->id = $this->userType;
        $userTypes->foundRecord = false;
        if ($userTypes->selectById()){
            $this->userTypeData=$userTypes;
        }
    }

    return $found;
  }

  function selectAll(){
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    $sql_stmt = "SELECT * FROM users order by id desc";
    
    //create an empty array that will eventually contain the list of users
    $user_list=array();

    foreach($conn->query($sql_stmt) as $dbfield) {
        
        //instantiate a user object
        $user = new Users();      
        
        //initialize fields of user object with the columns retrieved from the query
        $user->id = $dbfield['id'];
        $user->username = $dbfield['username'];
        $user->password = $dbfield['password'];
        $user->lastname = $dbfield['lastName'];
        $user->firstname = $dbfield['firstName'];
        $user->userType = $dbfield['userType'];
        
        $user->status = $dbfield['status'];
        $user->createdDate = $dbfield['createdDate'];
        $user->createdId = $dbfield['createdId'];
        
        //add the user object in the array
        $user_list[] = $user;
        
    }

    //return the array
    return $user_list;
  }
}
?>