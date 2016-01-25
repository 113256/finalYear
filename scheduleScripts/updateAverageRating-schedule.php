<?php 


require('../includes/connect.php');
require('../includes/string.php');


$allRatingQuery = "SELECT imdbRating, metaCriticScore, i.movieId, t.tomatoRating, t.tomatoUserRating FROM `imdb` AS i 
INNER JOIN (
	SELECT tomatoRating, tomatoUserRating, t.movieId FROM `tomato` as t
	
) AS t on i.movieId = t.movieId ";

$allRatingResult = mysqli_query($conn, $allRatingQuery) or die(mysqli_error($conn)); 

while($row = mysqli_fetch_array($allRatingResult)){
	$movieId = $row['movieId'];
	$movieId = mysqli_real_escape_string($conn, $movieId);//in case of apostrophes etc.
	$average = calcAverageRating($row['metaCriticScore'], $row['imdbRating'], $row['tomatoRating'], $row['tomatoUserRating']);
	$insertQuery = "INSERT IGNORE INTO `averagerating` (`movieId`, `average`) VALUES ('$movieId', '$average')";
	mysqli_query($conn, $insertQuery) or die(mysqli_error($conn));
}

		 

?>