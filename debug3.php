<?php
  require_once 'users.php';
  require_once 'userTypes.php';
  require_once 'contacts.php';
  require_once 'contactTypes.php';
  require_once 'quotations.php';
  require_once 'quotationNotes.php';
// mysqli

    $db = "ad_a42b01dedd03768"; 
    $host = "localhost";
    $port = "3306";
    $username = "shima";
    $password = "p@ssw0rd";
    
    $conn = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8mb4', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    foreach($conn->query('SELECT * FROM users') as $row) {
        echo $row['username'].' '.$row['password'].' '.$row['lastName'].' '.$row['firstName'].' '.$row['userType']; //etc...
    }
    
    echo '<p>';
    
    $username = 'shima';
    $password = 'shima';
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute(array($username, md5($password)));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($rows as $row) {
        echo $row['username'].' '.$row['password'].' '.$row['lastName'].' '.$row['firstName'].' '.$row['userType']; //etc...
    }
    echo '<br>end..</p>';
    
    echo '<p>Here is the list of quotations';
    /*
    $result = $conn->exec("INSERT INTO Users(firstName,lastName,username, password) VALUES('John', 'Doe','John', 'Doe')");
    $insertId = $conn->lastInsertId();
    
    echo '<br>$insertId is '.$insertId.'..</p>';
    
    */
    
    $quotations = new Quotations();
    //$quotation_list= $quotations->selectByQuotationDate($_REQUEST['currentDate']);
    
    //$quotation_list= $quotations->selectByQuotationDate('2016-9-3');
    $quotation_list = $quotations->selectAll();

    foreach($quotation_list as $quotation) {
          $allNotes = "";
          foreach($quotation->noteListData as $quotationNote) {
                $allNotes = $allNotes.$quotationNote->note;
          }
          
          echo "<br>";
          echo $quotation->quotationDate.' '.$quotation->customerData->firstName.' '.$quotation->customerData->mobile.' '.$quotation->customerData->email.' '.$quotation->customerData->address.' '.$allNotes;
      }


?>