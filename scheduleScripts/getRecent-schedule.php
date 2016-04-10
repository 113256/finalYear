<?php 

require('../includes/connect.php');
require('../includes/string.php');

require("../functions/recentlyReleased.php");
require('../functions/getTodayShow.php');
require('../functions/updateRatings.php');

error_reporting(E_ALL);
ini_set('display_errors','On');
set_time_limit(3600);

/*
$py_script = "py\scraper.py";
$py_args = "";
//exec(pythondirectory file), must use python34 becuse of MySQLdb library
//exec('C:\Users\User\AppData\Local\Programs\Python\Python34\python.exe py\scraper.py');
*/

//recently released and movies in theatres
//EVERY DAY
getRecent();
echo "done getrecent";
?>