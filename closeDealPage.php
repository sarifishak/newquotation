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
    $importField->closeDealQuotationById($id);
    header('Location: marketing.php');

?>      
