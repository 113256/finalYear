<?php

/*
* gets the latest theatre releases by scraping igoogle.flixter.com 
* NOTE- igoogle.flixter is no longer live.
*/
function getTheatre(){

	require("../includes/connect.php");
	require("../functions/newMovie.php");

	//EMPTIES INTHEATRES         		
	$truncateQuery = "TRUNCATE TABLE `intheatres`";	
	mysqli_query($conn, $truncateQuery) or die(mysqli_error($conn));
	
	$scrapeUrl = 'http://igoogle.flixster.com/igoogle/showtimes';
	$text = file_get_contents($scrapeUrl);

	$outerRegex = '#(?s)<select name="movie">(.*?)<\/select>#';
	preg_match($outerRegex, $text, $outer);
	echo $outer[0];

	$showtimeRegex= '#<option value="(\d*)" >[\s]*(.*)#';
	preg_match_all($showtimeRegex, $outer[0], $showtimes, PREG_SET_ORDER);

	foreach($showtimes as $show){
		//echo $show[0];
		$code = $show[1];
		$title=  $show[2];
		if(substr($title, -3) == "..."){
			//echo $name;
			//echo $code;
			$movieUrl = 'http://igoogle.flixster.com/igoogle/m/'.$code;
			$movieText = file_get_contents($movieUrl);
			$titleRegex = '#<h1 id="title">(.*)</h1>#';
			preg_match($titleRegex, $movieText, $title);
			$title = $title[1];
		} 

		echo "title is ";
		if(IsEmpty($title)){
			continue;
		}
		//$title = htmlentities ($title);	
		//$title = str_replace("'", "", $title);
		echo $title."<br>";

		$selectQuery = "SELECT movieId FROM moviename";
		$selectResult = mysqli_query($conn, $selectQuery);
        $exists = 0;
        while($row = mysqli_fetch_array($selectResult)){
        	 if (fuzzy_match($title, $row['movieId'])){
        	 	$exists = 1;
        	 	break;
        	 }
        }

          if ($exists == 1){
          		echo "exists <br>";
          		$movieId = str_replace(" ", "+", $title);
          			echo " movie id111 is ".$movieId;
          		$movieId = mysqli_real_escape_string($conn, $movieId);
          		echo "title is ".$title. " movie id is ".$movieId;
          		if(IsEmpty($movieId)){
					continue;
				}
          		echo "inserting into theatre";
          		$theatreInsertQurey = "INSERT INTO `intheatres` (`movieId`, `code`) VALUES ('$movieId', '$code')";
          		 mysqli_query($conn, $theatreInsertQurey) or die(mysqli_error($conn));
               continue ;
          } else {


          	echo "doesnt exist <br>";
          	//doesnt exists
          		echo "downloading new movie data";
          		newMovie($title);
	          	$movieId = mysqli_real_escape_string($conn, str_replace(" ", "+", $title));
	          	if(IsEmpty($movieId)){
					continue;
				}
	      		$theatreInsertQurey = "INSERT INTO `intheatres` (`movieId`, `code`) VALUES ('$movieId', '$code')";
	      		mysqli_query($conn, $theatreInsertQurey) or die(mysqli_error($conn));      		
          }
          echo "<br>";
	}
//endfunction
}
?>