<?php
  require_once 'users.php';
  require_once 'userTypes.php';
  require_once 'contacts.php';
  require_once 'contactTypes.php';
  require_once 'quotations.php';
  require_once 'quotationNotes.php';
?>

<html>
  <head>
    <title>Marketing page</title>
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css'>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
      <script src="js/modernizr-2.7.0.min.js"></script>
      <script src="js/moment.min.js"></script>
      <script>
          $(document).ready(function() {
        
             // set an element
             // ref : http://stackoverflow.com/questions/12409299/how-to-get-current-formatted-date-dd-mm-yyyy-in-javascript-and-append-it-to-an-i
             
             $("#currentDate").val( moment().format('YYYY-MM-D') );
             
         });
      
    </script>
    <script>
    function popupReport(page,inquiryId,title) {
      var currDate = document.getElementById("currentDate").value;
      popupCenter(page,currDate,title);
    } 
    function popupCenter(page,inquiryId,title) {
      //onclick="popupCenter('http://www.nigraphic.com', 'myPop1',450,450);"
      //var url = "samplePdfOut.php?id="+inquiryId;
      var url = page+inquiryId;
      var w = 800;
      var h = 600;
      var left = (screen.width/2)-(w/2);
      var top = (screen.height/2)-(h/2);
      return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    } 
    
    function popupCenterConfirm(page,inquiryId,title) {
        if (confirm('Are you sure to '+ title + ' for id=' + inquiryId + '?' )) { 
            // do things if OK
            //popupCenter(page,inquiryId,title);
            var url = page+inquiryId;
            window.location = url;
        }
    }
    </script>    
  </head>
  <body>
    <p>Marketing page</p>
    <p>
      You have successfully logged in 

      <?php
        session_start();

        $user = $_SESSION['current_user'];
       
        echo $user->firstname.' '.$user->lastname.'.<br>';
        //echo 'Default page:'.$user->userTypeData->defaultPage.'.';
        
        
      ?>
    </p>
    <p>List of inquiry:<?php echo '<button onclick="popupCenter(\'newInquiry.php?id=\',0,\'Import New\');">Import New</button>';?>
                       <?php echo '<button onclick="popupReport(\'monthlyReport.php?currentDate=\',0,\'Monthly Report\');">Monthly Report</button>';?>
                       <input type="text" id="currentDate" name="currentDate">
                       <?php echo '<button onclick="popupReport(\'monthlyCloseDealReport.php?currentDate=\',0,\'Monthly Close Deal Report\');">Monthly Close Deal Report</button>';?>
                       <!-- <?php echo '<button onclick="popupCenter(\'quotationPdfOut.php?id=\',0,\'View Quotation\');">Test New Quotation</button>';?>   -->
                       <!-- <?php echo '<button onclick="popupCenter(\'newQuotation.php?id=\',0,\'View Quotation\');">Test New Quotation</button>';?> --></p>
    <table border='1'>
      <tr>
        <td>Inquiry</td>
        <td>Action</td>
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $quotations = new Quotations();
      $quotation_list = $quotations->selectAllNotDeleted();

      foreach($quotation_list as $inquiry) {
        echo '<tr>';
        echo '<td>Created Date:'.$inquiry->createdDate.'<br>';
        echo 'Quotation Date:'.$inquiry->quotationDate.'<br>';
        echo 'Customer: '.$inquiry->customerData->firstName.'&nbsp;'.$inquiry->customerData->lastName.'<br>';
        echo 'Patient: '.$inquiry->patientData->firstName.'&nbsp;'.$inquiry->patientData->lastName.'</br>';
        echo 'Address: '.$inquiry->customerData->address.'&nbsp;'.$inquiry->customerData->city.'&nbsp;'.$inquiry->customerData->postcode.'&nbsp;'.$inquiry->customerData->state.'</br>';
        echo 'Email: '.$inquiry->customerData->email.'</br>';
        echo 'Status: '.$inquiry->status.'</br>';
        echo 'Notes: ';
             foreach($inquiry->noteListData as $quotationNote) {
             	echo $quotationNote->note.'</br>';
             }
        echo '</td>';
        echo '<td><button onclick="popupCenter(\'quotationPdfOut.php?id=\','.$inquiry->id.',\'View Quotation\');">View Quotation</button><br/>';
        echo '    <button onclick="popupCenter(\'newQuotation.php?id=\','.$inquiry->id.',\'Create Quotation\');">Create Quotation</button><br/>';
        echo '    <button onclick="popupCenter(\'editInquiryPage1.php?id=\','.$inquiry->id.',\'Edit Quotation\');">Edit Quotation</button><br/>';
        echo '    <button onclick="popupCenterConfirm(\'deleteInquiryPage1.php?id=\','.$inquiry->id.',\'Delete Quotation\');">Delete Quotation</button><br/>';
        if ($inquiry->status == '1')
            echo '    <button onclick="popupCenterConfirm(\'cancelDealPage.php?id=\','.$inquiry->id.',\'Cancel Deal this Quotation\');">Cancel Deal</button></td>';
        else 
            echo '    <button onclick="popupCenterConfirm(\'closeDealPage.php?id=\','.$inquiry->id.',\'Close Deal this Quotation\');">Close Deal</button></td>';
        echo '</tr>';
      }
    ?>
    </table> 
</html>
