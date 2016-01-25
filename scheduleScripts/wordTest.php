<?php 
//require("../includes/string.php");
	function testword(){

		require("../includes/connect.php");
		require("../includes/string.php");
		
			//$name = str_replace($unwantedChars, "", $row['movieId']);
			//$hashtag = "#".$name;

			 

	
			//rpp = tweetcount (max=  100)
			$tweetUrl = "http://tweets2csv.com/results.php?q=%23starwars&rpp=40&submit=Search";
			echo $tweetUrl."<br>";

			$htmltext =  file_get_contents($tweetUrl);
			$regex = "#<div class='user'>(.*)(\s*)<div class='text'>(.*)<div class='description'>#";
			preg_match_all($regex, $htmltext, $matches, PREG_SET_ORDER);


			
			$wordArray = array();

			$unwantedChars = array('/', "\\", 'http', "@", "-", "<a"); 
			 

			foreach($matches as $tweet)
			{
			    //'text'=>$tweet[3],
			    //$newData = array("text"=>htmlentities($tweet[3]));
				//array_push($data["data"], $newData);
				//echo $tweet[3]."<br>";
				$words = explode(" ", $tweet[3]);
				foreach ($words as $word){
					if(!contains($word, $unwantedChars) && !in_array(normalize($word), $stopwords)){
						if(!isset($wordArray[$word])){
							$wordArray[$word] = 1;
						} else {
							$wordArray[$word]++;
						}
					}
					
					
				}

				
			}
			$newFileName = '../words/starwars.txt';
				if(file_put_contents($newFileName,json_encode($wordArray)) !=false){
				    echo "added";
				}else{
				    echo "Cannot create file (".basename($newFileName).")";
				}
				echo "<br>";

		
			//format (just split by / and :)
			/*$newFileName = '../sentiment/'.$name.".txt";
			$appendContent = $sent['positive'].";".$sent['negative'].";".$sent['neutral'].";".$sent['tweetCount'].";".$updateDate."/";


			//If filename does not exist, the file is created. Otherwise, the existing file is overwritten, unless the FILE_APPEND flag is set.
			if(file_put_contents($newFileName,$appendContent,  FILE_APPEND) !=false){
			    echo "File created (".basename($newFileName).")";
			}else{
			    echo "Cannot create file (".basename($newFileName).")";
			}*/
		}

	testword();
		//$unwantedChars = array('/', "\\", 'http', "@", "-", "<a"); 
		//echo contains('"\"I"', $unwantedChars);
	




	
?>
		











