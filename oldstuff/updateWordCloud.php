<?php 

	function updateWordCloud(){

		require("../includes/connect.php");
		require("../includes/string.php");

		$updateDate = new DateTime();
		$updateDate= $updateDate->format('Y-m-d');
		//convert to dd/mm/yyyy
		//$oldDate = $updateDate;
		//$timestamp = strtotime($oldDate);
		//$updateDate = date('d/m/Y', $timestamp);

		$selectQuery = "SELECT movieId FROM moviename";
		$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

		$unwantedChars = array(',', '!', '?', "'", " ", ":", "+", "#"); // create array with unwanted chars

		while ($row = mysqli_fetch_array($selectResult)){

			$name = normalizeCaseSen($row['movieId']);
			//$hashtag = "#".$name;

			 

			$results=array();
			//rpp = tweetcount (max=  100)
			$tweetUrl = "http://tweets2csv.com/results.php?q=%23".$name."&rpp=40&submit=Search";
			echo $tweetUrl."<br>";
							
			$htmltext =  file_get_contents($tweetUrl);
			$regex = "#<div class='user'>(.*)(\s*)<div class='text'>(.*)<div class='description'>#";
			preg_match_all($regex, $htmltext, $matches, PREG_SET_ORDER);


			$data = array("data"=>array());

			//for word cloud
			$wordArray = array();
			$unwantedTweetChars = array('/', "\\", 'http', "@", "-", "<a"); 

			foreach($matches as $tweet)
			{
			   

				//get keywords from tweets!
				$words = explode(" ", $tweet[3]);
				foreach ($words as $word){
					if(!contains($word, $unwantedTweetChars) && !in_array(normalize($word), $stopwords)){
						if(!isset($wordArray[$word])){
							$wordArray[$word] = 1;
						} else {
							$wordArray[$word]++;
						}
					}
					
					
				}
			}

			//if not empty
			if(strpos(json_encode($wordArray), '[]') !== false){
				//word cloud
				$wordFilename = normalize($row['movieId']);
				$wordFilepath = '../words/'.$wordFilename.'.txt';
				if(file_put_contents($wordFilepath,json_encode($wordArray)) !=false){
				    echo "added";
				}else{
				    echo "Cannot create file (".basename($newFileName).")";
				}
			} else {
				echo "empty json";
			}

			
			echo "<br> word cloud done ";


			

	}
	}



	
?>
		











