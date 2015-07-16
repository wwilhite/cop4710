<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    "MODE" => "development",
    "TEMPLATES.PATH" => "./templates"
));

//post user
$app->add(new \Slim\Middleware\ContentTypes());

$app->post("/user", function () use($app) {
	
	$firstname = $app->request()->put('firstname');
	$lastname = $app->request()->put('lastname');
	$email = $app->request()->put('email');
	$username = $app->request()->put('username');
	$password = $app->request()->put('password');
	$role = $app->request()->put('role');
	$universityid = $app->request()->put('universityid');
	
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
$app->get('/user', function () {
	
	echo "get user";
	
});

$app->get('/event', function () {
	
	echo "get event";
	
});


$app->run();

?>


<!DOCTYPE html>
<html lang="en" ng-app="App">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
	<title>University Events</title>
</head>
<body ng-controller="AppController">
	<div class="wrapper">
		<navigation></navigation>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ng-view></ng-view>
				</div>
			</div>
		</div>
		<br>
		<div class="push"></div>
	</div> <!-- End wrapper -->
	<div class="footer" style="">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<p style="">COP4710 Database Systems Final Project</p>
				</div>
			</div>
		</div>
	</div>
	<script src="bower_components/jquery/dist/jquery.js" rel="application/javascript"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.js" rel="application/javascript"></script>
	<script src="bower_components/angular/angular.js" rel="application/javascript"></script>
	<script src="bower_components/angular-bootstrap/ui-bootstrap-tpls.js" rel="application/javascript"></script>
	<script src="bower_components/angular-resource/angular-resource.js" rel="application/javascript"></script>
	<script src="bower_components/angular-route/angular-route.js" rel="application/javascript"></script>
	<script src="bower_components/angular-base64/angular-base64.min.js" rel="application/javascript"></script>
	<script src="bower_components/tinymce/tinymce.min.js" rel="application/javascript"></script>
	<script src="app/app.js" rel="application/javascript"></script>
	<script src="app/controllers/app.controller.js" rel="application/javascript"></script>
	<script src="app/controllers/public.controller.js" rel="application/javascript"></script>
	<script src="app/controllers/super.controller.js" rel="application/javascript"></script>
	<script src="app/controllers/home.controller.js" rel="application/javascript"></script>
	<script src="app/services/services.js" rel="application/javascript"></script>
	<script src="app/services/ui.tinymce.js" rel="application/javascript"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false" rel="application/javascript"></script>
</body>
</html>