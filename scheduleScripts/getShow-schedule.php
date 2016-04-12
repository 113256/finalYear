<?php 

require('../includes/connect.php');
require('../functions/string.php');

require("../functions/recentlyReleased.php");
require('../functions/getTodayShow.php');
require('../functions/updateRatings.php');


set_time_limit(3600);

//EMPTIES tvshow         		
$truncateQuery = "TRUNCATE TABLE `tvshow`";	
mysqli_query($conn, $truncateQuery) or die(mysqli_error($conn));

/*
$py_script = "py\scraper.py";
$py_args = "";
//exec(pythondirectory file), must use python34 becuse of MySQLdb library
exec('C:\Users\User\AppData\Local\Programs\Python\Python34\python.exe py\scraper.py');
*/

//shows that aired 2 days ago will likely have subtitles
//EVERY 3 DAYS
$twoDaysAgodate = new DateTime('-2 day');
$twoDaysAgodate = $twoDaysAgodate->format('Y-m-d ');
getShows($twoDaysAgodate);

$oneDayAgodate = new DateTime('-1 day');
$oneDayAgodate = $oneDayAgodate->format('Y-m-d ');
getShows($oneDayAgodate);

$date = new DateTime();
$date = $date->format('Y-m-d ');
getShows($date);

echo "done getshow";
?>