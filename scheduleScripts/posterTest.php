<?php

require('../includes/connect.php');
require('../includes/string.php');


	function downloadAllPosters(){

		require("../includes/connect.php");
		set_time_limit(3600);

		$selectQuery = "SELECT * FROM movieinfo";
		$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

		while ($row = mysqli_fetch_array($selectResult)){
			$id = $row['movieId'];
			$filename = normalize($id);
			$file = '../poster/'.$filename.'.jpg';

			//echo $filename."<br>";
			$posterUrl = $row['poster'];

			if(!empty($posterUrl)){
				echo $file."made <br>";
				if(!file_exists($file)){
					copy($posterUrl, $file);
				} else {
					echo "already exists";
				}
				
			}else{
				echo "EMPTY <br>";
			}
			

		}
		}
		
		downloadAllPosters();
		//echo "http://$_SERVER[HTTP_HOST]$";

?>