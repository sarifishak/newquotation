<?php
  require_once(dirname(__FILE__).'/../dbmanager.php');
  require_once 'importField.php';
?>
<?php
class ImportFieldManager{

  /*
  
  This class handle the import, update or insert data for quotation and other related table
  
  */

  var $importFieldList;
  
  // list of valid input parameter
  //var $validParamInputs = array( "Name: ", "I/C No.: ", "Address: ", "E-Mail: ", "Contact No.1: ","Contact No.2: ","Patient Name: ","Patient I/C No.: ","Patient Address: ","Problem: ");
  var $validParamInputs = array( "Name", "contactCode","I/C No.", "Address", "E-Mail", "Contact No.1","Contact No.2",
                                 "Patient Name","Patient I/C No.","Patient Address","Problem","hoursPerDay","daysPerWeek","adminFees",
                                 "id","quotationNo","chargeMode","feeFor","physiotherapy","chargeDays",
                                 "customerId","patientId","quotationDate",
                                 "basicCharge","startTimeDaily","endTimeDaily",
                                 "startDate","endDate","mileage","additionalCharge","gst","discount","totalAmount",
                                 "totalPaid","amountDue","statusPaid","status","locumFees","reasonAdditionalCharge","introducer","createdDate","createdId","nurseVisit","doktorVisit","nurseVisitDays", "doctorVisitDays", "physioDays");

  var $debugMsg;
  
  function initImportFieldManager() {
    foreach($this->validParamInputs as $x => $x_value) {
      $this->importFieldList[] = ImportFieldFactory::create($x, $x_value);
      if($x_value === "Problem")
          $this->importFieldList[$x]->setSpecialForProblem(TRUE);
    }
  }
  
  function parseData($inputStrings) {
    for ($i = 0; $i < count($this->importFieldList); $i++) {
      $this->importFieldList[$i]->parseInputString($inputStrings);
      //print_r($this->importFieldList[$i]->getInputData());
      //echo "<br>";
    }
    
  }
  
  function getInputData() {
    for ($i = 0; $i < count($this->importFieldList); $i++) {
      print_r($this->importFieldList[$i]->getInputData());
      echo "<br>";
    }
  }
  
  function getInputDataByName($name) {
    for ($i = 0; $i < count($this->importFieldList); $i++) {
      if($name === $this->importFieldList[$i]->getInputName())
          return($this->importFieldList[$i]->getInputDataByName());
    }
  }
  
  function setInputDataByName($name,$value) {
    for ($i = 0; $i < count($this->importFieldList); $i++) {
      if($name === $this->importFieldList[$i]->getInputName())
          $this->importFieldList[$i]->setInputDataByName($value);
    }
  }
  
  function toString() {
    for ($i = 0; $i < count($this->importFieldList); $i++) {
      print_r($this->importFieldList[$i]->toString());
      echo "<br>";
    }
    
  }
  
  function showDebug() {
    
    echo $this->debugMsg;
  }
  
  function getPhysioCharging($physiotherapy,$physioDays) {
      // 1st Session: RM 230
      // 22/8/2016 4:17PM : Tukar 1st session kpd RM250
      // Subsequent Visits: RM 180
      $totalCharge = 0;
      if($physiotherapy === 'yes' && $physioDays > 0) {
          $totalCharge = 250;
          if( ($physioDays-1) > 0 )$totalCharge = $totalCharge + ($physioDays-1)*180;
      } 
      
      return $totalCharge;
      
  }
  
  function getNurseCharging($activated,$activateDays) {
      // 1st Session: RM 250
      // Subsequent Visits: RM 220
      $totalCharge = 0;
      if($activated === 'yes' && $activateDays > 0) {
          $totalCharge = 250;
          if( ($activateDays-1) > 0 )$totalCharge = $totalCharge + ($activateDays-1)*220;
      } 
      
      return $totalCharge;
      
  }
  
