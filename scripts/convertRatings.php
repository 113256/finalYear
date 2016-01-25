<?php
	require("../includes/connect.php");

	$selectQuery = "SELECT imdbID FROM imdb";
	$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

	while ($row = mysqli_fetch_array($selectResult)){
		$imdbID = $row['imdbID'];
		//$filename = "../ratings/".$imdbID.".php";
		$oldfilename = "../ratings/".$imdbID.".php";
		$filename = "../ratings/".$imdbID.".csv";
		$file = file_get_contents($oldfilename);
		//echo $file."<br>";

		$dayRatingVote = explode("/", $file);
		//$dayRatingVote = explode("\n", $file);

		//last element is blank
		array_pop($dayRatingVote);
		//print_r($dayRatingVote);

		$headings = "date,rating,votes\n";
		//If filename does not exist, the file is created. Otherwise, the existing file is overwritten, unless the FILE_APPEND flag is set.
		if(file_put_contents($filename,$headings) !=false){
		    echo "heading created (".basename($filename).")";
		}else{
		    echo "Cannot create file (".basename($filename).")";
		}

		foreach ($dayRatingVote as $field){
			$array = explode(":", $field);
			//$array = explode(",", $field);

			//print_r($array) ;
			//$date = strtotime($array[0]);//strtotime to convert to epoch time
			$oldDate = ($array[0]);

			$timestamp = strtotime($oldDate);
			$date = date('d/m/Y', $timestamp);
			//$date = $myDateTime->format('dd/mm/Y');
			echo $date;
			//$date = date("dd-mm-Y", strtotime($oldDate));
			$rating = $array[1];
			$votes = str_replace(",", "", $array[2]);

			/*
			date,close,open
			1-May-12,58.13,3.41
			30-Apr-12,53.98,4.55
			27-Apr-12,67.00,6.78

			*/
			

			$append = $date.",". $rating.",". $votes."\n";
			if(file_put_contents($filename,$append, FILE_APPEND) !=false){
			    echo "appended (".basename($filename).")";
			}else{
			    echo "Cannot create file (".basename($filename).")";
			}

	}	
	}	
		

	


?>