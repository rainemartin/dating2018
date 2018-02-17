<?php
/**
 * User: Raine Padilla
 * Date: 1/23/2018
 * Description: The fat-free "controller" or routing page for the dating website
 */
session_start();
error_reporting(E_ALL);
require_once ('vendor/autoload.php');


// Create the fat-free base instance and set debug level for development
$f3 = Base::instance();
$f3->set('DEBUG', 3);

$f3->route('GET /', function(){
    $view = new View();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /form1', function($f3){
    if(isset($_POST))
    {
        $_SESSION['fName'] = $_POST['fName'];
        $_SESSION['lName'] = $_POST['lName'];
        $_SESSION['age'] = $_POST['age'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['phone'] = $_POST['phone'];

        include ('model/validate.php');
        $success = validateForm1($_SESSION['fName'], $_SESSION['lName'],
            $_SESSION['age'], $_SESSION['phone']);

        $f3->set('fName', $_SESSION['fName']);
        $f3->set('lName', $_SESSION['lName']);
        $f3->set('age', $_SESSION['age']);
        $f3->set('gender', $_SESSION['gender']);
        $f3->set('phone', $_SESSION['phone']);

        if($success)
        {
            $f3->reroute('/form2');
        }
    }

    $template = new Template();
    echo $template->render('views/personalinfo.html');
});

$f3->route('GET|POST /form2', function($f3){
    // Set Session Variables
    if(isset($_POST))
    {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['state'] = $_POST['state'];
        $_SESSION['seeking'] = $_POST['seeking'];
        $_SESSION['biography'] = $_POST['bio'];

        $f3->set('email', $_SESSION['email']);
        $f3->set('state', $_SESSION['state']);
        $f3->set('seeking', $_SESSION['seeking']);
        $f3->set('biography', $_SESSION['biography']);

        $f3->reroute('/form3');
    }

    $template = new Template();
    echo $template->render('views/profile.html');
});

$f3->route('GET|POST /form3', function($f3){
    if(isset($_POST))
    {
        $_SESSION['inHobbies'] = $_POST['indoors'];
        $_SESSION['outHobbies'] = $_POST['outdoors'];

        include ('model/validate.php');
        $success = validateForm3($_SESSION['inHobbies'], $_SESSION['outHobbies']);

        $f3->set('inHobbies', $_SESSION['inHobbies']);
        $f3->set('outHobbies', $_SESSION['outHobbies']);

        if($success)
        {
            $f3->reroute('/results');
        }
    }

    $view = new View();
    echo $view->render('views/interests.html');
});

$f3->route('POST /results', function(){
    echo Template::instance()->render('views/results.html');
});

$f3->run();
