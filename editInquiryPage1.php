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

    $id = $_REQUEST['id'];

    $importField = new ImportFieldManager();
    $importField->initImportFieldManager();
    $importField->getQuotationById($id);
        
    /*
    //$importFieldManager = unserialize($_SESSION['importFieldManager']);
    //$importFieldManager->getInputData();
    session_start();
    //echo "The unserialize data is <br/>";
    $importField = unserialize($_SESSION['importFieldManager']);
    //echo unserialize(stripslashes($_SESSION['importFieldManager']));
    //$importField->getInputData();
    
    //echo "Just for Problem <br/>";
    //echo $importField->getInputDataByName("Problem");
    
    //echo "Just for Patient I/C No <br/>";
    //echo $importField->getInputDataByName("Patient I/C No.");
    */
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang=""en" xml:lang="en""> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang=""en" xml:lang="en""> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang=""en" xml:lang="en""> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 oldie" lang=""en" xml:lang="en""> <![endif]-->
<!--[if gt IE 8]> <html class="no-js newie" lang='"en" xml:lang="en"'> <![endif]-->
<html>
<!--
    echo " <br/>Just for Problem:";
    echo $importField->getInputDataByName("Problem");
    
    echo " <br/>Just for Patient I/C No:";
    echo $importField->getInputDataByName("Patient I/C No.");
    
    echo " <br/>Just for quotationNo:";
    echo $importField->getInputDataByName("quotationNo");
