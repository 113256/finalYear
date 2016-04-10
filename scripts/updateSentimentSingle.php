<?php 
	//i = 1, first half, i = 2, second half
	function updateSentiment(){

		require("../includes/connect.php");
		require("../includes/string.php");

		//empty ranking table      		
		//$truncateQuery = "TRUNCATE TABLE `sentrank`";	
		//mysqli_query($conn, $truncateQuery) or die(mysqli_error($conn));

		$updateDate = new DateTime();
		$updateDate= $updateDate->format('Y-m-d G:i:s');//G = 24 hour format
		//convert to dd/mm/yyyy
		//$oldDate = $updateDate;
		//$timestamp = strtotime($oldDate);
		//$updateDate = date('d/m/Y', $timestamp);

		$rowCountQuery = "SELECT COUNT(*) FROM moviename";
		$rowCount = mysqli_query($conn, $rowCountQuery);
		$rowCountRow = mysqli_fetch_array($rowCount);
		$rowCount = $rowCountRow[0];
		$count = round($rowCount/2, 0, PHP_ROUND_HALF_UP);

		
			$selectQuery = "SELECT movieId FROM moviename WHERE name LIKE 'Inside Out'";
		
		//$selectQuery = "SELECT movieId FROM moviename";
		$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

		$unwantedChars = array(',', '!', '?', "'", " ", ":", "+", "#"); // create array with unwanted chars

		while ($row = mysqli_fetch_array($selectResult)){
			$movieId = mysqli_real_escape_string($conn, $row['movieId']);
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
			    //'text'=>$tweet[3],
			    $newData = array("text"=>htmlentities($tweet[3]));
				array_push($data["data"], $newData);

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
			//word cloud
			//if array not empty then update
			if(json_encode($wordArray)!= "[]"){
				$wordFilename = normalize($row['movieId']);
				$wordFilepath = '../words/'.$wordFilename.'.txt';
				if(file_put_contents($wordFilepath,json_encode($wordArray)) !=false){
				    echo "added";
				}else{
				    echo "Cannot create file (".basename($newFileName).")";
				}
				echo "<br> word cloud done ";
			} else {
				echo "empty json";
			}

			//sentiment140 api
			$url_send = 'http://www.sentiment140.com/api/bulkClassifyJson?jackchan715@hotmail.com';
			//$data = '{"data": [{"text": "I love Titanic."}, {"text": "I hate Titanic."}]}';

			/*
			Requests should be sent via HTTP POST to http://www.sentiment140.com/api/bulkClassifyJson. 
			The body of the message should be a JSON object

			e.g. {"data": [{"text": "I love Titanic."}, 
         					 {"text": "I hate Titanic."}]}
			*/

			/*
			$data = array(
						"data"=> array(0=>array("text"=>"I love Titanic."), 
									   1=>array("text"=> "I hate Titanic.")
									   )
						);
			*/
			$str_data = json_encode($data);
			$result = sendPostData($url_send, $str_data);
			//echo $result;
			$data = json_decode($result); //true for array format
			//print_r to see the json in array for so you know how to parse
			//$rating = $data['data']['movies'][0]['rating'];
			//print_r($data);

			$sent = array(
			            "positive" => 0,
			            "negative" => 0,
			            "neutral" => 0,
			            "tweetCount"=>0
			        );

			foreach($data->data as $tweet){
				if($tweet->polarity == 4) {
			        $sent['positive']++;
			    }
			    else if($tweet->polarity == 2) {
			        $sent['neutral']++;
			    }
			    else if($tweet->polarity == 0) {
			        $sent['negative']++;
			    }
			    $sent['tweetCount']++;
			}

			$positive = $sent['positive']; 
			$negative = $sent['negative'];
			$sentQuery = "INSERT into `sentrank` (`movieId`, `positive`, `negative`) VALUES ('$movieId', '$positive', '$negative') ON DUPLICATE KEY UPDATE `positive`='$positive', `negative`='$negative'";
			if (!mysqli_query($conn,$sentQuery)) {
				  die('Error: ' . mysqli_error($conn));
				}
				echo "sentrank updated,  ";

			//format (just split by / and :)
			$newFileName = '../sentiment/'.$name.".txt";
			$appendContent = $sent['positive'].";".$sent['negative'].";".$sent['neutral'].";".$sent['tweetCount'].";".$updateDate."/";


			//If filename does not exist, the file is created. Otherwise, the existing file is overwritten, unless the FILE_APPEND flag is set.
			if(file_put_contents($newFileName,$appendContent,  FILE_APPEND) !=false){
			    echo "File created (".basename($newFileName).")";
			}else{
			    echo "Cannot create file (".basename($newFileName).")";
			}
		}
		mysqli_close($conn);

	}


	updateSentiment();

	function sendPostData($url, $post){
			  $ch = curl_init($url);
			  $headers= array('Accept: application/json','Content-Type: application/json'); 
			  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			  curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
			  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
			  $result = curl_exec($ch);
			  curl_close($ch);  // Seems like good practice
			  return $result;
			}
	
?>
		























