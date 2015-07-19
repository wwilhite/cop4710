<?php
require './Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->contentType("application/json");

//post user
//$app->add(new \Slim\Middleware\ContentTypes());

$app->post("/user", function () use($app) {
    $firstname = $app->request()->put('firstname');
    $lastname = $app->request()->put('lastname');
    $email = $app->request()->put('email');
    $username = $app->request()->put('username');
    $password = $app->request()->put('password');
    $role = $app->request()->put('role');
    if($role == "student") {
        $universityid = $app->request()->put('universityid');
    } else {
        $universityid = -1;
    }

    if(!($database = mysqli_connect('localhost', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }

    $new = "INSERT INTO student (s_id,s_fname, s_lname, s_email, s_uname, s_pw, u_id) VALUES (1000,'".$firstname."','".$lastname."' ,'".$email."', '".$username."', '".$password."' ,".$universityid.")";

    if(!($result = mysqli_query($database, $new))){
        echo mysqli_error($database);
    }else{
        echo "worked";
    }
});

//get user
$app->get('/user(/:username)(/:password)', function ($username, $password) use($app) {
    $response = array();
    if(!($database = mysqli_connect('localhost', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }

    $query = sprintf("select s_id, s_fname from student where  s_uname='%s' AND s_pw='%s' limit 1", $username, $password);

    $result = $database->query($query);
    $row = $result->fetch_assoc();
    if($result->num_rows < 1) {
        echo mysqli_error($database);
    } else if($result->num_rows > 1) {
        echo mysqli_error($database);
    }else{
        $response["s_id"] = $row["s_id"];
        $response["s_fname"] = $row["s_fname"];
        //TODO add role

        echo json_encode($response);
    }
});

$app->get('/event', function () use($app) {
    $e_id = $app->request()->get('e_id');
    if(!($database = mysqli_connect('localhost', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }
	echo "THISSTRING" . $e_id;
	$query = sprintf("SELECT e_name, e_description, e_phone, e_email FROM event WHERE e_id = " . $e_id);
	$result = $database->query($query);
	$app->contentType('application/json');

	if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo json_encode($row);
		}
	} else {
        echo "0 results";
	}
});

$app->post("/event", function () use($app) {
    echo "post university";
});

$app->get('/university', function () use($app) {
    $e_id = $app->request()->get('u_id');

    if(!($database = mysqli_connect('localhost', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }

	$query = sprintf("SELECT e_name, e_description, e_phone, e_email FROM event WHERE e_id = " . $e_id);
	$result = $database->query($query);
	$app->contentType('application/json');

	if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo json_encode($row);
		}
	} else {
        echo "0 results";
	}
});

$app->post("/university", function () use($app) {

    echo "post university";

});
$app->run();
