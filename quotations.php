<?php
  require_once 'dbmanager.php';
  require_once 'contacts.php';
  require_once 'quotationNotes.php';
?>
<?php
class Quotations{
/*

      
      -- chargeMode  - Daily, Weekly, Monthly, Yearly
      -- chargeDay - if Monthly - it will be fixed to 20 days
                   - if daily  - it based from start and endDate


DROP TABLE IF EXISTS quotations;
CREATE TABLE quotations(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quotationNo int NOT NULL DEFAULT '1',
    chargeDays int default 0,
    customerId int,
    patientId int,
    chargeMode  VARCHAR(50) default 'Daily',
    feeFor  VARCHAR(50),
    physiotherapy VARCHAR(10) default 'No',
    nurseVisit VARCHAR(10) default 'No',
    doktorVisit VARCHAR(10) default 'No',
    quotationDate DATE,
    hourPerDay int,
    dayPerWeek int,
    basicCharge double,
    startTimeDaily TIME,
    endTimeDaily TIME,
    startDate DATE,
    endDate DATE,
    mileage double default 0,
    adminFee double default 0,
    additionalCharge double default 0,
    gst double default 0,
    discount double default 0,
    totalAmount double default 0,
    totalPaid double default 0,
    amountDue double default 0,
    statusPaid int,
    status int DEFAULT 0,
    createdDate DATETIME ,
    createdId int
);

*/
  
  var $id;
  var $quotationNo;
  var $chargeMode;
  var $feeFor;
  var $physiotherapy;
  var $nurseVisit;
  var $doktorVisit;
  var $physioDays;
  var $nurseVisitDays;
  var $doctorVisitDays;
  
  var $chargeDays;
  var $customerId;
  var $patientId;
  var $quotationDate;
  var $hourPerDay;
  var $dayPerWeek;
  var $basicCharge;
  var $startTimeDaily;
  var $endTimeDaily;
  var $startDate;
  var $endDate;
  var $mileage;
  var $adminFee;
  var $additionalCharge;
  var $gst;
  var $discount;
  var $totalAmount;
  var $totalPaid;
  var $amountDue;
  var $statusPaid;
  var $status;
  
  var $createdDate;
  var $createdId;
  
  var $customerData;
  var $patientData;
  
  var $noteListData;
  
  var $debugMsg;
  
  var $quotations_list;
  var $row_count;

  
  function getAllFieldData($dbfield)
  {
      $quotations = new Quotations();      

      //initialize fields of user object with the columns retrieved from the query
      $quotations->id = $dbfield['id'];
      $quotations->quotationNo = $dbfield['quotationNo'];
      $quotations->chargeMode = $dbfield['chargeMode'];
      $quotations->feeFor = $dbfield['feeFor'];
      $quotations->physiotherapy = $dbfield['physiotherapy'];
      $quotations->nurseVisit = $dbfield['nurseVisit'];
      $quotations->doktorVisit = $dbfield['doktorVisit'];
      $quotations->physioDays = $dbfield['physioDays'];
      $quotations->nurseVisitDays = $dbfield['nurseVisitDays'];
      $quotations->doctorVisitDays = $dbfield['doctorVisitDays'];
      $quotations->chargeDays = $dbfield['chargeDays'];
      $quotations->customerId = $dbfield['customerId'];
      $quotations->patientId = $dbfield['patientId'];
      $quotations->quotationDate = $dbfield['quotationDate'];
      $quotations->hourPerDay = $dbfield['hourPerDay'];
      $quotations->dayPerWeek = $dbfield['dayPerWeek'];
      $quotations->basicCharge = $dbfield['basicCharge'];
      $quotations->startTimeDaily = $dbfield['startTimeDaily'];
      $quotations->endTimeDaily = $dbfield['endTimeDaily'];
      $quotations->startDate = $dbfield['startDate'];
      $quotations->endDate = $dbfield['endDate'];
      $quotations->mileage = $dbfield['mileage'];
      $quotations->adminFee = $dbfield['adminFee'];
      $quotations->additionalCharge = $dbfield['additionalCharge'];
      $quotations->gst = $dbfield['gst'];
      $quotations->discount = $dbfield['discount'];
      $quotations->totalAmount = $dbfield['totalAmount'];
      $quotations->totalPaid = $dbfield['totalPaid'];
      $quotations->amountDue = $dbfield['amountDue'];
      $quotations->statusPaid = $dbfield['statusPaid'];
      $quotations->status = $dbfield['status'];
      $quotations->createdDate = $dbfield['createdDate'];
      $quotations->createdId = $dbfield['createdId'];
      
      $customerData = new Contacts();
      $customerData->id = $quotations->customerId;
      $customerData->selectById();
      $quotations->customerData = $customerData;
      
      $patientData = new Contacts();
      $patientData->id = $quotations->patientId;
      $patientData->selectById();
      $quotations->patientData = $patientData;
      
      $quotationNotes = new QuotationNotes();
      $quotationNotes->quotationId=$quotations->id;
      $quotations->noteListData = $quotationNotes->selectAllByQuotationId();
      
      return $quotations;
      
  }
  function selectAll(){
    $debugMsg = "";
    $dbm = new DBManager();
    $conn = $dbm->getConnection();
    
    $sql_stmt = "SELECT * FROM quotations order by id desc limit 50";
    
    $debugMsg = "<br>selectAll:".$sql_stmt."<br>";
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute(array());
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = $stmt->rowCount();

    //create an empty array that will eventually contain the list of users
    $quotations_list=array();

    //iterate each row in retval  : foreach($conn->query($sql_stmt) as $dbfield) {
    foreach($rows as $dbfield) {
      //instantiate a user object
      $quotations_list[] = $this->getAllFieldData($dbfield);
    }
    
    $this->debugMsg = $debugMsg;
    $this->quotations_list = $quotations_list;
    $this->row_count = $row_count;

    //return the array
    return $quotations_list;
  }
  
