<?php
/**
 * User: Raine Padilla
 * Date: 1/23/2018
 * Description: The fat-free "controller" or routing page for the dating website
 */
error_reporting(E_ALL);
require_once ('vendor/autoload.php');

// Create the fat-free base instance and set debug level for development
$f3 = Base::instance();
$f3->set('DEBUG', 3);

$f3->route('GET /', function(){
    $view = new View();
    echo $view->render('views/home.html');
});

$f3->route('GET /form1', function(){
   $view = new View();
   echo $view->render('views/personalinfo.html');
});

$f3->route('GET /form2', function(){
    $view = new View();
    echo $view->render('views/profile.html');
});

$f3->route('GET /form3', function(){
    $view = new View();
    echo $view->render('views/interests.html');
});

$f3->run();
