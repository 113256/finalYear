<?php 

require('../includes/connect.php');
require('../includes/string.php');

require("../content/theatreReleased.php");
require('../content/getTodayShow.php');
require('../content/updateRatings.php');


set_time_limit(3600);
error_reporting(E_ALL);
ini_set('display_errors','On');
/*
$py_script = "py\scraper.py";
$py_args = "";
//exec(pythondirectory file), must use python34 becuse of MySQLdb library
//exec('C:\Users\User\AppData\Local\Programs\Python\Python34\python.exe py\scraper.py');
*/

//recently released and movies in theatres
//EVERY DAY
getTheatre();
echo "done gettheatre";
?>