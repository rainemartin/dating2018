<?php
/**
 * User: Raine Padilla
 * Date: 1/23/2018
 * Description: The fat-free "controller" or routing page for the dating website
 */
error_reporting(E_ALL);
require_once ('vendor/autoload.php');

session_start();
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
        $premium = false;

        include ('model/validate.php');
        $success = validateForm1($_SESSION['fName'], $_SESSION['lName'],
            $_SESSION['age'], $_SESSION['phone']);

        $f3->set('fName', $_SESSION['fName']);
        $f3->set('lName', $_SESSION['lName']);
        $f3->set('age', $_SESSION['age']);
        $f3->set('gender', $_SESSION['gender']);
        $f3->set('phone', $_SESSION['phone']);

        echo $f3->get('fName');
        echo $f3->get('lName');

        if($success)
        {
            if(isset($_POST['memberType']))
            {
                $premium = true;
                $member = new PremiumMember($_SESSION['fName'], $_SESSION['lName'], $_SESSION['age'],
                                            $_SESSION['gender'], $_SESSION['phone']);
            }
            else
            {
                $member = new Member($_SESSION['fName'], $_SESSION['lName'], $_SESSION['age'],
                    $_SESSION['gender'], $_SESSION['phone']);
            }
            $_SESSION['premium'] = $premium;
            $_SESSION['member'] = $member;
            $f3->reroute('/form2');
        }
    }

    $template = new Template();
    echo $template->render('views/personalinfo.html');
});

$f3->route('GET|POST /form2', function($f3){
    if(isset($_POST))
    {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['state'] = $_POST['state'];
        $_SESSION['seeking'] = $_POST['seeking'];
        $_SESSION['biography'] = $_POST['bio'];

        include('model/validate.php');
        $success = validEmail($_SESSION['email']);

        $f3->set('email', $_SESSION['email']);
        $f3->set('state', $_SESSION['state']);
        $f3->set('seeking', $_SESSION['seeking']);
        $f3->set('biography', $_SESSION['biography']);

        $member = $_SESSION['member'];
        $member->setEmail($_SESSION['email']);
        $member->setState($_SESSION['state']);
        $member->setSeeking($_SESSION['seeking']);
        $member->setBio($_SESSION['biography']);

        $_SESSION['member'] = $member;

        if($success)
        {
            if($_SESSION['premium'])
            {
                $f3->reroute('/form3');
            }
            else
            {
                $f3->reroute('/results');
            }
        }
    }

    $template = new Template();
    echo $template->render('views/profile.html');
});

$f3->route('GET|POST /form3', function($f3){

    $view = new Template();
    echo $view->render('views/interests.html');
});

$f3->route('GET|POST /results', function($f3){
    if(isset($_POST))
    {
        $_SESSION['inHobbies'] = $_POST['indoors'];
        $_SESSION['outHobbies'] = $_POST['outdoors'];

        $f3->set('inHobbies', $_SESSION['inHobbies']);
        $f3->set('outHobbies', $_SESSION['outHobbies']);

        include('model/validate.php');

        $member = $_SESSION['member'];

        // Won't reach this code unless member is premium
        $member->setIndoorInterests($_SESSION['inHobbies']);
        $member->setOutdoorInterests($_SESSION['outHobbies']);
    }
    echo Template::instance()->render('views/results.html');
});

$f3->run();
