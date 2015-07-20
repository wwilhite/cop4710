<?php
require './Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->contentType("application/json");

//post user
//$app->add(new \Slim\Middleware\ContentTypes());

$app->post("/user", function () use($app) {
    $response = array();
    $body = json_decode($app->request()->getBody(), true);

    $firstname = $body["firstname"];
    $lastname = $body["lastname"];
    $email = $body["email"];
    $username = $body["username"];
    $password = $body["password"];
    $role = $body["role"];
    $universityid = $body["u_id"];

    if(!($database = mysqli_connect('localhost:3306', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }

    $new = "INSERT INTO student (s_fname, s_lname, s_email, s_uname, s_pw, u_id) VALUES ('".$firstname."','".$lastname."' ,'".$email."', '".$username."', '".$password."', (select u_id from university where u_id='".$universityid."'));";

    if(!($result = mysqli_query($database, $new))){
        echo mysqli_error($database);
    } else {
        // return newly created user
        $query = sprintf("select s_id, s_fname, u_id from student where s_uname='%s' AND s_pw='%s' limit 1", $username, $password);


        $result = $database->query($query);
        $row = $result->fetch_assoc();
        $s_id = $row["s_id"];

        if($role = "super") {
            $query = "insert into superadmin (s_id) VALUES ((select s_id from student where s_id='".$s_id."'))";
            $result = $database->query($query);
        }
        if($result->num_rows != 1) {
            echo mysqli_error($database);
        } else {
            $response["s_id"] = $s_id;
            $response["s_fname"] = $row["s_fname"];
            $response["u_id"] = $row["u_id"];
            $response["role"] = $role;
        }
        echo json_encode($response);
    }
});

//get user
$app->get('/user(/:username)(/:password)', function ($username, $password) use($app) {
    $response = array();
    if(!($database = mysqli_connect('localhost:3306', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }

    $query = sprintf("select s_id, s_fname, u_id from student where s_uname='%s' AND s_pw='%s' limit 1", $username, $password);

    $result = $database->query($query);
    $row = $result->fetch_assoc();
    if($result->num_rows != 1) {
        echo mysqli_error($database);
    } else {
        $response["s_id"] = $row["s_id"];
        $response["s_fname"] = $row["s_fname"];
        $response["u_id"] = $row["u_id"];

        $query = sprintf("select * from superadmin where s_id='%s' limit 1", $row["s_id"]);
        $result = $database->query($query);
        if($result->num_rows == 1) {
            $response["role"] = "super";
        } else {
            $query = sprintf("select * from admin where s_id='%s' limit 1", $row["s_id"]);
            $result = $database->query($query);
            if($result->num_rows == 1) {
                $response["role"] = "admin";
            } else {
                $response["role"] = "student";
            }
        }
    }
    echo json_encode($response);
});

// get events
$app->get('/event', function () use($app) {
    //$e_id = $app->request()->get('e_id');
    if(!($database = mysqli_connect('localhost:3306', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }
	//echo "THISSTRING";
	$query = "SELECT e_name, e_description, e_phone, e_email FROM event";
	/*$result = $database->query($query);*/

    if(!($result = mysqli_query($database, $query))){
    ?>
        <h1 class = "err"><strong>Major Error:</strong></h1>
        <p>A SQL Exception occurred while interacting with the eventwebsite database.</p>
        <br />
        <p>The error message was:</p>

        <p><strong><?php echo mysqli_error($database);?></strong></p>



        <p>Please try again later.</p>
        <?php

        die("");
    }

    // create result array
    $arr = array();

	$app->contentType('application/json');

	if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
		}
        $json_response = json_encode($arr);
        echo $json_response;
	} else {
        echo "0 results";
	}
});

// get all events a user can see
$app->get('/user/events', function () use($app){
    // get s_id of user
    $s_id = $app->request()->get('s_id');


    if(!($database = mysqli_connect('localhost:3306', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }
    $query = sprinf("SELECT e_id,e_name FROM event");
   /* $query = sprintf("SELECT e_id, e_name FROM event WHERE e_public = 1 UNION 
        (SELECT e_id, e_name FROM event WHERE e_private = 1 AND s_id = 
            (SELECT s_id FROM student WHERE u_id = 
                    (SELECT u_id FROM student WHERE s_id = '%s') AND s_id in (SELECT * FROM admin))) ", $s_id);*/
//  TODO: add RSO events to query

    if(!($result = $database->query($query))){
    ?>
        <h1 class = "err"><strong>Major Error:</strong></h1>
        <p>A SQL Exception occurred while interacting with the eventwebsite database.</p>
        <br />
        <p>The error message was:</p>
        <p><strong><?php echo mysqli_error($database);?></strong></p>
        <p>Please try again later.</p>
        <?php
        
        die("");
    }

    // create result array
    $arr = array();

    $app->contentType('application/json');

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        $json_response = json_encode($arr);
        echo $arr;

    } else {
        echo "0 results";
    }

});


$app->post("/event", function () use($app) {
    echo "post university";
});

// get universities
$app->get('/university', function () use($app) {
    //$u_id = $app->request()->get('u_id');

    if(!($database = mysqli_connect('localhost:3306', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }

	$query = "SELECT * FROM university";
	/*$result = $database->query($query);*/

    if(!($result = mysqli_query($database, $query))){
    ?>
        <h1 class = "err"><strong>Major Error:</strong></h1>
        <p>A SQL Exception occurred while interacting with the eventwebsite database.</p>
        <br />
        <p>The error message was:</p>

        <p><strong><?php echo mysqli_error($database);?></strong></p>



        <p>Please try again later.</p>
        <?php

        die("");
    }

    // create result array
    $arr = array();

	$app->contentType('application/json');

	if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
		}
        $json_response = json_encode($arr);
        echo $json_response;
	} else {
        echo "0 results";
	}
});

$app->post("/university", function () use($app) {

    echo "post university";

});
$app->run();