  function selectAllNotDeleted(){
    $debugMsg = "";
    $dbm = new DBManager();
    $conn = $dbm->getConnection();
    
    $sql_stmt = "SELECT * FROM quotations WHERE status <> 2 order by id desc limit 50";
    
    $debugMsg = "<br>selectAll:".$sql_stmt."<br>";
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute(array());
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = $stmt->rowCount();

    //create an empty array that will eventually contain the list of users
    $quotations_list=array();

    //iterate each row in retval  : foreach($conn->query($sql_stmt) as $dbfield) {
    foreach($rows as $dbfield) {
      //instantiate a user object
      $quotations_list[] = $this->getAllFieldData($dbfield);
    }
    
    $this->debugMsg = $debugMsg;
    $this->quotations_list = $quotations_list;
    $this->row_count = $row_count;

    //return the array
    return $quotations_list;
  }

  
  function selectByQuotationDate($selectDate){
    
    $debugMsg = "";
    
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    /*
    $sql_stmt = "SELECT * FROM quotations WHERE MONTH(quotationDate) = MONTH('".mysqli_real_escape_string($selectDate)."')".
                " AND YEAR(quotationDate) = YEAR('".mysqli_real_escape_string($selectDate)."') order by id desc";

    */
    
    //$selectDate = '2016-9-9';
    
    $sql_stmt = "SELECT * FROM quotations WHERE MONTH(quotationDate) = MONTH(?) AND YEAR(quotationDate) = YEAR(?) AND status <> ? order by id desc";
    $debugMsg = $debugMsg."<br>selectByQuotationDate:".$sql_stmt."<br>";
    
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute(array($selectDate,$selectDate,2));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = $stmt->rowCount();
    
    //echo 'Row count='. $row_count;
    
    //create an empty array that will eventually contain the list of users
    $quotations_list=array();

    //iterate each row in retval
    foreach($rows as $dbfield) {
      //instantiate a user object
      $quotations_list[] = $this->getAllFieldData($dbfield);
    }
    
    $this->debugMsg = $debugMsg;
    $this->quotations_list = $quotations_list;
    $this->row_count = $row_count;

    return $quotations_list;

  }
  
  function selectById(){
  	
    $dbm = new DBManager();
    $conn = $dbm->getConnection();

    $sql_stmt = "SELECT * FROM quotations where id=?";
    
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute(array($this->id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //iterate each row in retval
    foreach($rows as $dbfield) {
      
      //initialize fields of user object with the columns retrieved from the query
      
      $this->quotationNo = $dbfield['quotationNo'];
      $this->chargeMode = $dbfield['chargeMode'];
      $this->feeFor = $dbfield['feeFor'];
      $this->physiotherapy = $dbfield['physiotherapy'];
      $this->nurseVisit = $dbfield['nurseVisit'];
      $this->doktorVisit = $dbfield['doktorVisit'];
      $this->physioDays = $dbfield['physioDays'];
      $this->nurseVisitDays = $dbfield['nurseVisitDays'];
      $this->doctorVisitDays = $dbfield['doctorVisitDays'];
      $this->chargeDays = $dbfield['chargeDays'];
      $this->customerId = $dbfield['customerId'];
      $this->patientId = $dbfield['patientId'];
      $this->quotationDate = $dbfield['quotationDate'];
      $this->hourPerDay = $dbfield['hourPerDay'];
      $this->dayPerWeek = $dbfield['dayPerWeek'];
      $this->basicCharge = $dbfield['basicCharge'];
      $this->startTimeDaily = $dbfield['startTimeDaily'];
      $this->endTimeDaily = $dbfield['endTimeDaily'];
      $this->startDate = $dbfield['startDate'];
      $this->endDate = $dbfield['endDate'];
      $this->mileage = $dbfield['mileage'];
      $this->adminFee = $dbfield['adminFee'];
      $this->additionalCharge = $dbfield['additionalCharge'];
      $this->gst = $dbfield['gst'];
      $this->discount = $dbfield['discount'];
      $this->totalAmount = $dbfield['totalAmount'];
      $this->totalPaid = $dbfield['totalPaid'];
      $this->amountDue = $dbfield['amountDue'];
      $this->statusPaid = $dbfield['statusPaid'];
      $this->status = $dbfield['status'];
      $this->createdDate = $dbfield['createdDate'];
      $this->createdId = $dbfield['createdId'];
      
      $customerData = new Contacts();
      $customerData->id = $this->customerId;
      $customerData->selectById();
      $this->customerData = $customerData;
      
      $patientData = new Contacts();
      $patientData->id = $this->patientId;
      $patientData->selectById();
      $this->patientData = $patientData;
      
      $quotationNotes = new QuotationNotes();
      $quotationNotes->quotationId=$this->id;
      $this->noteListData = $quotationNotes->selectAllByQuotationId();
      
    }

  }  // function selectById(){
  
  function deleteQuotationById() {
    
    $dbm = new DBManager();
    $conn = $dbm->getConnection();
    
    $sql_stmt = "UPDATE  quotations SET status=2 WHERE id=?";
    $debugMsg = "<br>deleteQuotationById:".$sql_stmt."<br>";
    
    $stmt = $conn->prepare($sql_stmt);
    $retval = $stmt->execute(array($this->id));
    
    //check if SQL query is successful
    $this->debugMsg = $debugMsg;
    return $retval;
    
  }   // function deleteQuotationById() {
  
  function showDebug() {
    echo $this->debugMsg;
  }
  
}
?>