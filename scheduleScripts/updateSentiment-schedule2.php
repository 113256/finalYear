<?php 

require('../includes/connect.php');
//require('../functions/string.php');

require("../functions/recentlyReleased.php");
require('../functions/getTodayShow.php');
require('../functions/updateSentiment.php');
	
error_reporting(E_ALL);
ini_set('display_errors','On');
ignore_user_abort(true);
set_time_limit(7200);

/*
$py_script = "py\scraper.py";
$py_args = "";
//exec(pythondirectory file), must use python34 becuse of MySQLdb library
exec('C:\Users\User\AppData\Local\Programs\Python\Python34\python.exe py\scraper.py');
*/


//update ratings
//format (just split by , and :)
//date:rating(imdb):votes,date:rating(imdb):votes, date:rating(imdb):votes, ..
updateSentiment(2);
echo "done update sent2";
?>