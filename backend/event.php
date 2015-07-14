<?php
// retrieves all events from db

// connect to the db
if(!($database = mysqli_connect("localhost:3306", "root", "root", "eventwebsite"))){
			die("Could not reconnect to the database. Server error.");
}

$queryText = "SELECT * FROM event e";

// get all events from db
$res = mysqli_query($database,$queryText);

$arr = array();
if($res->num_rows > 0){
	while($row = $res->fetch_assoc()){
		$arr[] = $row;
	}
}

// JSON encode the response
$json_response = json_encode($arr);

// return the response
echo $json_response;

?>