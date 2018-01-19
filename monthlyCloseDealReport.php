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
    <title>Monthly Close Deal Report</title>
  </head>
  <body>
    <p>Monthly Close Deal Report.<a href="monthlyCloseDealReportAsCsv.php?currentDate=<?php echo $_REQUEST['currentDate'] ?>">download</a></p>
    <table border='1'>
      <tr>
        <td>Quotation Date</td>
        <td>Caller Name</td>
        <td>Tel No</td>
        <td>Email</td>
        <td>Location</td>
        <td>Case Description</td>
        <td>Fee For</td>
        <td>Basic Charge</td>
        <td>Mileage</td>
        <td>Admin</td>
        <td>Additional Charge</td>
        <td>Gst</td>
        <td>Total</td>        
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $quotations = new Quotations();
      $quotations_list= $quotations->selectCloseDealByQuotationDate($_REQUEST['currentDate']);
      if($quotations->row_count === 0 ){
          echo '<tr><td colSpan=6>No record';
          //$quotations->showDebug();
          echo '</td></tr>';
      } else {
          
          //$quotation_list = (new Quotations())->selectByQuotationDate($_REQUEST['currentDate']);
    
          foreach($quotations_list as $quotation) {
            $feeFor = $quotation->feeFor .' fees for '.$quotation->hourPerDay.'-hour care @ RM '.$quotation->basicCharge.' x '.$quotation->chargeDays.' days';
            $basicCharge = $quotation->basicCharge * $quotation->chargeDays;
            echo '<tr>';
            echo '<td>'.$quotation->quotationDate.'</td>';
            echo '<td>'.$quotation->customerData->firstName.'</td>';
            echo '<td>'.$quotation->customerData->mobile.'</td>';
            echo '<td>'.$quotation->customerData->email.'</td>';
            echo '<td>'.$quotation->customerData->address.'</td>';
            $allNotes = "";
            foreach($quotation->noteListData as $quotationNote) {
                $allNotes = $allNotes.$quotationNote->note;
            }
            echo '<td>'.$allNotes.'</td>';
            echo '<td>'.$feeFor.'</td>';
            echo '<td>RM'.$basicCharge.'</td>';
            echo '<td>RM'.$quotation->mileage.'</td>';
            echo '<td>RM'.$quotation->adminFee.'</td>';
            echo '<td>RM'.$quotation->additionalCharge.'</td>';
            echo '<td>RM'.$quotation->gst.'</td>';
            echo '<td>RM'.$quotation->totalAmount.'</td>';
            echo '</tr>';
          }      
      
      }
      
    ?>
    </table> 
     
  </body>
</html>