  function getDoctorCharging($activated,$activateDays) {
      // 1st Session: RM 380
      // Subsequent Visits: RM 380
      $totalCharge = 0;
      if($activated === 'yes' && $activateDays > 0) {
          $totalCharge = 380;
          if( ($activateDays-1) > 0 )$totalCharge = $totalCharge + ($activateDays-1)*380;
      } 
      
      return $totalCharge;
      
  }
  function insertIntoDb($userid) {
    /*
    1st - insert into contact for both customer and patient
    INSERT INTO contacts(id,contactTypeId,firstName,createdDate,createdId)
    VALUES (1,1,'En Juzaili IJN',Now(),0);
    
    2nd - insert into quotation
    INSERT INTO quotations(id,customerId,patientId,quotationDate,hourPerDay,dayPerWeek,basicCharge,mileage,adminFee,gst,totalAmount,amountDue,statusPaid,status,createdDate,createdId)
    VALUES(2,3,4,'2016-07-10',12,5,1300.00,100.00,150.00,15.00,1565.00,0.00,1,0,Now(),0);
    
    3rd - insert into quotationNotes
    INSERT INTO quotationnotes(id,quotationId,note,createdDate,createdId)
    VALUES (1,3,'Caregiver service for Sa\'adiah Mohd Jani Parkinson, need assistant in mobile, hard to sleep at night, strong asthma, diabetic, need assistant to feed food',Now(),0);



    */
    
        $debugMsg = "";
      
        $dbm = new DBManager();
        $conn = $dbm->getConnection();
      
      // insert customer data
      /*$sql_stmt = "INSERT INTO contacts(contactTypeId,firstName,ic,address,email,mobile,office,createdDate,createdId)".
                  "VALUES (1,'".mysqli_real_escape_string($this->getInputDataByName("Name"))."'".
                  ",'".mysqli_real_escape_string($this->getInputDataByName("I/C No."))."'".
                  ",'".mysqli_real_escape_string($this->getInputDataByName("Address"))."'".
                  ",'".mysqli_real_escape_string($this->getInputDataByName("E-Mail"))."'".
                  ",'".mysqli_real_escape_string($this->getInputDataByName("Contact No.1"))."'".
                  ",'".mysqli_real_escape_string($this->getInputDataByName("Contact No.2"))."'".
                  ",Now(),".$userid.")";
      */
        $sql_stmt = "INSERT INTO contacts(contactTypeId,firstName,ic,address,email,mobile,office,createdDate,createdId)".
                    "VALUES (1,:Name,:ICNo,:Address,:Email,:ContactNo1,:ContactNo2,Now(),:UserId)";
                  
        $debugMsg = $debugMsg."<br>Insert Customer data:".$sql_stmt."<br>";
        
        $stmt = $conn->prepare($sql_stmt);
        $retval = $stmt->execute(array(':Name' => $this->getInputDataByName("Name"), ':ICNo' => $this->getInputDataByName("I/C No."),
                             ':Address' => $this->getInputDataByName("Address"), ':Email' => $this->getInputDataByName("E-Mail"),
                             ':ContactNo1' => $this->getInputDataByName("Contact No.1"), ':ContactNo2' => $this->getInputDataByName("Contact No.2"),
                             ':UserId' => $userid));
        
        //check if SQL query is successful
        if(!$retval ){
            $this->debugMsg = $debugMsg;
            return $retval;
        }
      
        $newCustomerId = $conn->lastInsertId();
      
        /*
        // insert patient data
        $sql_stmt = "INSERT INTO contacts(contactTypeId,firstName,ic,address,createdDate,createdId)".
                    "VALUES (2,'".mysqli_real_escape_string($this->getInputDataByName("Patient Name"))."'".
                    ",'".mysqli_real_escape_string($this->getInputDataByName("Patient I/C No."))."'".
                    ",'".mysqli_real_escape_string($this->getInputDataByName("Patient Address"))."'".
                    ",Now(),".$userid.")";
        */
        $sql_stmt = "INSERT INTO contacts(contactTypeId,firstName,ic,address,createdDate,createdId)".
                    "VALUES (2,:PatientName,:PatientIC,:PatientAddress,Now(),:UserId)";
        
        $debugMsg = $debugMsg."<br>Insert Patient data:".$sql_stmt."<br>";
        
        $stmt = $conn->prepare($sql_stmt);
        $retval = $stmt->execute(array(':PatientName' => $this->getInputDataByName("Patient Name"), ':PatientIC' => $this->getInputDataByName("Patient I/C No."),
                             ':PatientAddress' => $this->getInputDataByName("Patient Address"),
                             ':UserId' => $userid));            
    
        //check if SQL query is successful
        if(!$retval ){
          $this->debugMsg = $debugMsg;
          return $retval;
        }
        
        $newPatiendId = $conn->lastInsertId();
         
        /*// insert quotations data
        $sql_stmt = "INSERT INTO quotations(customerId,patientId,quotationDate,createdDate,createdId)".
                    "VALUES (".$newCustomerId .
                    ",".$newPatiendId .
                    ",CURDATE()".
                    ",Now(),".$userid.")";
        */
        $sql_stmt = "INSERT INTO quotations(customerId,patientId,quotationDate,statusPaid,hourPerDay,dayPerWeek,feeFor,basicCharge,createdDate,createdId)".
                    "VALUES (:NewCustomerId,:NewPatiendId,CURDATE(),0,5,5,'Caregiver',160,Now(),:UserId)";            
        $debugMsg = $debugMsg."<br>Insert quotations data:".$sql_stmt."<br>";
        
        $stmt = $conn->prepare($sql_stmt);
        $retval = $stmt->execute(array(':NewCustomerId' => $newCustomerId, ':NewPatiendId' => $newPatiendId,
                                       ':UserId' => $userid));            
    
        //check if SQL query is successful
        if(! $retval ){
          $this->debugMsg = $debugMsg;
          return $retval;
        }
        
        $newQuotationId = $conn->lastInsertId();
      
        // insert quotationNotes data
        /*
        $sql_stmt = "INSERT INTO quotationnotes(quotationId,note,createdDate,createdId)".
                    "VALUES (".$newQuotationId .
                    ",'".mysqli_real_escape_string($this->getInputDataByName("Problem"))."'".
                    ",Now(),".$userid.")";
        */            
        $sql_stmt = "INSERT INTO quotationnotes(quotationId,note,createdDate,createdId)".
                    "VALUES (:NewQuotationId,:Problem ,Now(),:UserId)";
        $debugMsg = $debugMsg."<br>Insert quotationnotes data:".$sql_stmt."<br>";
        
        $stmt = $conn->prepare($sql_stmt);
        $retval = $stmt->execute(array(':NewQuotationId' => $newQuotationId, ':Problem' => $this->getInputDataByName("Problem"),
                                       ':UserId' => $userid));            
    
        //check if SQL query is successful
        if(! $retval ){
          $this->debugMsg = $debugMsg;
          return $retval;
        }
        
        $newquotationNotesId = $conn->lastInsertId();
      
        $this->debugMsg = $debugMsg;
        return $retval;
    
  }
  
