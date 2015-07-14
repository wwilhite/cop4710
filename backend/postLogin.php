<?php
// postLogin.php

// connect to the db
if(!($database = mysqli_connect("localhost:3306", "root", "root", "eventwebsite"))){
      die("Could not reconnect to the database. Server error.");
}

// Retrieve the posted data
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$username = $request->username;
@$password = $request->password;

// Look for this username/pw tuple in the database
$searchQuery = "SELECT s_id FROM student WHERE s_uname = '" .$username ."' AND s_pw = '" . $password ."'"; 

if(!($result = mysqli_query($database, $searchQuery))){
    ?>
    <h1 class = "err"><strong>Major Error:</strong></h1>
    <p>A SQL Exception occurred while interacting with the eventwebsite database.</p>
    <br />
    <p>The error message was:</p>
    
    <p><strong><?php echo mysqli_error($database);?></strong></p>


    
    <p>Please try again later.</p>
  <?php
    /*echo "Error, could not add student.<br />" ;
    echo "sid = " . $sid ."<br />";
    echo "fname = " . $fname . "<br />";
    echo "lname = " . $lname . "<br />";
    echo "uname = " . $uname . "<br />";
    echo "password = " . $password . "<br />";
    echo "email = " . $email . "<br />";
    echo "uid = " . $uid . "<br />";*/
    print($searchQuery);

    die("");
  }
  else{
    echo "Username + Password match found!";
  }


?>