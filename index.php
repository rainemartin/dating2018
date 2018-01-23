<?php
/**
 * User: Raine Padilla
 * Date: 1/23/2018
 * Description: The fat-free "controller" or routing page for the dating website
 */
require_once ('vendor/autoload.php');

// Create the fat-free base instance and set debug level for development
$f3 = Base::instance();
$f3->set('DEBUG', 3);

$f3->route('GET /', function ()
{
    $view = new View();
    echo $view->render('views/home.html');
});

$f3->run();
