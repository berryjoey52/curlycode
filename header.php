<!DOCTYPE html>
<html lang="en">
<body>
<?php
/**
 * Class: csci303sp20
 * U
 */


//Sessions

//Current File
$currentfile = basename($_SERVER['PHP_SELF']);

//Current Time
$currenttime = time();

//Error Reporting
ERROR_REPORTING(E_ALL);
ini_set('display_errors');
//Required Files
require_once "connect.php";
require_once "functions.php";



?>

<head>
    <meta charset="UTF-8">
    <title>CSCI303SP20</title>
</head>
<body>
<header>
    <h1> Links </h1>
    <nav>
    <a href="index.php"> Home</a>
    <a href="signup.php"> Sign-up</a>

    </nav>
</header>


