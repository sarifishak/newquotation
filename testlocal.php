<?php
  require_once 'users.php';
?>
<?php
  $user = new Users();
  $user->username = 'demo';
  $user->password = 'demo';
  $user->lastname = 'Sokmo';
  $user->firstname = 'Demo';
  $user->userType = 2;
  $found = true;
  
  $userTypes = new UserTypes();
  $userTypes->id = $user->userType; 
  $userTypes->foundRecord = true;
  $userTypes->userType = 'marketing';
  $userTypes->defaultPage = 'Location: marketing.php';
  
  $user->userTypeData=$userTypes;
  
  session_start();
  $_SESSION['current_user']=$user;

  /*$datetime1 = new DateTime('2016-08-09');
  $datetime2 = new DateTime('2016-08-29');
  $interval = $datetime1->diff($datetime2);
   echo 'Interval is '.$interval->days.'.<br>';
   */
        
  //header($user->userTypeData->defaultPage);
  // 22/7/2016 8:13AM : I want to test adding new inquiry data
  //header('Location: newInquiry.php');
  //header('Location: newQuotation.php');
  
  header('Location: quotationPdfOut.php?id=2');
  
?>
