<?php
  require_once 'users.php';
  require_once 'userTypes.php';
  require_once 'contacts.php';
  require_once 'contactTypes.php';
  require_once 'quotations.php';
  require_once 'quotationNotes.php';
  // output headers so that the file is downloaded rather than displayed
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=MonthlyReportData.csv');
  
  // create a file pointer connected to the output stream
  $output = fopen('php://output', 'w');
  
  // output the column headings
  fputcsv($output, array('Quotation Date', 'Introducer','Code','Caller Name', 'Tel No','Email','Location','Case Description'));
  
  $quotations = new Quotations();
  $quotations_list= $quotations->selectByQuotationDate($_REQUEST['currentDate']);
  if($quotations->row_count === 0 ){
      fputcsv($output, array(' ', ' ', ' ',' ',' ',' '));
  } else {
      
      foreach($quotations_list as $quotation) {
          $allNotes = "";
          foreach($quotation->noteListData as $quotationNote) {
                $allNotes = $allNotes.$quotationNote->note;
          }
          
          fputcsv($output, array($quotation->quotationDate,$quotation->introducer, $quotation->customerData->contactCode, $quotation->customerData->firstName,$quotation->customerData->mobile,$quotation->customerData->email,$quotation->customerData->address,$allNotes));
      }
  }

?>
