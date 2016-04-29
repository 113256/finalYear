<?php 
	//print ratings
	//0 for votes, 1 for rating
	/*
	function printChartData2($votesOrRating, $imdbID){

	$file = file_get_contents("ratings/".$imdbID.".php");
	//echo $file."<br>";
	$dayRatingVote = explode("/", $file);
	//last element is blank
	array_pop($dayRatingVote);
	//print_r($dayRatingVote);

	$dataString = "";

	foreach ($dayRatingVote as $field){
		$array = explode(":", $field);
		//print_r($array) ;
		$date = strtotime($array[0])*1000;//strtotime to convert to epoch time
		$rating = $array[1];
		$votes = str_replace(",", "", $array[2]);


		////data format [{x: abc, y:def}, {x: abc, y:def}]
		if ($votesOrRating == 0){
			$dataString.='{"x":'.$date.',"y":'.$votes.'},';
		} else {
			$dataString.='{"x":'.$date.',"y":'.$rating.'},';
		}
		

	}
	$dataString = rtrim($dataString, ",");
	echo $dataString;
	}
*/


	/*
	* print the chart data string for votes/rating by finding the file corresponding to the imdbID 
	*@param votesOrRating 0 for votes, 1 for rating
	*@return the string in this format [ 1136005200000 , 1271000.0] , [ 1138683600000 , 1271000.0], used by the charting library
	*/
	function printChartData($votesOrRating, $imdbID){

	$file = file_get_contents("ratings/".$imdbID.".php");
	//echo $file."<br>";
	$dayRatingVote = explode("/", $file);
	//last element is blank
	array_pop($dayRatingVote);
	//print_r($dayRatingVote);

	/*[ 1136005200000 , 1271000.0] , [ 1138683600000 , 1271000.0] ,*/

	$dataString = "";

	foreach ($dayRatingVote as $field){
		$array = explode(":", $field);
		//print_r($array) ;
		$date = strtotime($array[0])*1000;//strtotime to convert to epoch time
		$rating = $array[1];
		$votes = str_replace(",", "", $array[2]);


		////data format [{x: abc, y:def}, {x: abc, y:def}]
		if ($votesOrRating == 0){
			$dataString.="[".$date.",".$votes."],";
		} else {
			$dataString.="[".$date.",".$rating."],";
		}
		

	}
	$dataString = rtrim($dataString, ",");
	echo $dataString;
	//return $dataString;
	}


	//0 = positive , 1 = negative, 2 = neutral 3= no.tweets
	/*function printSentiment($index, $name){

	$file = file_get_contents("sentiment/".$name.".txt");
	//echo $file."<br>";
	$dayRatingVote = explode("/", $file);
	//last element is blank
	array_pop($dayRatingVote);
	//print_r($dayRatingVote);

	$dataString = "";

	foreach ($dayRatingVote as $field){
		$array = explode(";", $field);
		//print_r($array) ;
		$date = strtotime($array[4]);//strtotime to convert to epoch time
		//echo "s".$array[4];

		$postive = $array[0];
		$negative = $array[1];
		$neutral = $array[2];	
		$tweetCount = $array[3];

		switch ($index) {
			case 0:
				$dataString.="{x:".$date.",y:".$postive."},";
				break;
			case 1:
				$dataString.="{x:".$date.",y:".$negative."},";
				break;
			case 2:
				$dataString.="{x:".$date.",y:".$neutral."},";
				break;
			case 3:
				$dataString.="{x:".$date.",y:".$tweetCount."},";
				break;
			default:
				# code...
				break;
		}
		

	}
	$dataString = rtrim($dataString, ",");
	echo $dataString;
	}*/
	//printSentiment(0, "ExMachina");


	/*
	* print the chart data string for sentiment by finding the file corresponding to the name
	*@param index 0 for positive, 1 for negative, 2 for neutral
	*@return the string in this format [date,sentiment], used by the charting library
	*/
	function printSentiment($index, $name){

	$file = file_get_contents("sentiment/".$name.".txt");
	//echo $file."<br>";
	$dayRatingVote = explode("/", $file);
	//last element is blank
	array_pop($dayRatingVote);
	//print_r($dayRatingVote);

	$dataString = "";

	foreach ($dayRatingVote as $field){
		$array = explode(";", $field);
		//print_r($array) ;
		$date = strtotime($array[4])*1000;//strtotime to convert to epoch time
		//echo "s".$array[4];

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
	echo $dataString;
	}

	/*
	returns the word cloud string in the below format by finding the file corresponding to the movie id
	*/
	function printWordCloud($normalizedId){
		/*
		var words = [
	  {text: "Lorem", weight: 13},
	  {text: "Ipsum", weight: 10.5}
	  ];

		*/
	  $file = 'words/'.$normalizedId.'.txt';
	  $wordArray = (array) json_decode(file_get_contents($file));
	  //print_r($wordArray);

	  $string = 'var words = [';
	  foreach($wordArray as $word => $wordCount){//key=>word so we can print both the key and the value.
	  	$string .= '{text: "'.str_replace('"', "", $word).'", weight: '.$wordCount.'},';
	  }
	  $string = rtrim($string, ",");
	  $string .= '];';
	  echo $string;
	}
	//printWordCloud('extraction');

?>