<!DOCTYPE html>
<html lang="en" ng-app="App">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
					<!-- Connect to db-->
					<?php
						if(!($database = mysqli_connect("localhost:3306", "root", "root", "eventwebsite")))
						{?>
							
								<p>Could not connect to the database</p>
							
						<?php
							die("");
						}
						else{?>
							
								<p>Successfully connect to the db!!</p>
						
						<?php
						}
						?>
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