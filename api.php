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
$app->get('/user', function () use($app) {
    if(!($database = mysqli_connect('localhost', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }

    $new = sprintf("select s_id, s_fname from student where  s_uname='%s' AND s_pw='%s' limit 1", $app->request()->put("username"), $app->request()->put("password"));

    $result = mysqli_query($database, $new);
    if(!$result){
        echo mysqli_error($database);
    }else{
        echo json_encode($result->fetch_assoc());
    }
});

$app->get('/event', function () use($app) {

    echo "get event";

});

$app->post("/event", function () use($app) {

    echo "post university";

});

$app->get('/university', function () use($app) {

    if(!($database = mysqli_connect('localhost', 'root', 'root', 'eventwebsite'))){
        die("Could not reconnect to the database. Server error.");
    }
    echo "get university";

});

$app->post("/university", function () use($app) {

    echo "post university";

});
$app->run();
