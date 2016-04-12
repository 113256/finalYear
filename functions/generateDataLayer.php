<?php

//build datalayer
/*
//single
dataLayer = [
				{
		            'movieId': 'Inside-Out',
		            'movieName': 'Inside Out',
		            'rating': '89'
       			 }
        	];

//multiple
dataLayer = [{
            'products': [
                    {'productSku': 'pbz00123', 'productName': 'The Original Rider Waite Tarot cards', 'productPrice': '9.99' },
                    {'productSku': 'pbz00124', 'productName': 'Aleicester Crowley Thoth Tarot', 'productPrice': '12.99' },
                    {'productSku': ...},
                    {'productSku': ...},
                    ...
            ]
        }];
*/

//$dataLayer = generateDataLayer($chosenResult, $p, $view, $genre, $movie, $sentSort, $ratingSort, $searchName)
/*
@param chosenResult - the result set
@param p - metric (rating or sentiment)
@param view- grid view or list view
@param genre
@param category - recent / theatre/ all
@param sentSort- positive or negative
@param ratingSort- ascending or descending
@param searchName- any search term user typed

@return the dataLayer string for google tag manager (GTM)
*/
function generateDataLayer($result, $p, $view, $genre, $category, $sort, $searchName){
	require('includes/connect.php');
	$dataLayerString = "[{'page':'homePage',";

	//movie
	$movieString = "'movies':[";
	while($row = mysqli_fetch_array($result)){
		$movieId = mysqli_real_escape_string($conn,$row['movieId']);
		$movieName = mysqli_real_escape_string($conn,$row['name']);

		if($p=="rating"){
			$averageRatingQuery = "SELECT average FROM `averagerating` WHERE movieId = '".$movieId."'";
			$averageRatingResult = mysqli_query($conn, $averageRatingQuery);
			$averageRatingRow = mysqli_fetch_array($averageRatingResult);

			if (!$averageRatingRow) {
			    printf("Error: %s\n", mysqli_error($conn));
			    //exit();
			}

			$average = $averageRatingRow['average'];

			$movieString.="{ 'movieId':'$movieId', 'movieName':'$movieName', 'averageRating':'$average' },";
		} else if ($p=="sentiment"){
			$sentCount="";
			if($sentSort=="pos"){
				$sentCount=$row['positive'];
				$sentType = "positive";
			} else {
				$sentCount = $row['negative'];
				$sentType = "negative";
			}

			$movieString.="{ 'movieId':'$movieId', 'movieName':'$movieName', '$sentType':'$sentCount' },";
		}
		
	}
	$movieString = rtrim($movieString, ",");
	$movieString.="]";
	$dataLayerString.=$movieString;

	//metric (rating or sentiment)
	$pString = ", 'metric': '$p'";
	$dataLayerString.=$pString;


	//view
	$viewString= ", 'view': '$view'";
	$dataLayerString.=$viewString;


	//genre
	$genreString= ", 'genre': '$genre'";
	$dataLayerString.=$genreString;

	//all/theatre/recent
	$categoryString=", 'category': '$category'";
	$dataLayerString.=$categoryString;

	//sort
	$sortString=", 'sort': '$sort'";
	$dataLayerString.=$sortString;

	//search
	if(!empty($searchName)){
		$searchString=", 'searchValue': '$searchName'";
		$dataLayerString.=$searchString;
	}
	
	
	$dataLayerString .= "}]";

	//echo "datalayer".$dataLayerString;
	return $dataLayerString;

}




function generateDataLayerShow($result, $view, $genre, $searchName,$day){
	require('includes/connect.php');
	$dataLayerString = "[{'page':'showsList',";

	//movie
	$showString = "'shows':[";
	while($row = mysqli_fetch_array($result)){

		$showName = $row['showName'];
		$season = $row['season'];
		$number = $row['number'];

		$showString.="{ 'showName':'$showName', 'season':'$season', 'number':'$number' },";
		
		
	}
	$showString = rtrim($showString, ",");
	$showString.="]";
	$dataLayerString.=$showString;

	//view
	$viewString= ", 'view': '$view'";
	$dataLayerString.=$viewString;

	//genre
	$genreString= ", 'genre': '$genre'";
	$dataLayerString.=$genreString;

	//search
	if(!empty($searchName)){
		$searchString=", 'searchValue': '$searchName'";
		$dataLayerString.=$searchString;
	}

	//day
	if(!empty($day)){
		$dayString=", 'daysAgo': '$day'";
		$dataLayerString.=$dayString;
	}


	$dataLayerString .= "}]";

	//echo "datalayer".$dataLayerString;
	return $dataLayerString;

}




