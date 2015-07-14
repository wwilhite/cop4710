<?php
// postStudent.php

// connect to the db
if(!($database = mysqli_connect("localhost:3306", "root", "root", "eventwebsite"))){
      die("Could not reconnect to the database. Server error.");
}

// Retrieve the posted data
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$sid = $request->sid;
@$fname = $request->fname;
@$lname = $request->lname;
@$uname = $request->uname;
@$password = $request->pass;
@$email = $request->email;
@$uid = $request->uid;

// Create INSERT query
$newStudent = "INSERT INTO student (s_id,s_fname,s_lname,s_uname,s_pw,s_email,u_id) VALUES (" .$sid .",'" .$fname ."','" .$lname . "','" .$uname . "','" .$password . "','" .$email . "'," .$uid .")" ;
// Execute the query and add new student to db

  if(!($result = mysqli_query($database, $newStudent))){
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
    echo "uid = " . $uid . "<br />";
    print($newStudent);*/

    die("");
  }
  else{
    echo "Successfully added new student!";
  }

?>