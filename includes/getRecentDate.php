<?php 

$xml = simplexml_load_file("http://api.myapifilms.com/imdb/inTheaters?token=870c3596-fa05-4ced-82cf-a76d58be8a5a&format=xml&language=en-us");
//the "recently released" date
$date = htmlentities($xml->data->movies->date);
$trim = trim(str_replace(" ", "", $date));
$trim = str_replace("&nbsp;", "", $trim);

//$rest = substr("abcdef", -1);    // returns "f"
$day = substr($trim, -2);
$month =  substr($trim, 0,3);
$year = date("Y");
//echo $date;
$formattedRecentDate = $day. " ". $month. " ". $year;
//echo $formattedRecentDate;
?>