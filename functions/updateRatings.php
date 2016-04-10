<?php 

	function updateRating($i){
		echo $i;
		require("../includes/connect.php");


		$updateDate = new DateTime();
		$updateDate= $updateDate->format('Y-m-d');
		//convert to dd/mm/yyyy
		//$oldDate = $updateDate;
		//$timestamp = strtotime($oldDate);
		//$updateDate = date('d/m/Y', $timestamp);



		//$selectQuery = "SELECT imdbID FROM imdb";
		$rowCountQuery = "SELECT COUNT(*) FROM imdb";
		$rowCount = mysqli_query($conn, $rowCountQuery);
		$rowCountRow = mysqli_fetch_array($rowCount);
		$rowCount = $rowCountRow[0];
		echo "number of rows is ".$rowCount."<br>";
		$count = ceil($rowCount/2);
		echo "updating ".$count." rows<br>";

		if($i == 1){
			$selectQuery = "SELECT imdbID FROM imdb LIMIT $count";
		} else if($i == 2){
			//(SELECT * FROM table ORDER BY id DESC LIMIT 50) ORDER BY id ASC
			$selectQuery = "SELECT * FROM (
							    SELECT * FROM imdb ORDER BY movieId DESC LIMIT $count
							) sub
							ORDER BY movieId ASC";
		}
		$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

		while ($row = mysqli_fetch_array($selectResult)){
			//if no imdbID then ignore.
			if(IsEmpty($row['imdbID'])){
				continue;
			}
			//ob_start();

			$id = $row['imdbID'];
			$url = "http://api.myapifilms.com/imdb/idIMDB?idIMDB=".$id."&token=870c3596-fa05-4ced-82cf-a76d58be8a5a&format=json&language=en-us&aka=0&business=0&seasons=0&seasonYear=0&technical=0&trailer=0&movieTrivia=0&awards=0&moviePhotos=0&movieVideos=0&actors=0&biography=0&uniqueName=0&filmography=0&bornAndDead=0&starSign=0&actorActress=0&actorTrivia=0&similarMovies=0";
			$json = file_get_contents($url);
			$data = json_decode($json,true); //true for array format
			//print_r to see the json in array for so you know how to parse

			if( isset($data['data']['movies'][0]['rating'])){
				$rating = str_replace(",", ".", $data['data']['movies'][0]['rating']);
				$votes = preg_replace('/[^\d]+/i', '', $data['data']['movies'][0]['votes']);
			} else {
				continue;
			}
			


			$updateQuery = "UPDATE `imdb` SET imdbRating = '$rating', imdbVotes = '$votes' WHERE imdbID = '$id'";
			mysqli_query($conn, $updateQuery) or die(mysqli_error($conn));



			//format (just split by / and :)x
			//date:rating(imdb):votes,date:rating(imdb):votes, date:rating(imdb):votes, ..
			$newFileName = '../ratings/'.$id.".php";
			$appendContent = $updateDate.":".$rating.":".$votes."/";

			//if file doesnt exist
			/*if (!file_exists($newFileName)) {
			    $headings = "date,rating,votes\n";
			    file_put_contents($newFileName,$headings,  FILE_APPEND);
			}*/
			/*
			date,close,open
			1-May-12,58.13,3.41
			30-Apr-12,53.98,4.55
			27-Apr-12,67.00,6.78

			*/
			//$appendContent = $updateDate.",". $rating.",". $votes."\n";

			//If filename does not exist, the file is created. Otherwise, the existing file is overwritten, unless the FILE_APPEND flag is set.
			if(file_put_contents($newFileName,$appendContent,  FILE_APPEND) !=false){
			    echo "File created (".basename($newFileName).")";
			}else{
			    echo "Cannot create file (".basename($newFileName).")";
			}

			//
			//echo ob_get_contents();
			//ob_end_flush();
		}
		mysqli_close($conn);

	}
	
?>
		

