<?php 
//chdir(dirname(__FILE__));
require('../includes/connect.php');
require('../includes/string.php');

require("../content/recentlyReleased.php");
require('../content/getTodayShow.php');
require('../content/updateRatings.php');

error_reporting(E_ALL);
ini_set('display_errors','On');
set_time_limit(7200);

/*
$py_script = "py\scraper.py";
$py_args = "";
//exec(pythondirectory file), must use python34 becuse of MySQLdb library
//exec('C:\Users\User\AppData\Local\Programs\Python\Python34\python.exe py\scraper.py');
*/


//update ratings
//format (just split by , and :)
//date:rating(imdb):votes,date:rating(imdb):votes, date:rating(imdb):votes, ..
updateRating();
echo "done updaterating";
?>