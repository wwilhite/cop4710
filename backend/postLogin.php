<?php
// postLogin.php

// connect to the db
if(!($database = mysqli_connect("localhost:3306", "root", "root", "eventwebsite"))){
      die("Could not reconnect to the database. Server error.");
}

// retrieve the posted data
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$username = $request->username;
@$password = $request->password;

// look for this username/pw tuple in the student table
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
    echo $searchQuery . "<br />";
    die("");
  }
  else{
    /*print ("Username + Password match found!");
    print (http_response_code());*/
  }

// check for student
if($result->num_rows > 0){
	$role = 1;
}
else{
	$role = 0;
}

// check if admin
$searchAdmin = "SELECT s_id FROM admin WHERE s_id in (SELECT s_id FROM student WHERE s_uname = '" .$username . "' AND s_pw = '" .$password ."')";

// run the searchAdmin query
if(!($result = mysqli_query($database, $searchAdmin))){
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
    echo $searchAdmin . "<br />";
    die("");
  }

// get results of admin query
if($result->num_rows > 0){
	$role = 2;
}

// check if superadmin
$searchSuper = "SELECT s_id FROM superadmin WHERE s_id in (SELECT s_id FROM student WHERE s_uname = '" .$username . "' AND s_pw = '" .$password ."')";

// run the searchSuper query
if(!($result = mysqli_query($database, $searchSuper))){
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
    echo $searchSuper;

    die("");
  }

// get results of superadmin query
if($result->num_rows > 0){
	$role = 3;
}

// JSON encode the reponse
/*$json_response = json_encode($role)*/;

// return the response
echo $role;

?>

