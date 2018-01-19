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
    <title>DB Query PHP Page</title>
  </head>
  <body>
    <p>The debug page sites</p>
    <p>Contents of table Users:</p>
    <table border='1'>
      <tr>
        <td>Id</td>
        <td>Username</td>
        <td>Password</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Type</td>
        <td>Status</td>
        <td>CreatedDate</td>
        <td>CraetedId</td>
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $users = new Users();
      $user_list = $users->selectAll();

      foreach($user_list as $user) {
        echo '<tr>';
        echo '<td>'.$user->id.'</td>';
        echo '<td>'.$user->username.'</td>';
        echo '<td>'.$user->password.'</td>';
        echo '<td>'.$user->firstname.'</td>';
        echo '<td>'.$user->lastname.'</td>';
        echo '<td>'.$user->userType.'</td>';
        echo '<td>'.$user->status.'</td>';
        echo '<td>'.$user->createdDate.'</td>';
        echo '<td>'.$user->createdId.'</td>';
        echo '</tr>';
      }
    ?>
    </table> 
    <p>Contents of table UserTypes:</p>
    <table border='1'>
      <tr>
        <td>Id</td>
        <td>UserType</td>
        <td>DefaultPage</td>
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $usertypes = new UserTypes();
      $usertype_list = $usertypes->selectAll();

      foreach($usertype_list as $usertype) {
        echo '<tr>';
        echo '<td>'.$usertype->id.'</td>';
        echo '<td>'.$usertype->userType.'</td>';
        echo '<td>'.$usertype->defaultPage.'</td>';
        echo '</tr>';
      }
    ?>
    </table> 
    <p>Contents of table Contacts:</p>

    <table border='1'>
      <tr>
        <td>Id</td>
        <td>Contact Type</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>IC</td>
        <td>Address</td>
        <td>City</td>
        <td>State</td>
        <td>Postcode</td>
        <td>Mobile</td>
        <td>Office</td>
        <td>Home</td>
        <td>Fax</td>
        <td>Email</td>
        <td>CreatedDate</td>
        <td>CreatedId</td>
        
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $contacts = new Contacts();
      $contacts_list = $contacts->selectAll();

      foreach($contacts_list as $contact) {
        echo '<tr>';
        echo '<td>'.$contact->id.'</td>';
        echo '<td>'.$contact->contactTypeId.'</td>';
        echo '<td>'.$contact->firstName.'</td>';
        echo '<td>'.$contact->lastName.'</td>';
        echo '<td>'.$contact->ic.'</td>';
        echo '<td>'.$contact->address.'</td>';
        echo '<td>'.$contact->city.'</td>';
        echo '<td>'.$contact->state.'</td>';
        echo '<td>'.$contact->postcode.'</td>';
        echo '<td>'.$contact->mobile.'</td>';
        echo '<td>'.$contact->office.'</td>';
        echo '<td>'.$contact->home.'</td>';
        echo '<td>'.$contact->fax.'</td>';
        echo '<td>'.$contact->email.'</td>';
        echo '<td>'.$contact->createdDate.'</td>';
        echo '<td>'.$contact->createdId.'</td>';
        echo '</tr>';
      }
    ?>
    </table> 
    <p>Contents of table ContactTypes:</p>
    <table border='1'>
      <tr>
        <td>Id</td>
        <td>ContactType</td>
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $contacttypes = new ContactTypes();
      $contacttype_list = $contacttypes->selectAll();

      foreach($contacttype_list as $contactType) {
        echo '<tr>';
        echo '<td>'.$contactType->id.'</td>';
        echo '<td>'.$contactType->contactType.'</td>';
        echo '</tr>';
      }
    ?>
    </table> 
    <p>Contents of table Quotataion:</p>
    <table border='1'>
      <tr>
        <td>Id</td>
        <td>quotationNo</td>
        <td>chargeMode</td>
        <td>feeFor</td>
        <td>physiotherapy</td>
        <td>nurseVisit</td>
        <td>doktorVisit</td>
        <td>physioDays</td>
        <td>nurseVisitDays</td>
        <td>doctorVisitDays</td>
        <td>chargeDays</td>
        <td>customerId</td>
        <td>patientId</td>
        <td>quotationDate</td>
        <td>hourPerDay</td>
        <td>dayPerWeek</td>
        <td>basicCharge</td>
        <td>startTimeDaily</td>
        <td>endTimeDaily</td>
        <td>startDate</td>
        <td>endDate</td>
        <td>mileage</td>
        <td>adminFee</td>
        <td>additionalCharge</td>
        <td>gst</td>
        <td>discount</td>
        <td>totalAmount</td>
        <td>totalPaid</td>
        <td>amountDue</td>
        <td>statusPaid</td>
        <td>status</td>
        <td>createdDate</td>
        <td>createdId</td>
        
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $quotations = new Quotations();
      $quotation_list = $quotations->selectAll();

      foreach($quotation_list as $contactType) {
        echo '<tr>';
        echo '<td>'.$contactType->id.'</td>';
        echo '<td>'.$contactType->quotationNo.'</td>';
        echo '<td>'.$contactType->chargeMode.'</td>';
        echo '<td>'.$contactType->feeFor.'</td>';
        echo '<td>'.$contactType->physiotherapy.'</td>';
        echo '<td>'.$contactType->nurseVisit.'</td>';
        echo '<td>'.$contactType->doktorVisit.'</td>';
        echo '<td>'.$contactType->physioDays.'</td>';
        echo '<td>'.$contactType->nurseVisitDays.'</td>';
        echo '<td>'.$contactType->doctorVisitDays.'</td>';
        echo '<td>'.$contactType->chargeDays.'</td>';
        echo '<td>'.$contactType->customerId.'</td>';
        echo '<td>'.$contactType->patientId.'</td>';
        echo '<td>'.$contactType->quotationDate.'</td>';
        echo '<td>'.$contactType->hourPerDay.'</td>';
        echo '<td>'.$contactType->dayPerWeek.'</td>';
        echo '<td>'.$contactType->basicCharge.'</td>';
        echo '<td>'.$contactType->startTimeDaily.'</td>';
        echo '<td>'.$contactType->endTimeDaily.'</td>';
        echo '<td>'.$contactType->startDate.'</td>';
        echo '<td>'.$contactType->endDate.'</td>';
        echo '<td>'.$contactType->mileage.'</td>';
        echo '<td>'.$contactType->adminFee.'</td>';
        echo '<td>'.$contactType->additionalCharge.'</td>';
        echo '<td>'.$contactType->gst.'</td>';
        echo '<td>'.$contactType->discount.'</td>';
        echo '<td>'.$contactType->totalAmount.'</td>';
        echo '<td>'.$contactType->totalPaid.'</td>';
        echo '<td>'.$contactType->amountDue.'</td>';
        echo '<td>'.$contactType->statusPaid.'</td>';
        echo '<td>'.$contactType->status.'</td>';
        echo '<td>'.$contactType->createdDate.'</td>';
        echo '<td>'.$contactType->createdId.'</td>';
        echo '</tr>';
      }
    ?>
    </table> 
    <p>Contents of table QuotationNotes:</p>
    <table border='1'>
      <tr>
        <td>Id</td>
        <td>quotationId</td>
        <td>Note</td>
        <td>Created Date</td>
        <td>Created Id</td>
      </tr>
    <?php 
      //refer to user.php for the implementation of the class User 
      $quotationNotes = new QuotationNotes();
      $quotationNotes_list = $quotationNotes->selectAll();

      foreach($quotationNotes_list as $quotationNote) {
        echo '<tr>';
        echo '<td>'.$quotationNote->id.'</td>';
        echo '<td>'.$quotationNote->quotationId.'</td>';
        echo '<td>'.$quotationNote->note.'</td>';
        echo '<td>'.$quotationNote->createdDate.'</td>';
        echo '<td>'.$quotationNote->createdId.'</td>';
        echo '</tr>';
      }
    ?>
    </table> 
    <!-- Click <a href='login.php'>[here]</a> to test the login page.<br>  -->
     
  </body>
</html>