-->
  <head>
    <meta charset="utf-8">
    <title>Maternity Care Centre, Babysitting and Private Home Nursing Services</title>
    <meta name="description" content="Looking for stroke rehabilitation, physiotherapy, neonatal, postnatal, family care, private home nursing services or many more in KL, Malaysia? Visit us at MN Al Falah."/>
      <!-- <meta name="author" content=" studio"> -->
      <meta name="viewport" content="width=device-width">
      <link rel="stylesheet" href="css/style.css">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css'>
      <script src="js/modernizr-2.7.0.min.js"></script>
      <!-- <link rel="icon" type="image/png" href="favicon.png" /> -->
      <!--Internet Explorer 8 or older doesn't support media query. This script helps ie7 and ie8 to recognize media queries-->
      <!--[if lt IE 9]>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
      <![endif]-->
        <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-64689641-1', 'auto');
      ga('send', 'pageview');
    
    </script>
    <meta name="robots" content="index, follow"/>
  </head>
  <body>
        <!-- BEGIN APPOITMENT -->

      <section id="main-appoitment" class="main-appoitment-section">

        <div class="container">

          <h1>Edit Quotation Data</h1>

          <form action="inquiry_process.php" id="contact-form" novalidate method='post'> 
          <input type="hidden" name="importStage" value="editInquiry">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="hidden" name="customerId" value="<?php echo $importField->getInputDataByName('customerId'); ?>">
          <input type="hidden" name="patientId" value="<?php echo $importField->getInputDataByName('patientId'); ?>">

            <div style="color: #585864">

              <p><strong>Client's Detail</strong></p>

            </div>

            <div class="input">

              <label>

                <span>Name *</span>

                <input id="name" type="text" name="name" value="<?php echo $importField->getInputDataByName('Name');?>">

              </label>
              <label>

                <span>Code</span>

                <input id="contactCode" type="text" name="contactCode" value="<?php echo $importField->getInputDataByName('contactCode');?>">

              </label><!-- 

               --><label>

                 <span>I/C No. *</span>

                 <input id="ic" type="text" name="ic" value="<?php echo $importField->getInputDataByName('I/C No.');?>">

               </label><!-- 

               --><label>

                 <span>Address</span>

                 <input id="address" type="text" name="address"  value="<?php echo $importField->getInputDataByName('Address');?>">

               </label><!-- 

               --><label>

                 <span>E-mail *</span>

                 <input id="mail" type="text" name="mail"  value="<?php echo $importField->getInputDataByName('E-Mail');?>">

               </label><!-- 

               --><label>

                 <span>Contact No. 1 *</span>

                 <input id="contact1" type="text" name="contact1"   value="<?php echo $importField->getInputDataByName('Contact No.1');?>">

               </label><!-- 

               --><label>

                 <span>Contact No. 2</span>

                 <input id="contact2" type="text" name="contact2"  value="<?php echo $importField->getInputDataByName('Contact No.2');?>">

               </label>

            </div>

            <div style="color: #585864">

              <p><strong>Patient's Detail</strong></p>

            </div>

            <div class="input">

              <label>

                <span>Name *</span>

                <input id="patientname" type="text" name="patientname"  value="<?php echo $importField->getInputDataByName('Patient Name');?>">

              </label><!-- 

               --><label>

                 <span>I/C No. *</span>

                 <input id="patientic" type="text" name="patientic" value="<?php echo $importField->getInputDataByName('Patient I/C No.');?>">

               </label><!-- 

               --><label>

                 <span>Address</span>

                 <input id="patientaddress" type="text" name="patientaddress" value="<?php echo $importField->getInputDataByName('Patient Address');?>">>

               </label><!--

               -->

            </div>

            <div class="textarea">

              <label class="left">

                <span>Main Medical / Physical-Social Problem</span>

                <textarea name="problem" id="problem"><?php echo $importField->getInputDataByName("Problem") ?></textarea>

              </label>

            </div>
            
                        <div style="color: #585864">

              <p><strong>Quotation Detail</strong></p>

            </div>

            <div class="input">
              <label>
                <span>Hours Per Day</span>
                <input id="hoursPerDay" type="text" name="hoursPerDay" value="<?php echo $importField->getInputDataByName('hoursPerDay');?>">
              </label>
              <label>
                 <span>Days Per Week</span>
                 <input id="daysPerWeek" type="text" name="daysPerWeek" value="<?php echo $importField->getInputDataByName('daysPerWeek');?>">
               </label>
               <label>
                 <span>Admin Fees</span>
                 <input id="adminFees" type="text" name="adminFees"  value="<?php echo $importField->getInputDataByName('adminFees');?>">
               </label>
               <label>
                 <span>Quotation No</span>
                 <input id="quotationNo" type="text" name="quotationNo"  value="<?php echo $importField->getInputDataByName('quotationNo');?>">
               </label>
               <label>
                 <span>Charge Mode</span>
                 <input id="chargeMode" type="text" name="chargeMode"   value="<?php echo $importField->getInputDataByName('chargeMode');?>">
               </label>
               <label>
                 <span>Fee For</span>
                 <input id="feeFor" type="text" name="feeFor"  value="<?php echo $importField->getInputDataByName('feeFor');?>">
               </label>
               <label>
                 <span>Physiotherapy</span>
                 <input id="physiotherapy" type="text" name="physiotherapy"  value="<?php echo $importField->getInputDataByName('physiotherapy');?>">
                 <input id="physioDays" type="text" name="physioDays" value="<?php echo $importField->getInputDataByName('physioDays'); ?>">days
               </label>
               <label>
                 <span>Nurse Visit</span>
                 <input id="nurseVisit" type="text" name="nurseVisit"  value="<?php echo $importField->getInputDataByName('nurseVisit');?>">
                 <input id="nurseVisitDays" type="text" name="nurseVisitDays" value="<?php echo $importField->getInputDataByName('nurseVisitDays'); ?>">days
               </label>
               <label>
                 <span>Doctor Visit</span>
                 <input id="doktorVisit" type="text" name="doktorVisit"  value="<?php echo $importField->getInputDataByName('doktorVisit');?>">
                 <input id="doctorVisitDays" type="text" name="doctorVisitDays" value="<?php echo $importField->getInputDataByName('doctorVisitDays'); ?>">days
               </label>
               <label>
                 <span>Charged Days</span>
                 <input id="chargeDays" type="text" name="chargeDays"  value="<?php echo $importField->getInputDataByName('chargeDays');?>">
               </label>
               <label>
                 <span>Quotation Date</span>
                 <input id="quotationDate" type="text" name="quotationDate"  value="<?php echo $importField->getInputDataByName('quotationDate');?>">
               </label>
               <label>
                 <span>Basic Charge</span>
                 <input id="basicCharge" type="text" name="basicCharge"  value="<?php echo $importField->getInputDataByName('basicCharge');?>">
               </label>
               <label>
                 <span>startTimeDaily</span>
                 <input id="startTimeDaily" type="text" name="startTimeDaily"  value="<?php echo $importField->getInputDataByName('startTimeDaily');?>">
               </label>
               <label>
                 <span>endTimeDaily</span>
                 <input id="endTimeDaily" type="text" name="endTimeDaily"  value="<?php echo $importField->getInputDataByName('endTimeDaily');?>">
               </label>
               <label>
                 <span>startDate</span>
                 <input id="startDate" type="text" name="startDate"  value="<?php echo $importField->getInputDataByName('startDate');?>">
               </label>
               <label>
                 <span>endDate</span>
                 <input id="endDate" type="text" name="endDate"  value="<?php echo $importField->getInputDataByName('endDate');?>">
               </label>
               <label>
                 <span>mileage</span>
                 <input id="mileage" type="text" name="mileage"  value="<?php echo $importField->getInputDataByName('mileage');?>">
               </label>
               <label>
                 <span>additionalCharge</span>
                 <input id="additionalCharge" type="text" name="additionalCharge"  value="<?php echo $importField->getInputDataByName('additionalCharge');?>">
               </label>
               <label>
                 <span>gst</span>
                 <input id="gst" type="text" name="gst"  value="<?php echo $importField->getInputDataByName('gst');?>">
               </label>
               <label>
                 <span>discount</span>
                 <input id="discount" type="text" name="discount"  value="<?php echo $importField->getInputDataByName('discount');?>">
               </label>
               <label>
                 <span>totalAmount</span>
                 <input id="totalAmount" type="text" name="totalAmount"  value="<?php echo $importField->getInputDataByName('totalAmount');?>">
               </label>
               <label>
                 <span>totalPaid</span>
                 <input id="totalPaid" type="text" name="totalPaid"  value="<?php echo $importField->getInputDataByName('totalPaid');?>">
               </label>
               <label>
                 <span>amountDue</span>
                 <input id="amountDue" type="text" name="amountDue"  value="<?php echo $importField->getInputDataByName('amountDue');?>">
               </label>
               <label>
                 <span>statusPaid</span>
                 <input id="statusPaid" type="text" name="statusPaid"  value="<?php echo $importField->getInputDataByName('statusPaid');?>">
               </label>
               <label>
                 <span>status</span>
                 <input id="status" type="text" name="status"  value="<?php echo $importField->getInputDataByName('status');?>">
               </label>
            </div>


            <div class="textarea">

              <div class="human-test right">

                <button type="submit" class="btn btn2">UPDATE QUOTATION</button>

              </div>

            </div>

          </form>

        </div>



      </section>



      <!-- END APPOITMENT -->
</body>
</html>      