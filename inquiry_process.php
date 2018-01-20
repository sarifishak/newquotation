<?php
  require_once 'users.php';
  require_once 'userTypes.php';
  require_once 'contacts.php';
  require_once 'contactTypes.php';
  require_once 'quotations.php';
  require_once 'quotationNotes.php';
  require_once 'class/importFieldManager.php';
?>
<?php
   session_start();

  // start the main function
  $importStage = $_REQUEST['importStage'];
  
  if($importStage === 'first') {
    $inquiryData = $_REQUEST['inquiryData'];
    $inquiryDataProc = preg_split ('/$\R?^/m', $inquiryData); //A line break is defined differently on different platforms, \r\n, \r or \n.
                                                              //Using RegExp to split the string you can match all three with \R
    
    //for ($i = 0; $i < count($inquiryDataProc); $i++) {
    //  echo "[".$i."]".$inquiryDataProc[$i];
    //  echo "<br>";
    //}
    
    $importFieldManager = new ImportFieldManager();
    $importFieldManager->initImportFieldManager();
    $importFieldManager->parseData($inquiryDataProc); 
    
    $_SESSION['importFieldManager'] = serialize($importFieldManager);
    header('Location: newInquiryPage2.php');
    //echo "<br/>The unserialize data is <br/>";
    //echo $_SESSION['importFieldManager'];
    //$importField = unserialize($_SESSION['importFieldManager']);
    //$importField->getInputData();
    
  } else if($importStage === 'second') {
      
      $name = $_REQUEST['name'];
      $contactCode = $_REQUEST['contactCode'];
      $ic = $_REQUEST['ic'];
      $address = $_REQUEST['address'];
      $mail = $_REQUEST['mail'];
      $contact1 = $_REQUEST['contact1'];
      $contact2 = $_REQUEST['contact2'];
      $patientname = $_REQUEST['patientname'];
      $patientic = $_REQUEST['patientic'];
      $patientaddress = $_REQUEST['patientaddress'];
      $problem = $_REQUEST['problem'];
      
      $importFieldManager = new ImportFieldManager();
      $importFieldManager->initImportFieldManager();
      
      $importFieldManager->setInputDataByName("Name",$name);
      $importFieldManager->setInputDataByName("contactCode",$contactCode);
      $importFieldManager->setInputDataByName("I/C No.",$ic);
      $importFieldManager->setInputDataByName("Address",$address);
      $importFieldManager->setInputDataByName("E-Mail",$mail);
      $importFieldManager->setInputDataByName("Contact No.1",$contact1);
      $importFieldManager->setInputDataByName("Contact No.2",$contact2);
      $importFieldManager->setInputDataByName("Patient Name",$patientname);
      $importFieldManager->setInputDataByName("Patient I/C No.",$patientic);
      $importFieldManager->setInputDataByName("Patient Address",$patientaddress);
      $importFieldManager->setInputDataByName("Problem",$problem);
      
      
      //echo "<br/>Berikut adalah data terbaru....<br/>";
      //echo $importFieldManager->toString();
      
      // insert into db
      $user = $_SESSION['current_user'];
      $retval = $importFieldManager->insertIntoDb($user->id);
      
      // in case there is an error
      if(! $retval ){
        $importFieldManager->showDebug();
      } else {
        //header($user->userTypeData->defaultPage);
        echo "<br/>Import successfull. Please close this and refresh the main page....";
      }
      
  } else if($importStage === 'editInquiry') {
    
      $id = $_REQUEST['id'];
      $customerId = $_REQUEST['customerId'];
      $patientId = $_REQUEST['patientId'];
      
      $name = $_REQUEST['name'];
      $contactCode = $_REQUEST['contactCode'];
      $ic = $_REQUEST['ic'];
      $address = $_REQUEST['address'];
      $mail = $_REQUEST['mail'];
      $contact1 = $_REQUEST['contact1'];
      $contact2 = $_REQUEST['contact2'];
      $patientname = $_REQUEST['patientname'];
      $patientic = $_REQUEST['patientic'];
      $patientaddress = $_REQUEST['patientaddress'];
      $problem = $_REQUEST['problem'];
      
      $importFieldManager = new ImportFieldManager();
      $importFieldManager->initImportFieldManager();
      
      $importFieldManager->setInputDataByName("id",$id);
      $importFieldManager->setInputDataByName("customerId",$customerId);
      $importFieldManager->setInputDataByName("patientId",$patientId);
      $importFieldManager->setInputDataByName("Name",$name);
      $importFieldManager->setInputDataByName("contactCode",$contactCode);
      $importFieldManager->setInputDataByName("I/C No.",$ic);
      $importFieldManager->setInputDataByName("Address",$address);
      $importFieldManager->setInputDataByName("E-Mail",$mail);
      $importFieldManager->setInputDataByName("Contact No.1",$contact1);
      $importFieldManager->setInputDataByName("Contact No.2",$contact2);
      $importFieldManager->setInputDataByName("Patient Name",$patientname);
      $importFieldManager->setInputDataByName("Patient I/C No.",$patientic);
      $importFieldManager->setInputDataByName("Patient Address",$patientaddress);
      $importFieldManager->setInputDataByName("Problem",$problem);
      /*
      The full quotation data
      */
      $importFieldManager->setInputDataByName("hoursPerDay",$_REQUEST['hoursPerDay']);
      $importFieldManager->setInputDataByName("daysPerWeek",$_REQUEST['daysPerWeek']);
      $importFieldManager->setInputDataByName("adminFees",$_REQUEST['adminFees']);
      $importFieldManager->setInputDataByName("quotationNo",$_REQUEST['quotationNo']);
      $importFieldManager->setInputDataByName("chargeMode",$_REQUEST['chargeMode']);
      $importFieldManager->setInputDataByName("feeFor",$_REQUEST['feeFor']);
      $importFieldManager->setInputDataByName("physiotherapy",$_REQUEST['physiotherapy']);
      $importFieldManager->setInputDataByName("nurseVisit",$_REQUEST['nurseVisit']);
      $importFieldManager->setInputDataByName("doktorVisit",$_REQUEST['doktorVisit']);
      $importFieldManager->setInputDataByName("physioDays",$_REQUEST['physioDays']);
      $importFieldManager->setInputDataByName("nurseVisitDays",$_REQUEST['nurseVisitDays']);
      $importFieldManager->setInputDataByName("doctorVisitDays",$_REQUEST['doctorVisitDays']);
      $importFieldManager->setInputDataByName("chargeDays",$_REQUEST['chargeDays']);
      $importFieldManager->setInputDataByName("quotationDate",$_REQUEST['quotationDate']);
      $importFieldManager->setInputDataByName("basicCharge",$_REQUEST['basicCharge']);
      $importFieldManager->setInputDataByName("startTimeDaily",$_REQUEST['startTimeDaily']);
      $importFieldManager->setInputDataByName("endTimeDaily",$_REQUEST['endTimeDaily']);
      $importFieldManager->setInputDataByName("startDate",$_REQUEST['startDate']);
      $importFieldManager->setInputDataByName("endDate",$_REQUEST['endDate']);
      $importFieldManager->setInputDataByName("mileage",$_REQUEST['mileage']);
      $importFieldManager->setInputDataByName("additionalCharge",$_REQUEST['additionalCharge']);
      $importFieldManager->setInputDataByName("gst",$_REQUEST['gst']);
      $importFieldManager->setInputDataByName("discount",$_REQUEST['discount']);
      $importFieldManager->setInputDataByName("totalAmount",$_REQUEST['totalAmount']);
      $importFieldManager->setInputDataByName("totalPaid",$_REQUEST['totalPaid']);
      $importFieldManager->setInputDataByName("amountDue",$_REQUEST['amountDue']);
      $importFieldManager->setInputDataByName("statusPaid",$_REQUEST['statusPaid']);
      $importFieldManager->setInputDataByName("status",$_REQUEST['status']);
      $importFieldManager->setInputDataByName("locumFees",$_REQUEST['locumFees']);
      
      
      
      
      //echo "<br/>Berikut adalah data terbaru....<br/>";
      //echo $importFieldManager->toString();
      
      // insert into db
      $user = $_SESSION['current_user'];
      $retval = $importFieldManager->updateQuotationInquiry($user->id);
      
      //$importFieldManager->showDebug();
      
      
      if(! $retval ){
        $importFieldManager->showDebug();
      } else {
        //header($user->userTypeData->defaultPage);
        //echo "<br/>Update successfull. Please close this and refresh the main page....";
        header('Location: quotationPdfOut.php?id='.$id);
      }
      
      
  } else {
    echo "<br/>Please contact your programmer, he just messed up with his code!!!<br/>";    
  }
  
?>
