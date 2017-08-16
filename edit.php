<?php

session_start();

if(!$_SESSION['loggedInUser']){

  header('Location: index.php');

}

//get id send by GET collection
$clientId = $_GET['id'];

//include to connection and to functions
include('includes/connection.php');
include('includes/functions.php');

//query the database with clidenid

$query = "SELECT * FROM clients WHERE id = '$clientId'";
$result = mysqli_query($conn, $query);

//if result is returned
//set some variables
if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    $clientName = $row['name'];
    $clientEmail = $row['email'];
    $clientPhone = $row['phone'];
    $clientAddress = $row['address'];
    $clientCompany = $row['company'];
    $clientNotes = $row['notes'];
  }
} else {
  $alertMessage = "<div class='alert alert-warning'>Nothing to see here!<a href='clients.php'>Head Back!</a></div>";
}

//=========SUBMIT UPDATE BUTTON=============

//check if update button is pressed
if(isset($_POST['update'])){
  //set variables that are gonna overvrite
  $clientName = validateFormData($_POST['clientName']);
  $clientEmail = validateFormData($_POST['clientEmail']);
  $clientPhone = validateFormData($_POST['clientPhone']);
  $clientAddress = validateFormData($_POST['clientAddress']);
  $clientCompany = validateFormData($_POST['clientCompany']);
  $clientNotes = validateFormData($_POST['clientNotes']);

  //create new database query and result
  $query = "UPDATE clients
            SET name = '$clientName',
                email = '$clientEmail',
                phone = '$clientPhone',
                address = '$clientAddress',
                company = '$clientCompany',
                notes = '$clientNotes'
                WHERE id = '$clientId'";

  //store thaht in result
  $result = mysqli_query($conn, $query);

  //check to see if there is result
  if($result){
    header('Location:clients.php?alert=updatesuccess');
  } else {
    echo "Error :" . $query . "<br>" . mysqli_error($conn);
  }

}


//============   DELETE BUTTON    ==============

//check if delete button is submitted

if(isset($_POST['delete'])){

  $alertMessage = "<div class='alert alert-danger'>
  <p>Are you sure to delete this client? No take backs!</p><br>
  <form action='". htmlspecialchars($_SERVER["PHP_SELF"]) ."?id=$clientId' method='post'>
    <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
    <a class='btn btn-default btn-sm' type='button' data-dismiss='alert'>Oops, no thanks!</a>
  </form>
  </div>";

}

//check to see if delete button is pressed
if(isset($_POST['confirm-delete'])){

  //new database and query
  $query = "DELETE FROM clients WHERE id = '$clientId'";
  $result = mysqli_query($conn, $query);

  if($result){
    header('Location: clients.php?alert=deleted');
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }

}

//close mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<h1>Edit Client</h1>

<?php echo @$alertMessage; ?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $clientId; ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo @$clientName; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo @$clientEmail; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo @$clientPhone; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="<?php echo @$clientAddress; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo @$clientCompany; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"><?php echo @$clientNotes; ?></textarea>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>
