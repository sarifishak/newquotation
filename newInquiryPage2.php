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
    
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang=""en" xml:lang="en""> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang=""en" xml:lang="en""> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang=""en" xml:lang="en""> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 oldie" lang=""en" xml:lang="en""> <![endif]-->
<!--[if gt IE 8]> <html class="no-js newie" lang='"en" xml:lang="en"'> <![endif]-->
<html>
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

          <h1>Import New Inquiry</h1>

          <form action="inquiry_process.php" id="contact-form" novalidate method='post'> 
          <input type="hidden" name="importStage" value="second">

            <div style="color: #585864">

              <p><strong>Client's Detail</strong></p>

            </div>

            <div class="input">

              <label>

                <span>Name *</span>

                <input id="name" type="text" name="name" value="<?php echo $importField->getInputDataByName('Name');?>">

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

            <div class="textarea">

              <div class="human-test right">

                <button type="submit" class="btn btn2">SAVE INQUIRY</button>

              </div>

            </div>

          </form>

        </div>



      </section>



      <!-- END APPOITMENT -->
</body>
</html>      