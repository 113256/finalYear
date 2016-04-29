<?php
date_default_timezone_set('Europe/London');


//copied from functions folder 
 function printChartData($votesOrRating, $imdbID){
	$file = file_get_contents("../ratings/".$imdbID.".php");
	$dayRatingVote = explode("/", $file);
	array_pop($dayRatingVote);
	$dataString = "";
	foreach ($dayRatingVote as $field){
		$array = explode(":", $field);
		$date = strtotime($array[0])*1000;//strtotime to convert to epoch time
		$rating = $array[1];
		$votes = str_replace(",", "", $array[2]);
		if ($votesOrRating == 0){
			$dataString.="[".$date.",".$votes."],";
		} else {
			$dataString.="[".$date.",".$rating."],";
		}
	}
	$dataString = rtrim($dataString, ",");
	return $dataString;
}


function printSentiment($index, $name){
	$file = file_get_contents("../sentiment/".$name.".txt");
	$dayRatingVote = explode("/", $file);
	array_pop($dayRatingVote);
	$dataString = "";
	foreach ($dayRatingVote as $field){
		$array = explode(";", $field);
		$date = strtotime($array[4])*1000;//strtotime to convert to epoch time
		$postive = $array[0];
		$negative = $array[1];
		$neutral = $array[2];	
		$tweetCount = $array[3];
		switch ($index) {
			case 0:
				$dataString.="[".$date.",".$postive."],";
				break;
			case 1:
				$dataString.="[".$date.",".$negative."],";
				break;
			case 2:
				$dataString.="[".$date.",".$neutral."],";
				break;
			case 3:
				$dataString.="[".$date.",".$tweetCount."],";
				break;
			default:
				# code...
				break;
		}
	}
	$dataString = rtrim($dataString, ",");
	return $dataString;
}
/*
printSentiment(0, "test");
echo "<br>";
printSentiment(1, "test");
echo "<br>";
printSentiment(2, "test");
echo "<br>";
printSentiment(3, "test");
*/
?>