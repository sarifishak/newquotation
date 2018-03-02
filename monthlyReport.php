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
    <title>Monthly Report</title>
  </head>
  <body>
    <p>Monthly Report.<a href="monthlyReportAsCsv.php?currentDate=<?php echo $_REQUEST['currentDate'] ?>">download</a></p>
    <table border='1'>
      <tr>
        <td>Quotation Date</td>
        <td>Code</td>
        <td>Caller Name</td>
        <td>Tel No</td>
        <td>Email</td>
        <td>Location</td>
        <td>Case Description</td>
        
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $quotations = new Quotations();
      $quotations_list= $quotations->selectByQuotationDate($_REQUEST['currentDate']);
      if($quotations->row_count === 0 ){
          echo '<tr><td colSpan=6>No record';
          //$quotations->showDebug();
          echo '</td></tr>';
      } else {
          
          //$quotation_list = (new Quotations())->selectByQuotationDate($_REQUEST['currentDate']);
    
          foreach($quotations_list as $quotation) {
            echo '<tr>';
            echo '<td>'.$quotation->quotationDate.'</td>';
            echo '<td>'.$quotation->customerData->contactCode.'</td>';
            echo '<td>'.$quotation->customerData->firstName.'</td>';
            echo '<td>'.$quotation->customerData->mobile.'</td>';
            echo '<td>'.$quotation->customerData->email.'</td>';
            echo '<td>'.$quotation->customerData->address.'</td>';
            $allNotes = "";
            foreach($quotation->noteListData as $quotationNote) {
                $allNotes = $allNotes.$quotationNote->note;
            }
            echo '<td>'.$allNotes.'</td>';
            echo '</tr>';
          }      
      
      }
      
    ?>
    </table> 
     
  </body>
</html>