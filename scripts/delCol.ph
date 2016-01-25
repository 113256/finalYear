<?php 
	function updateMovie()
	{	set_time_limit(7200);
		require("../includes/connect.php");
		require("../includes/string.php");


		$movieInfoQuery = "SELECT * FROM `movieinfo`";//escape as id may have apostrophe
		$movieInfoResult = mysqli_query($conn, $movieInfoQuery) or die(mysqli_error($conn));
	

		while ($row = mysqli_fetch_array($movieInfoResult)){
			
				
			$linksInsertQuery = "UPDATE `links` SET 
				plot = ''
				WHERE plot = 'plesase.'";


			 
			 if (!mysqli_query($conn,$linksInsertQuery)) {
				  die('Error: ' . mysqli_error($conn));
				}
				echo "links updated,  ";
			
				echo "<br>";

		}





		
}
updateMovie();

?>