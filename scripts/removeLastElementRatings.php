<?php
	require("../includes/connect.php");

	$selectQuery = "SELECT imdbID FROM imdb";
	$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

	while ($row = mysqli_fetch_array($selectResult)){
		$imdbID = $row['imdbID'];
		//$filename = "../ratings/".$imdbID.".php";

		$filename = "../ratings/".$imdbID.".php";
		$file = file_get_contents($filename);
		//echo $file."<br>";

		$dayRatingVote = explode("/", $file);
		//$dayRatingVote = explode("\n", $file);

		//last element is blank
		array_pop($dayRatingVote);
		array_pop($dayRatingVote);//POP 2nd LAST ELEMENT AS IT HAS WRONG FORMAT
		//print_r($dayRatingVote);

		$append = "";

		foreach ($dayRatingVote as $field){
			$array = explode(":", $field);

			$date = ($array[0]);
			$rating = $array[1];
			$votes = str_replace(",", "", $array[2]);

			

			$append .= $date.":".$rating.":".$votes."/";
			

	}	
	//$append .= $date.":".$rating.":".$votes."/";
	if(file_put_contents($filename,$append) !=false){
			    echo "appended (".basename($filename).")";
			}else{
			    echo "Cannot create file (".basename($filename).")";
			}
	}	
		

	


?>