//for specific movie
function generateDataLayerMovie($row){
	require('includes/connect.php');
	//For each different object, think about what the key data points are that are interesting. For example, a video on Youtube will have an id, a name, an author / producer etc.

	//name
	$name = mysqli_real_escape_string($conn,$row['name']);

	//movieInfo fields
	$movieId = mysqli_real_escape_string($conn,$row['movieId']);
	$rated = $row['rated'];
	$runtime = $row['runtime'];
	$genre = $row['genre'];
	$director = $row['director'];
	$actors = $row['actors'];
	//dont need plot
	$language = $row['language'];
	$country = $row['country'];
	$awards = $row['awards'];
	//dont need poster
	$boxOffice = $row['boxOffice'];

	//imdb fields
	$metaCriticScore = $row['metaCriticScore'];
	$imdbRating = $row['imdbRating'];
	$imdbVotes = $row['imdbVotes'];
	$imdbID = $row['boxOffice'];

	//rottentomatoes
	$tomatoMeter = $row['tomatoMeter'];
	$tomatoImage = $row['tomatoImage'];
	$tomatoRating = $row['tomatoRating'];
	$tomatoReviews = $row['tomatoReviews'];
	$tomatoFresh = $row['tomatoFresh'];
	$tomatoRotten = $row['tomatoRotten'];
	$tomatoUserMeter = $row['tomatoUserMeter'];
	$tomatoUserRating = $row['tomatoUserRating'];
	$tomatoUserReviews = $row['tomatoUserReviews'];

	//average rating
	$average = $row['average'];

	$dataLayerString = "[{";
	//start append

	$dataLayerString .= "'page':'movieInfo'";
	$dataLayerString .= ", 'infoCategory': 'socialMedia'";
	$dataLayerString .= ", 'movieName': '$name'";
	$dataLayerString .= ", 'movieId': '$movieId'";
	$dataLayerString .= ", 'rated': '$rated'";
	$dataLayerString .= ", 'runtime': '$runtime'";
	$dataLayerString .= ", 'genre': '$genre'";
	$dataLayerString .= ", 'director': '$director'";
	$dataLayerString .= ", 'actors': '$actors'";
	$dataLayerString .= ", 'language': '$language'";
	$dataLayerString .= ", 'country': '$country'";
	$dataLayerString .= ", 'awards': '$awards'";
	$dataLayerString .= ", 'boxOffice': '$boxOffice'";
	$dataLayerString .= ", 'metaCriticScore': '$metaCriticScore'";
	$dataLayerString .= ", 'imdbRating': '$imdbRating'";
	$dataLayerString .= ", 'imdbID': '$imdbID'";
	$dataLayerString .= ", 'tomatoMeter': '$tomatoMeter'";
	$dataLayerString .= ", 'tomatoImage': '$tomatoImage'";
	$dataLayerString .= ", 'tomatoRating': '$tomatoRating'";
	$dataLayerString .= ", 'tomatoReviews': '$tomatoReviews'";
	$dataLayerString .= ", 'tomatoFresh': '$tomatoFresh'";
	$dataLayerString .= ", 'tomatoRotten': '$tomatoRotten'";
	$dataLayerString .= ", 'tomatoUserMeter': '$tomatoUserMeter'";
	$dataLayerString .= ", 'tomatoUserRating': '$tomatoUserRating'";
	$dataLayerString .= ", 'tomatoUserReviews': '$tomatoUserReviews'";
	$dataLayerString .= ", 'averageRating': '$average'";

	//end append
	$dataLayerString .= "}]";


	return $dataLayerString;
}


?>