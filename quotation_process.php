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
    $id = $_REQUEST['id'];
    $chargeMode = $_REQUEST['chargeMode'];
    $feeFor = $_REQUEST['feeFor'];
    $basicCharge = $_REQUEST['basicCharge'];
    
    $hoursPerDay = $_REQUEST['hoursPerDay'];
    $daysPerWeek = $_REQUEST['daysPerWeek'];
    $startDate = $_REQUEST['startDate'];
    $endDate = $_REQUEST['endDate'];
    $mileage = $_REQUEST['mileage'];
    $physiotherapy = $_REQUEST['physiotherapy'];
    $adminFees = $_REQUEST['adminFees'];
    $additionalCharge = $_REQUEST['additionalCharge'];
    
    //echo "<br/>Sabo lah yea....<br/>";
    //echo "<br/>Here is the data inserted<br/>";
    //echo "<br/>id:'".$id."'";
    //echo "<br/>chargeMode:'".$chargeMode."'";
    //echo "<br/>feeFor:'".$feeFor."'";
    //echo "<br/>basicCharge:'".$basicCharge."'";
    
    //echo "<br/>hoursPerDay:'".$hoursPerDay."'";
    //echo "<br/>daysPerWeek:'".$daysPerWeek."'";
    //echo "<br/>startDate:'".$startDate."'";
    //echo "<br/>endDate:'".$endDate."'";
    //echo "<br/>mileage:'".$mileage."'";
    //echo "<br/>physiotherapy:'".$physiotherapy."'";
    //echo "<br/>adminFees:'".$adminFees."'";
    //echo "<br/>additionalCharge:'".$additionalCharge."'";
    
    $importFieldManager = new ImportFieldManager();
    $importFieldManager->initImportFieldManager();
    
    $importFieldManager->setInputDataByName("id",$id);
    $importFieldManager->setInputDataByName("chargeMode",$chargeMode);
    $importFieldManager->setInputDataByName("feeFor",$feeFor);
    $importFieldManager->setInputDataByName("basicCharge",$basicCharge);
    
    $importFieldManager->setInputDataByName("hoursPerDay",$hoursPerDay);
    $importFieldManager->setInputDataByName("daysPerWeek",$daysPerWeek);
    $importFieldManager->setInputDataByName("startDate",$startDate);
    $importFieldManager->setInputDataByName("endDate",$endDate);
    $importFieldManager->setInputDataByName("mileage",$mileage);
    $importFieldManager->setInputDataByName("physiotherapy",$physiotherapy);
    $importFieldManager->setInputDataByName("nurseVisit",$_REQUEST['nurseVisit']);
    $importFieldManager->setInputDataByName("doktorVisit",$_REQUEST['doktorVisit']);
    $importFieldManager->setInputDataByName("physioDays",$_REQUEST['physioDays']);
    $importFieldManager->setInputDataByName("nurseVisitDays",$_REQUEST['nurseVisitDays']);
    $importFieldManager->setInputDataByName("doctorVisitDays",$_REQUEST['doctorVisitDays']);
    $importFieldManager->setInputDataByName("adminFees",$adminFees);
    $importFieldManager->setInputDataByName("additionalCharge",$additionalCharge);
    
    $importFieldManager->setInputDataByName("chargeDays",$_REQUEST['chargeDays']);
    
    //echo "<br/>Berikut adalah data di importFieldManager : ....<br/>";
    //echo $importFieldManager->toString();
    
    // insert into db
    $user = $_SESSION['current_user'];
    $retval = $importFieldManager->updateQuotationCharge($user->id);
      
    // in case there is an error
    if(! $retval ){
      $importFieldManager->showDebug();
    } else {
      //header($user->userTypeData->defaultPage);
      //echo "<br/>Only then display in PDF file<br/>";
      //header('Location: samplePdfOut.php?id='.$id);
      
      header('Location: quotationPdfOut.php?id='.$id);
      //$importFieldManager->showDebug();
    }
    
    
  } else {
      echo "<br/>Please contact your programmer, he just messed up with his code!!!<br/>";
  }  //if($importStage === 'first') {
  
?>