  function updateQuotationCharge($userid) {
      
      $debugMsg = "";
      
      $dbm = new DBManager();
      $conn = $dbm->getConnection();
      /*
      $datetime1 = new DateTime($this->getInputDataByName("startDate"));
      $datetime2 = new DateTime($this->getInputDataByName("endDate"));
      $interval = $datetime1->diff($datetime2);
      $totalDays = $interval->days + 1; //if start and end the same date - it considered as 1 day
      
      if($this->getInputDataByName("chargeMode") === 'Monthly') $totalDays = 20;  //For monthly, we will fixed it to 20 days
      */
      // user insert it manually... the total days
      $totalDays = $this->getInputDataByName("chargeDays");
      
      /*
      
      $gst = ($this->getInputDataByName("adminFees")*0.06) + ($this->getInputDataByName("mileage")*0.06)  + ($this->getInputDataByName("additionalCharge")*0.06) ;
      
      $totalCharge = ($totalDays * $this->getInputDataByName("basicCharge")) + $this->getInputDataByName("adminFees") + 
                     $this->getInputDataByName("mileage") + $this->getInputDataByName("additionalCharge") + $gst;
      */
      
      // if additional is not included in the total charge
      
      
      $chargePhysio = $this->getPhysioCharging($this->getInputDataByName("physiotherapy"),$this->getInputDataByName("physioDays"));
      $chargeNurse = $this->getNurseCharging($this->getInputDataByName("nurseVisit"),$this->getInputDataByName("nurseVisitDays"));
      $chargeDoctor = $this->getDoctorCharging($this->getInputDataByName("doktorVisit"),$this->getInputDataByName("doctorVisitDays"));
      
      if($totalDays > 0) {
        $gst = ($this->getInputDataByName("adminFees")*0.06) + ($this->getInputDataByName("mileage")*$totalDays*0.06);
        $chargeCareGiver = ($totalDays * $this->getInputDataByName("basicCharge")) + $this->getInputDataByName("adminFees") + 
                            ($totalDays * $this->getInputDataByName("mileage"))+  $this->getInputDataByName("additionalCharge");
      } else {
        $gst = 0;
        $chargeCareGiver = 0;
      }
      
      $totalCharge = $chargeCareGiver + $gst +
                     $chargePhysio + $chargeNurse + $chargeDoctor;
                     
      // update quotation table
      /*
      $sql_stmt = "UPDATE quotations SET chargeMode='".mysqli_real_escape_string($this->getInputDataByName("chargeMode"))."'".
                  ",feeFor='".mysqli_real_escape_string($this->getInputDataByName("feeFor"))."'".
                  ",basicCharge='".mysqli_real_escape_string($this->getInputDataByName("basicCharge"))."'".
                  ",hourPerDay='".mysqli_real_escape_string($this->getInputDataByName("hoursPerDay"))."'".
                  ",dayPerWeek='".mysqli_real_escape_string($this->getInputDataByName("daysPerWeek"))."'".
                  ",startDate='".mysqli_real_escape_string($this->getInputDataByName("startDate"))."'".
                  ",endDate='".mysqli_real_escape_string($this->getInputDataByName("endDate"))."'".
                  ",mileage='".mysqli_real_escape_string($this->getInputDataByName("mileage"))."'".
                  ",physiotherapy='".mysqli_real_escape_string($this->getInputDataByName("physiotherapy"))."'".
                  ",nurseVisit='".mysqli_real_escape_string($this->getInputDataByName("nurseVisit"))."'".
                  ",doktorVisit='".mysqli_real_escape_string($this->getInputDataByName("doktorVisit"))."'".
                  ",nurseVisitDays='".mysqli_real_escape_string($this->getInputDataByName("nurseVisitDays"))."'".
                  ",doctorVisitDays='".mysqli_real_escape_string($this->getInputDataByName("doctorVisitDays"))."'".
                  ",physioDays='".mysqli_real_escape_string($this->getInputDataByName("physioDays"))."'".
                  ",chargeDays='".$totalDays."'".
                  ",adminFee='".mysqli_real_escape_string($this->getInputDataByName("adminFees"))."'".
                  ",additionalCharge='".mysqli_real_escape_string($this->getInputDataByName("additionalCharge"))."'".
                  ",gst='".$gst."'".
                  ",totalAmount='".$totalCharge."'".
                  ",quotationNo=quotationNo+1".
                  " WHERE id=".mysqli_real_escape_string($this->getInputDataByName("id")).";";
      */            
      $sql_stmt = "UPDATE quotations SET chargeMode=?,feeFor=?,basicCharge=?,hourPerDay=?,dayPerWeek=?,startDate=?,endDate=?,mileage=?".
                  ",physiotherapy=?,nurseVisit=?,doktorVisit=?,nurseVisitDays=?,doctorVisitDays=?,physioDays=?,chargeDays=?".
                  ",adminFee=?,additionalCharge=?,gst=?,totalAmount=?,quotationNo=quotationNo+1".
                  " WHERE id=?";
                  
      $debugMsg = $debugMsg."<br>Update  Quotation data:".$sql_stmt."<br>";
      
      $stmt = $conn->prepare($sql_stmt);
      $retval = $stmt->execute(array($this->getInputDataByName("chargeMode"),$this->getInputDataByName("feeFor"),
                $this->getInputDataByName("basicCharge"),$this->getInputDataByName("hoursPerDay"),$this->getInputDataByName("daysPerWeek"),
                $this->getInputDataByName("startDate"),$this->getInputDataByName("endDate"),$this->getInputDataByName("mileage"),
                $this->getInputDataByName("physiotherapy"),$this->getInputDataByName("nurseVisit"),$this->getInputDataByName("doktorVisit"),
                $this->getInputDataByName("nurseVisitDays"),$this->getInputDataByName("doctorVisitDays"),$this->getInputDataByName("physioDays"),
                $totalDays,$this->getInputDataByName("adminFees"),$this->getInputDataByName("additionalCharge"),
                $gst,$totalCharge,$this->getInputDataByName("id")
                ));
      
      //check if SQL query is successful
      if(! $retval ){
        $this->debugMsg = $debugMsg;
        return $retval;
      }
      
      $this->debugMsg = $debugMsg;
      return $retval;
  }
  
