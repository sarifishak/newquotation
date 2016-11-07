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
    // start the main function
    $id = $_REQUEST['id'];
    
    $importField = new ImportFieldManager();
    $importField->initImportFieldManager();
    $importField->getQuotationById($id);
    
?>  
<html>
  <head>
    <title>Create New Quotation</title>
    <meta name="description" content="Looking for stroke rehabilitation, physiotherapy, neonatal, postnatal, family care, private home nursing services or many more in KL, Malaysia? Visit us at MN Al Falah."/>
      <!-- <meta name="author" content=" studio"> -->
      <meta name="viewport" content="width=device-width">
      <link rel="stylesheet" href="css/style.css">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css'>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
      <script src="js/modernizr-2.7.0.min.js"></script>
      <script src="js/moment.min.js"></script>
      <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-64689641-1', 'auto');
      ga('send', 'pageview');
    
    
    $(document).ready(function() {
    
         // set an element
         // ref : http://stackoverflow.com/questions/12409299/how-to-get-current-formatted-date-dd-mm-yyyy-in-javascript-and-append-it-to-an-i
         
         $("#startDate").val( moment().format('YYYY-MM-D') );
         $("#endDate").val( moment().format('YYYY-MM-D') );
    
         // set a variable
         var today = moment().format('D MMM, YYYY');
         
         //alert("testing tseting");
         
         /* hourRate is confusing (Date : 16/8/2016 8:26AM)
         
         $('#hourRate').change(function() {
            //alert('The hourRate new value ' + $(this).val() + '.');
            $('#basicCharge').val($(this).val() * $('#hoursPerDay').val());
          });
          
          $('#basicCharge').change(function() {
            //alert('The basicCharge value ' + $(this).val() + '.');
            $('#hourRate').val($(this).val() / $('#hoursPerDay').val());
          });
          
          $('#hoursPerDay').change(function() {
            $('#basicCharge').val($(this).val() * $('#hourRate').val());
          });
          
          */
          
          $('#mySubmitButton').click(function(){
             document.getElementById('form-id').submit();
          });
    
     });
      
    </script>
    <meta name="robots" content="index, follow"/>
  </head>  
  <body>
    <section id="main-appoitment" class="main-appoitment-section">
      <div class="container">
        <h1>Create New Quotation</h1>
        <form action='quotation_process.php' id='form-id'  method='post'>
          <input type="hidden" name="importStage" value="first">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          
      	  
          <div style="color: #585864">
              <p><strong>Charging mode:
              <input type="radio" name="chargeMode" value="Daily"  <?php if($importField->getInputDataByName("chargeMode") === 'Daily') echo 'checked="checked"'; ?> > Daily
              <input type="radio" name="chargeMode" value="Weekly" <?php if($importField->getInputDataByName("chargeMode") === 'Weekly') echo 'checked="checked"'; ?>> Weekly
              <input type="radio" name="chargeMode" value="Monthly" <?php if($importField->getInputDataByName("chargeMode") === 'Monthly') echo 'checked="checked"'; ?>> Monthly
              <input type="radio" name="chargeMode" value="Yearly" <?php if($importField->getInputDataByName("chargeMode") === 'Yearly') echo 'checked="checked"'; ?>> Yearly</strong></p>
            
          </div>
          <div style="color: #585864">
              <p><strong>Fee For:
              <input type="radio" name="feeFor" value="Nurse" <?php if($importField->getInputDataByName('feeFor') === 'Nurse') echo 'checked="checked"'; ?>>Nurse
              <input type="radio" name="feeFor" value="Caregiver" <?php if($importField->getInputDataByName('feeFor') === 'Caregiver') echo 'checked="checked"'; ?> >Caregiver
              </strong></p>
          </div>
          <div style="color: #585864">
              <p><strong>Total Days:<input id="chargeDays" type="text" name="chargeDays" value="<?php echo $importField->getInputDataByName('chargeDays'); ?>"></strong></p>
          </div>
          <!-- comment it -- it is confusing
          <div style="color: #585864">
              <p><strong>Hour rate:<input id="hourRate" type="text" name="hourRate" value="<?php echo floatval($importField->getInputDataByName('basicCharge'))/floatval($importField->getInputDataByName('hoursPerDay')); ?>"></strong></p>
          </div>
          -->
          <div style="color: #585864">
              <p><strong>Charge per day:<input id="basicCharge" type="text" name="basicCharge" value="<?php echo $importField->getInputDataByName('basicCharge'); ?>"></strong></p>
          </div>
          <div style="color: #585864">
              <p><strong>Hours per day:<input id="hoursPerDay" type="text" name="hoursPerDay" value="<?php echo $importField->getInputDataByName('hoursPerDay'); ?>"></strong></p>
          </div>
          <div style="color: #585864">
              <p><strong>Days per week:<input id="daysPerWeek" type="text" name="daysPerWeek" value="<?php echo $importField->getInputDataByName('daysPerWeek'); ?>"></strong></p>
          </div>
          <div style="color: #585864">
              <p><strong>Start Date:<input id="startDate" type="text" name="startDate" value="<?php echo $importField->getInputDataByName('startDate'); ?>"></strong></p>
          </div>
          <div style="color: #585864">
              <p><strong>End Date:<input id="endDate" type="text" name="endDate" value="<?php echo $importField->getInputDataByName('endDate'); ?>"></strong></p>
          </div>
          <div style="color: #585864">
              <p><strong>Mileage Charge (daily):<input id="mileage" type="text" name="mileage" value="<?php echo $importField->getInputDataByName('mileage'); ?>"></strong></p>
          </div>
          <div style="color: #585864">
              <p><strong>Physiotherapy:
              <input type="radio" name="physiotherapy" value="yes" <?php if($importField->getInputDataByName('physiotherapy') === 'yes') echo 'checked="checked"'; ?> >Yes
              <input type="radio" name="physiotherapy" value="no"  <?php if($importField->getInputDataByName('physiotherapy') === 'no') echo 'checked="checked"'; ?> >No
              </strong><input id="physioDays" type="text" name="physioDays" value="<?php echo $importField->getInputDataByName('physioDays'); ?>">days</p>
          </div>
          <div style="color: #585864">
              <p><strong>Nurse Visit:
              <input type="radio" name="nurseVisit" value="yes" <?php if($importField->getInputDataByName('nurseVisit') === 'yes') echo 'checked="checked"'; ?> >Yes
              <input type="radio" name="nurseVisit" value="no"  <?php if($importField->getInputDataByName('nurseVisit') === 'no') echo 'checked="checked"'; ?> >No
              </strong><input id="nurseVisitDays" type="text" name="nurseVisitDays" value="<?php echo $importField->getInputDataByName('nurseVisitDays'); ?>">days</p>
          </div>
          <div style="color: #585864">
              <p><strong>Doctor Visit:
              <input type="radio" name="doktorVisit" value="yes" <?php if($importField->getInputDataByName('doktorVisit') === 'yes') echo 'checked="checked"'; ?> >Yes
              <input type="radio" name="doktorVisit" value="no"  <?php if($importField->getInputDataByName('doktorVisit') === 'no') echo 'checked="checked"'; ?> >No
              </strong><input id="doctorVisitDays" type="text" name="doctorVisitDays" value="<?php echo $importField->getInputDataByName('doctorVisitDays'); ?>">days</p>
          </div>
          <div style="color: #585864">
              <p><strong>Admin Fees:<input id="adminFees" type="text" name="adminFees" value="<?php echo $importField->getInputDataByName('adminFees'); ?>"></strong></p>
          </div>
          <div style="color: #585864">
              <p><strong>Additional Charge:<input id="additionalCharge" type="text" name="additionalCharge" value="<?php echo $importField->getInputDataByName('additionalCharge'); ?>"></strong></p>
          </div>
          <div class="textarea">
            <div class="human-test right">
            <button type="button" id="mySubmitButton" class="btn btn2">NEXT</button>
            </div>
          </div>
        </form>
      </div>
    </section>  
  </body>
</html>