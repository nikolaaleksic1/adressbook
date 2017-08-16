<?php

  $server = 'localhost';
  $username = 'root';
  $password = '';
  $db = 'db_clientaddressbook';

  $conn = mysqli_connect($server, $username, $password, $db);

  if(!$conn) {

    die ("Connection failed: " . mysqli_connect_error());

  } else {

    //echo "Connected successfuly";

  }


 ?>