  function getQuotationById($id) {
    
    $quotations = new Quotations();
    $quotations->id = $id;
    $quotations->selectById();
    
    $this->setInputDataByName("id",$id);
    $this->setInputDataByName("Name",$quotations->customerData->firstName);
    $this->setInputDataByName("contactCode",$quotations->customerData->contactCode);
    $this->setInputDataByName("I/C No.",$quotations->customerData->ic);
    $this->setInputDataByName("Address",$quotations->customerData->address);
    $this->setInputDataByName("E-Mail",$quotations->customerData->email);
    $this->setInputDataByName("Contact No.1",$quotations->customerData->mobile);
    $this->setInputDataByName("Contact No.2",$quotations->customerData->office);
    
    $this->setInputDataByName("Patient Name",$quotations->patientData->firstName);
    $this->setInputDataByName("Patient I/C No.",$quotations->patientData->ic);
    $this->setInputDataByName("Patient Address",$quotations->patientData->address);
    
    $allNotes = "";
    foreach($quotations->noteListData as $quotationNote) {
        $allNotes = $allNotes.$quotationNote->note;
    }
    $this->setInputDataByName("Problem",$allNotes);
    
    $this->setInputDataByName("hoursPerDay",$quotations->hourPerDay); // **it different
    $this->setInputDataByName("daysPerWeek",$quotations->dayPerWeek); // **it different
    $this->setInputDataByName("adminFees",$quotations->adminFee); // **it different
    
    $this->setInputDataByName("quotationNo",$quotations->quotationNo);
    $this->setInputDataByName("chargeMode",$quotations->chargeMode);
    $this->setInputDataByName("feeFor",$quotations->feeFor);
    $this->setInputDataByName("physiotherapy",$quotations->physiotherapy);
    $this->setInputDataByName("nurseVisit",$quotations->nurseVisit);
    $this->setInputDataByName("doktorVisit",$quotations->doktorVisit);
    $this->setInputDataByName("nurseVisitDays",$quotations->nurseVisitDays);
    $this->setInputDataByName("doctorVisitDays",$quotations->doctorVisitDays);
    $this->setInputDataByName("physioDays",$quotations->physioDays);
    $this->setInputDataByName("chargeDays",$quotations->chargeDays);
    $this->setInputDataByName("customerId",$quotations->customerId);
    $this->setInputDataByName("patientId",$quotations->patientId);
    $this->setInputDataByName("quotationDate",$quotations->quotationDate);
    $this->setInputDataByName("basicCharge",$quotations->basicCharge);
    $this->setInputDataByName("startTimeDaily",$quotations->startTimeDaily);
    $this->setInputDataByName("endTimeDaily",$quotations->endTimeDaily);
    $this->setInputDataByName("startDate",$quotations->startDate);
    $this->setInputDataByName("endDate",$quotations->endDate);
    $this->setInputDataByName("mileage",$quotations->mileage);
    $this->setInputDataByName("additionalCharge",$quotations->additionalCharge);
    $this->setInputDataByName("gst",$quotations->gst);
    $this->setInputDataByName("discount",$quotations->discount);
    $this->setInputDataByName("totalAmount",$quotations->totalAmount);
    $this->setInputDataByName("totalPaid",$quotations->totalPaid);
    $this->setInputDataByName("amountDue",$quotations->amountDue);
    $this->setInputDataByName("statusPaid",$quotations->statusPaid);
    $this->setInputDataByName("status",$quotations->status);
    $this->setInputDataByName("locumFees",$quotations->locumFees);
    $this->setInputDataByName("reasonAdditionalCharge",$quotations->reasonAdditionalCharge);
    $this->setInputDataByName("introducer",$quotations->introducer);
    $this->setInputDataByName("createdDate",$quotations->createdDate);
    $this->setInputDataByName("createdId",$quotations->createdId);
    
  }
  
