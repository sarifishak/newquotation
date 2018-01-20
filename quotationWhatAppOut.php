<?php
  require_once 'fpdf/fpdf.php';
  require_once 'users.php';
  require_once 'userTypes.php';
  require_once 'contacts.php';
  require_once 'contactTypes.php';
  require_once 'quotations.php';
  require_once 'quotationNotes.php';
  require_once 'class/importFieldManager.php';
?>

<html>
  <head>
    <title>WhatApp Quotation</title>
  </head>
  <body>
  <?php
    $quotations = new Quotations();      
    //initialize fields of user object with the columns retrieved from the query
    $quotations->id = $_REQUEST['id'];
    $quotations->selectById();
    
    $customerName = $quotations->customerData->firstName.' '.$quotations->customerData->lastName;
    $customerCode = $quotations->customerData->contactCode;
    $customerAddress = $quotations->customerData->address.' '.$quotations->customerData->city.' '.$quotations->customerData->postcode.' '.$quotations->customerData->state;
    $patientName = $quotations->patientData->firstName.' '.$quotations->patientData->lastName;
    $patientIC = $quotations->patientData->ic;
    $patientAddress = $quotations->patientData->address.' '.$quotations->patientData->city.' '.$quotations->patientData->postcode.' '.$quotations->patientData->state;
    $servicesStartDate = $quotations->startDate;
    $servicesStartTime = $quotations->startTimeDaily;
    $totalDays = $quotations->chargeDays;
    
    if($totalDays < 20 ) {
        $quotationSummary = $quotations->hourPerDay.'-hour care / '.$quotations->dayPerWeek.' days a week';
    } else {
        $quotationSummary = $quotations->hourPerDay.'-hour care / '.$quotations->dayPerWeek.' days a week / '.$totalDays.' days a month';
    }
    
    $requestNote ='';
    
    foreach($quotations->noteListData as $quotationNote) {
        $requestNote = $requestNote.$quotationNote->note.'</br>';
    }
  
  ?>
    <p>WhatApp Quotation</p>  
    <p>Code:<?php echo $customerCode; ?>
</br>Services:<?php echo strtoupper($quotationSummary); ?>
</br>Start services:<?php echo $servicesStartDate; ?>
</br>Start time:<?php echo $servicesStartTime; ?>
</br>Patient Name:<?php echo $patientName; ?>
</br>Patient I/C No:<?php echo $patientIC; ?>
</br>Patient Address:<?php echo $patientAddress; ?>
</br>Problem:<?php echo $requestNote; ?>
    </p>
  </body>
</html>  