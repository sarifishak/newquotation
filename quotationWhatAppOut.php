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
    
    $newServicedate = new DateTime($servicesStartDate);
    $newServicedateTime = new DateTime($servicesStartDate. ' ' .$servicesStartTime);

    
    $totalDays = $quotations->chargeDays;
    $locumFees = $quotations->locumFees;
    $quotationNo= $quotations->quotationNo;
    $quotationDate = $quotations->quotationDate;
    $quotationRef = substr($quotationDate,0,4).'/'.$quotationNo;
    
    
    if($totalDays < 20 ) {
        $quotationSummary = $quotations->hourPerDay.'-hour care / '.$quotations->dayPerWeek.' days a week';
    } else {
        $quotationSummary = $quotations->hourPerDay.'-hour care / '.$quotations->dayPerWeek.' days a week / '.$totalDays.' days a month';
    }
    
    $requestNote ='';
    
    foreach($quotations->noteListData as $quotationNote) {
        $requestNote = $requestNote.$quotationNote->note.'</br>';
    }
    
    /*$quotations->hourPerDay,$quotations->basicCharge,$quotations->startDate,$quotations->endDate,$quotations->mileage,
                     $quotations->adminFee,$quotations->gst,$quotations->totalAmount,$totalDays,$quotations->feeFor,
                     $quotations->physiotherapy,$quotationSummary,$quotations->additionalCharge,
                     $quotations->nurseVisit,$quotations->doktorVisit,$quotations->physioDays,$quotations->nurseVisitDays,$quotations->doctorVisitDays*/
    
    
    $intervalDays = $totalDays;
    
    
    $hourPerDay = $quotations->hourPerDay;
    $basicCharge = $quotations->basicCharge;
    $startDate = $quotations->startDate;
    $endDate = $quotations->endDate;
    $mileage = $quotations->mileage;
    $adminFee = $quotations->adminFee;
    $gst = $quotations->gst;
    $subTotalAmount = $quotations->subTotalAmount;
    $totalAmount = $quotations->totalAmount;
    $totalDays = $quotations->chargeDays;
    $feeFor = $quotations->feeFor;
    $physiotherapy = $quotations->physiotherapy;
    $additionalCharge = $quotations->additionalCharge;
    
    $nurseVisit = $quotations->nurseVisit;
    $doktorVisit = $quotations->doktorVisit;
    $physioDays = $quotations->physioDays;
    $nurseVisitDays = $quotations->nurseVisitDays;
    $doctorVisitDays = $quotations->doctorVisitDays;
  
  ?>
    <H1>Quotation for Customer</H1>  
    <p>Quotation:<?php echo $quotationRef; ?>
</br>Services:<?php echo strtoupper($quotationSummary); ?>
</br>Start services:<?php echo $newServicedate->format('dS M,Y'); ?>
</br>Start time:<?php echo $newServicedateTime->format('g:ia'); ?>
</br>Patient Name:<?php echo $patientName; ?>
</br>Patient I/C No:<?php echo $patientIC; ?>
</br>Patient Address:<?php echo $patientAddress; ?>
</br>Problem:<?php echo $requestNote; ?>
<?php if($doktorVisit === 'yes') { 
    $doctorVisitTxt = 'RM380 X '.$doctorVisitDays.' days : RM '.($doctorVisitDays*380); ?>
    
    </br>Doctor House call:<?php echo $doctorVisitTxt; ?>
<?php } ?>

<?php if($intervalDays > 0) {
    $titleFeeFor = strtoupper($feeFor.' SERVICE');  
    $firstLine = 'a) '.$hourPerDay.'-hour care @ RM '.$basicCharge.' x '.$intervalDays.' days : RM '.$basicCharge*$intervalDays; 
    $secondLine = 'b) Mileage @ RM'.$mileage.' x '.$intervalDays.' days : RM '.$mileage*$intervalDays;
    $thirdLine = 'c) Admin Fees : RM'.$adminFee;

    if($additionalCharge > 0) {
        $fifthLine = 'd) Additional Charge RM '.$additionalCharge;
    }
    $subtotalLine = 'Sub total : RM '.$subTotalAmount;
    $gstLine = 'GST  : RM '.$gst;
    $totalLine = 'TOTAL : RM '.$totalAmount;
    ?>
    </br><?php echo $titleFeeFor; ?>
    </br><?php echo $firstLine; ?>
    </br><?php echo $secondLine; ?>
    </br><?php echo $thirdLine; ?>
    <?php if($additionalCharge > 0) { ?>
    </br><?php echo $fifthLine; ?>
    <?php } ?>
    </br><?php echo $subtotalLine; ?>
    </br><?php echo $gstLine; ?>
    </br><?php echo $totalLine; ?>
    

<?php }  ?>
    </p> 
    <H1>Broadcast to Locum</H1>  
    <p>Code:<?php echo $customerCode; ?>
</br>Services:<?php echo strtoupper($quotationSummary); ?>
</br>Start services:<?php echo $newServicedate->format('dS M,Y'); ?>
</br>Start time:<?php echo $newServicedateTime->format('g:ia'); ?>
</br>Locum Fees:<?php echo $locumFees; ?>
</br>Patient Name:<?php echo $patientName; ?>
</br>Patient I/C No:<?php echo $patientIC; ?>
</br>Patient Address:<?php echo $patientAddress; ?>
</br>Problem:<?php echo $requestNote; ?>
    </p>    
  </body>
</html>  