<?php 

	function updateSentiment(){

		require("../includes/connect.php");
		require("../includes/string.php");

		

		$selectQuery = "SELECT movieId FROM moviename WHERE name LIKE '%Star Wars%'";
		$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

		$unwantedChars = array(',', '!', '?', "'", " ", ":", "+", "#"); // create array with unwanted chars

		while ($row = mysqli_fetch_array($selectResult)){

			$movieId = mysql_real_escape_string($row['movieId']);
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

			
			foreach($matches as $tweet)
			{
			    //'text'=>$tweet[3],
			    $newData = array("text"=>htmlentities($tweet[3]));
				array_push($data["data"], $newData);

				
			}
			


			//sentiment140 api
			$url_send = 'http://www.sentiment140.com/api/bulkClassifyJson?jackchan715@hotmail.com';
			//$data = '{"data": [{"text": "I love Titanic."}, {"text": "I hate Titanic."}]}';

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

			print_r($sent);
		





	}
}


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
	updateSentiment();
?>
		











