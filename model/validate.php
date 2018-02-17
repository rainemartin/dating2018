<?php

$errors = array();


function validName($fName, $lName)
{
    return ctype_alpha($fName) && ctype_alpha($lName);
}

function validAge($age)
{
    return is_numeric($age) && $age > 18;
}

function validPhone($phone)
{
    // Phone format 111-222-3333 has a total of 13 characters
    return !is_numeric($phone) && strlen($phone) < 14;
}

function validIndoor($indoor)
{
    global $f3;
    return in_array($indoor, $f3->get('inHobbies'));
}

function validOutdoor($outdoor)
{
    global $f3;
    return in_array($outdoor, $f3->get('outHobbies'));
}

function validateForm1($fName, $lName, $age, $phone)
{
    if(!validName($fName, $lName))
    {
        $errors['name'] = "Please enter a valid string for first and last name.";
    }
    if(!validAge($age))
    {
        $errors['age'] = "You must be over 18 to join this site. This field accepts numbers only.";
    }

    if(!validPhone($phone))
    {
        $errors['phone'] = "Phone number should be formatted as 123-456-7890";
    }

    $success = sizeof($errors) == 0;

    return $success;
}

function validateForm3($indoor, $outdoor)
{
    if(!validIndoor($indoor))
    {
        $errors['indoor'] = "Please select a valid interest.";
    }

    if(!validOutdoor($outdoor))
    {
        $errors['outdoor'] = "Please select a valid interest.";
    }

    $success = sizeof($errors) == 0;
    return $success;
}

function getErrors()
{

}