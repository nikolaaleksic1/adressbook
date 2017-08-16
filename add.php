<?php

session_start();

//check if user is looged in
if(!$_SESSION['loggedInUser']){

  //redirect back to the home/index page
  header('Location:index.php');

}

//include to connection and to functions
include('includes/connection.php');
include('includes/functions.php');

//check to see if add button is pressed
if(isset($_POST['add'])){

  //set all variables to be empty by default - we wont to be able to enter any caracter by default...
  $clientName = $clientPhone = $clientEmail = $clientAddress = $clientCompany = $clientNotes = "";
  if(!$_POST['clientName']){
    $nameError = "Please enter a name!<br>";
  } else {
    $clientName = validateFormData($_POST['clientName']);
  }

  if(!$_POST['clientEmail']){
    $nameError = "Please enter a email!<br>";
  } else {
    $clientEmail = validateFormData($_POST['clientEmail']);
  }

//because these inputs are not required, so we just store whatever has been entered
$clientPhone = validateFormData($_POST['clientPhone']);
$clientAddress = validateFormData($_POST['clientAddress']);
$clientCompany = validateFormData($_POST['clientCompany']);
$clientNotes = validateFormData($_POST['clientNotes']);

//test to see if name and email have data
if($clientName && $clientEmail){
    //create query
    $query = "INSERT INTO clients (id, name, email, phone, address, company, notes, date_added) VALUES (NULL,
    '$clientName', '$clientEmail', '$clientPhone', '$clientAddress', '$clientCompany', '$clientNotes', CURRENT_TIMESTAMP)";

    $result = mysqli_query($conn, $query);

    //if query was successful
    if($result){
      //refresh page with query string
      header('Location:clients.php?alert=success');
    } else {
      echo "Error :" . $query . "<br>" . mysqli_error($conn);
    }

}

}

//close mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<h1>Add Client</h1>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name *</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email *</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"></textarea>
    </div>
    <div class="col-sm-12">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add Client</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>