  function deleteQuotationById($id) {
    
    $quotations = new Quotations();
    $quotations->id = $id;
    $quotations->deleteQuotationById();
  }
 
  function closeDealQuotationById($id) {

    $quotations = new Quotations();
    $quotations->id = $id;
    $quotations->closeDealQuotationById();
  }

  function cancelCloseDealQuotationById($id) {

    $quotations = new Quotations();
    $quotations->id = $id;
    $quotations->cancelCloseDealQuotationById();
  }
 
  function updateQuotationInquiry($userid) {
      
      $debugMsg = "";
      
      $dbm = new DBManager();
      $conn = $dbm->getConnection();
      
      // update customer data
      /*
      $sql_stmt = "UPDATE contacts SET firstName='".mysqli_real_escape_string($this->getInputDataByName("Name"))."'".
                  ",ic='".mysqli_real_escape_string($this->getInputDataByName("I/C No."))."'".
                  ",address='".mysqli_real_escape_string($this->getInputDataByName("Address"))."'".
                  ",email='".mysqli_real_escape_string($this->getInputDataByName("E-Mail"))."'".
                  ",mobile='".mysqli_real_escape_string($this->getInputDataByName("Contact No.1"))."'".
                  ",office='".mysqli_real_escape_string($this->getInputDataByName("Contact No.2"))."'".
                  " WHERE id=".mysqli_real_escape_string($this->getInputDataByName("customerId")).";";
      */
      $sql_stmt = "UPDATE contacts SET contactCode=?,firstName=?,ic=?,address=?,email=?,mobile=?,office=? WHERE id=?;";
      
      $debugMsg = $debugMsg."<br>Update Customer data:".$sql_stmt."<br>contactCode=".$this->getInputDataByName("contactCode").".customerId=".$this->getInputDataByName("customerId");
      
      $stmt = $conn->prepare($sql_stmt);
      $retval = $stmt->execute(array($this->getInputDataByName("contactCode"),$this->getInputDataByName("Name"),$this->getInputDataByName("I/C No."),
                $this->getInputDataByName("Address"),$this->getInputDataByName("E-Mail"),$this->getInputDataByName("Contact No.1"),
                $this->getInputDataByName("Contact No.2"),$this->getInputDataByName("customerId")
                ));
  
      //check if SQL query is successful
      if(! $retval ){
        $this->debugMsg = $debugMsg;
        return $retval;
      }
      
      // update patient data
      /*
      $sql_stmt = "UPDATE contacts SET firstName='".mysqli_real_escape_string($this->getInputDataByName("Patient Name"))."'".
                  ",ic='".mysqli_real_escape_string($this->getInputDataByName("Patient I/C No."))."'".
                  ",address='".mysqli_real_escape_string($this->getInputDataByName("Patient Address"))."'".
                  " WHERE id=".mysqli_real_escape_string($this->getInputDataByName("patientId")).";";
      */
      $sql_stmt = "UPDATE contacts SET firstName=?,ic=?,address=? WHERE id=?;";
      
      $debugMsg = $debugMsg."<br>Update Patient data:".$sql_stmt."<br>";
      
      $stmt = $conn->prepare($sql_stmt);
      $retval = $stmt->execute(array($this->getInputDataByName("Patient Name"),$this->getInputDataByName("Patient I/C No."),
                $this->getInputDataByName("Patient Address"),$this->getInputDataByName("patientId")
                ));
  
      //check if SQL query is successful
      if(! $retval ){
        $this->debugMsg = $debugMsg;
        return $retval;
      }
      
      
      // update Quotation Notes
      // 1st delete the old ones, then insert the new one
      /*
      $sql_stmt = "DELETE FROM quotationnotes WHERE quotationId=".mysqli_real_escape_string($this->getInputDataByName("id")).";";
      */
      
      $sql_stmt = "DELETE FROM quotationnotes WHERE quotationId=?;";
      $debugMsg = $debugMsg."<br>Delete Quotation Notes data:".$sql_stmt."<br>";
      $stmt = $conn->prepare($sql_stmt);
      $retval = $stmt->execute(array($this->getInputDataByName("id")));
      //check if SQL query is successful
      if(! $retval ){
        $this->debugMsg = $debugMsg;
        return $retval;
      }
      
      // insert quotationNotes data
      /*
      $sql_stmt = "INSERT INTO quotationnotes(quotationId,note,createdDate,createdId)".
                  "VALUES (".mysqli_real_escape_string($this->getInputDataByName("id")) .
                  ",'".mysqli_real_escape_string($this->getInputDataByName("Problem"))."'".
                  ",Now(),".$userid.")";
      */            
      $sql_stmt = "INSERT INTO quotationnotes(quotationId,note,createdDate,createdId)".
                  "VALUES (:id,:Problem,Now(),:UserId)";
      $debugMsg = $debugMsg."<br>Insert quotationnotes data:".$sql_stmt."<br>";
      
      //place in retval result of the SQL query
      $stmt = $conn->prepare($sql_stmt);
      $retval = $stmt->execute(array(':id' => $this->getInputDataByName("id"), ':Problem' => $this->getInputDataByName("Problem"),
                                     ':UserId' => $userid));            
    
  
      //check if SQL query is successful
      if(! $retval ){
        $this->debugMsg = $debugMsg;
        return $retval;
      }
      
      // The full quotation data
      // update quotation table
      // I'll re-calculate
      $totalDays = $this->getInputDataByName("chargeDays");
      $chargePhysio = $this->getPhysioCharging($this->getInputDataByName("physiotherapy"),$this->getInputDataByName("physioDays"));
      $chargeNurse = $this->getNurseCharging($this->getInputDataByName("nurseVisit"),$this->getInputDataByName("nurseVisitDays"));
      $chargeDoctor = $this->getDoctorCharging($this->getInputDataByName("doktorVisit"),$this->getInputDataByName("doctorVisitDays"));
      
      if($totalDays > 0) {
        //$gst = ($this->getInputDataByName("adminFees")*0.06) + ($this->getInputDataByName("mileage")*$totalDays*0.06);
        $chargeCareGiver = ($totalDays * $this->getInputDataByName("basicCharge")) + $this->getInputDataByName("adminFees") + 
                            ($totalDays * $this->getInputDataByName("mileage"))+  $this->getInputDataByName("additionalCharge");
      } else {
        //$gst = 0;
        $chargeCareGiver = 0;
      }
      $subTotalAmount = $chargeCareGiver + $chargePhysio + $chargeNurse + $chargeDoctor;
      $gst = $subTotalAmount*0.00;  // $gst = $subTotalAmount*0.06;
      $totalCharge = $subTotalAmount + $gst;
      /*
      $sql_stmt = "UPDATE quotations SET ".
                  " hourPerDay='".mysqli_real_escape_string($this->getInputDataByName("hoursPerDay"))."'".
                  ",dayPerWeek='".mysqli_real_escape_string($this->getInputDataByName("daysPerWeek"))."'".
                  ",adminFee='".mysqli_real_escape_string($this->getInputDataByName("adminFees"))."'".
                  ",quotationNo='".mysqli_real_escape_string($this->getInputDataByName("quotationNo"))."'".
                  ",chargeMode='".mysqli_real_escape_string($this->getInputDataByName("chargeMode"))."'".
                  ",feeFor='".mysqli_real_escape_string($this->getInputDataByName("feeFor"))."'".
                  ",physiotherapy='".mysqli_real_escape_string($this->getInputDataByName("physiotherapy"))."'".
                  ",nurseVisit='".mysqli_real_escape_string($this->getInputDataByName("nurseVisit"))."'".
                  ",doktorVisit='".mysqli_real_escape_string($this->getInputDataByName("doktorVisit"))."'".
                  ",nurseVisitDays='".mysqli_real_escape_string($this->getInputDataByName("nurseVisitDays"))."'".
                  ",doctorVisitDays='".mysqli_real_escape_string($this->getInputDataByName("doctorVisitDays"))."'".
                  ",physioDays='".mysqli_real_escape_string($this->getInputDataByName("physioDays"))."'".
                  ",chargeDays='".mysqli_real_escape_string($this->getInputDataByName("chargeDays"))."'".
                  ",quotationDate='".mysqli_real_escape_string($this->getInputDataByName("quotationDate"))."'".
                  ",basicCharge='".mysqli_real_escape_string($this->getInputDataByName("basicCharge"))."'".
                  ",startTimeDaily='".mysqli_real_escape_string($this->getInputDataByName("startTimeDaily"))."'".
                  ",endTimeDaily='".mysqli_real_escape_string($this->getInputDataByName("endTimeDaily"))."'".
                  ",startDate='".mysqli_real_escape_string($this->getInputDataByName("startDate"))."'".
                  ",endDate='".mysqli_real_escape_string($this->getInputDataByName("endDate"))."'".
                  ",mileage='".mysqli_real_escape_string($this->getInputDataByName("mileage"))."'".
                  ",additionalCharge='".mysqli_real_escape_string($this->getInputDataByName("additionalCharge"))."'".
                  ",gst='".$gst."'".
                  ",discount='".mysqli_real_escape_string($this->getInputDataByName("discount"))."'".
                  ",totalAmount='".$totalCharge."'".
                  ",totalPaid='".mysqli_real_escape_string($this->getInputDataByName("totalPaid"))."'".
                  ",amountDue='".mysqli_real_escape_string($this->getInputDataByName("amountDue"))."'".
                  ",statusPaid='".mysqli_real_escape_string($this->getInputDataByName("statusPaid"))."'".
                  ",status='".mysqli_real_escape_string($this->getInputDataByName("status"))."'".
                  " WHERE id=".mysqli_real_escape_string($this->getInputDataByName("id")).";";
      */            
      $sql_stmt = "UPDATE quotations SET hourPerDay=?,dayPerWeek=?,adminFee=?,quotationNo=?,chargeMode=?".
                  ",feeFor=?,physiotherapy=?,nurseVisit=?,doktorVisit=?,nurseVisitDays=?,doctorVisitDays=?".
                  ",physioDays=?,chargeDays=?,quotationDate=?,basicCharge=?,startTimeDaily=?".
                  ",endTimeDaily=?,startDate=?,endDate=?,mileage=?,additionalCharge=?,gst=?".
                  ",discount=?,totalAmount=?,subTotalAmount=?,totalPaid=?,amountDue=?,statusPaid=?,status=?".
                  ",locumFees=?,reasonAdditionalCharge=?, introducer=? WHERE id=?;";
      
      $debugMsg = $debugMsg."<br>Update  Quotation data:".$sql_stmt."<br>";
      
      //place in retval result of the SQL query
      $stmt = $conn->prepare($sql_stmt);
      $retval = $stmt->execute(array($this->getInputDataByName("hoursPerDay"),$this->getInputDataByName("daysPerWeek"),
                $this->getInputDataByName("adminFees"),$this->getInputDataByName("quotationNo"),$this->getInputDataByName("chargeMode"),
                $this->getInputDataByName("feeFor"),$this->getInputDataByName("physiotherapy"),$this->getInputDataByName("nurseVisit"),
                $this->getInputDataByName("doktorVisit"),$this->getInputDataByName("nurseVisitDays"),$this->getInputDataByName("doctorVisitDays"),
                $this->getInputDataByName("physioDays"),$this->getInputDataByName("chargeDays"),$this->getInputDataByName("quotationDate"),
                $this->getInputDataByName("basicCharge"),$this->getInputDataByName("startTimeDaily"),$this->getInputDataByName("endTimeDaily"),
                $this->getInputDataByName("startDate"),$this->getInputDataByName("endDate"),$this->getInputDataByName("mileage"),
                $this->getInputDataByName("additionalCharge"),$gst,$this->getInputDataByName("discount"),
                $totalCharge,$subTotalAmount,$this->getInputDataByName("totalPaid"),$this->getInputDataByName("amountDue"),
                $this->getInputDataByName("statusPaid"),$this->getInputDataByName("status"),$this->getInputDataByName("locumFees"),
                $this->getInputDataByName("reasonAdditionalCharge"),$this->getInputDataByName("introducer"),$this->getInputDataByName("id")
                ));
  
      //check if SQL query is successful
      if(! $retval ){
        $this->debugMsg = $debugMsg;
        return $retval;
      }
      
      $this->debugMsg = $debugMsg;
      return $retval;
  }

}
?>
