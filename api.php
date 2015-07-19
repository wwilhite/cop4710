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

    if(!($database = mysqli_connect('localhost:3306', 'root', 'root', 'eventwebsite'))){
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
    if(!($database = mysqli_connect('localhost:3306', 'root', 'root', 'eventwebsite'))){
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
