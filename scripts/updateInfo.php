<?php 
	function updateMovie()
	{	set_time_limit(7200);
		require("../includes/connect.php");
		require("../includes/string.php");


		$selectQuery = "SELECT * FROM `imdb`";
		$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));

		while ($row = mysqli_fetch_array($selectResult)){
			$movieId = $row['movieId'];
			//$movieId = "Dragonheart+3:+The+Sorcerer's+Curse";
			$imdbID = $row['imdbID'];
			//$imdbID = "tt2974918";
			//$movieId = "Alvin+and+the+Chipmunks:+The+Road+Chip";

			echo "updating id  :".$imdbID." ";


			if(IsEmpty($imdbID) || IsEmpty($movieId)){
				continue;
			}

			$movieInfoQuery = "SELECT * FROM `movieinfo` WHERE movieId =  '".mysql_real_escape_string($movieId)."'";//escape as id may have apostrophe
			$movieInfoResult = mysqli_query($conn, $movieInfoQuery) or die(mysqli_error($conn));
			$movieInfoRow = mysqli_fetch_array($movieInfoResult);

			//if(IsEmpty($movieInfoRow['movieId'])){

			//	continue;
			//}


			echo "getting omdb for  ".$movieId.", ";
			//@ to suppress warnings and notices...
	  	/*OMDB API -DOESNT EXIST FOR ALL MOVIES*/
	  		$omdbXml = @simplexml_load_file("http://www.omdbapi.com/?t=".urlencode($movieId)."&plot=full&r=xml&tomatoes=true");
	  		echo "omdb is  http://www.omdbapi.com/?t=".urlencode($movieId)."&plot=full&r=xml&tomatoes=true  , ";

	  	

			$poster = "";
		  	$metascore = "";
		  	$imdbRating = "";
		  	$imdbVotes = "";
		  	//$imdbID = "";
		  	$runtime = "";
		  	$plot= "";
		  	$releaseDate = "";
		  	$rated = "";
		  	$genre = "";
			$director = "";
		  	$writer = "";
		  	$language = "";
		  	$country = "";
		  	$actors = "";
		  	$website = "";
		  	$boxOffice = "";
		  	$awards = "";
		  	$tomatoMeter ="";
		  	$tomatoImage = "";
		  	$tomatoRating = "";
		  	$tomatoReviews="";
		  	$tomatoFresh="";
		  	$tomatoRotten="";
		  	$tomatoUserMeter="";
		  	$tomatoUserRating="";
		  	$tomatoUserReviews="";	
		  	$imdbLink = "";
		  
		  	//echo $omdbXml->attributes()->response;
		  	if (@$omdbXml->root['response']=="False") {
		  		echo "movie not found in omdb";
			  // throw new Exception("Cannot load xml source.\n");
		  		$poster = "";
		  		$metascore = "";
			  	$imdbRating = "";
			  	$imdbVotes = "";
			  	//$imdbID = "";
			  	$runtime = "";
			  	$plot= "";
			  	$releaseDate = "";
			  	$rated = "";
			  	$genre = "";
			  	$rated = "";
			  	$genre = "";
		  		$director = "";
		      	$writer = "";
		      	$language = "";
		      	$country = "";
		      	$actors = "";
		      	$website = "";
		      	$boxOffice = "";
		      	$awards = "";
		      	$tomatoMeter ="";
		      	$tomatoImage = "";
		      	$tomatoRating = "";
		      	$tomatoReviews="";
		      	$tomatoFresh="";
		      	$tomatoRotten="";
		      	$tomatoUserMeter="";
		      	$tomatoUserRating="";
		      	$tomatoUserReviews="";
		      	$imdbLink = "";
			} else {
				
				//$genre = $omdbXml->movie['genre'];
		      	$director = mysql_real_escape_string(htmlentities(@$omdbXml->movie['director']));
		      	//$releaseDate = $omdbXml->movie['released'];
		      	$writer = mysql_real_escape_string(htmlentities(@$omdbXml->movie['writer']));
		      	$language = @$omdbXml->movie['language'];
		      	$country = @$omdbXml->movie['country'];
		      	$actors = mysql_real_escape_string(htmlentities(@$omdbXml->movie['actors']));
		      	$website = @$omdbXml->movie['Website'];
		      	$boxOffice = @$omdbXml->movie['boxOffice'];
		      	$awards = @$omdbXml->movie['awards'];

		      	//omdb tomato
		      	$tomatoMeter = @$omdbXml->movie['tomatoMeter'];
		      	$tomatoImage = @$omdbXml->movie['tomatoImage'];
		      	$tomatoRating = @$omdbXml->movie['tomatoRating'];
		      	$tomatoReviews=@$omdbXml->movie['tomatoReviews'];
		      	$tomatoFresh=@$omdbXml->movie['tomatoFresh'];
		      	$tomatoRotten=@$omdbXml->movie['tomatoRotten'];
		      	$tomatoUserMeter=@$omdbXml->movie['tomatoUserMeter'];
		      	$tomatoUserRating=@$omdbXml->movie['tomatoUserRating'];
		      	$tomatoUserReviews=@$omdbXml->movie['tomatoUserReviews'];

		      	$metascore = @$omdbXml->movie['metascore'];
			  	$imdbRating = @$omdbXml->movie['imdbRating'];
			  	$imdbVotes = @$omdbXml->movie['imdbVotes'];
			  	//$imdbID = @$omdbXml->movie['imdbID'];
			  	$runtime = @$omdbXml->movie['runtime'];
			  	$plot= mysql_real_escape_string(@$omdbXml->movie['plot']);
			  	$releaseDate = @$omdbXml->movie['releaseDate'];
			  	$rated = @$omdbXml->movie['rated'];
			  	$genre = @$omdbXml->movie['genre'];
			  	$poster = @$omdbXml->movie['poster'];
			  	
			  	$imdbLink = "";
			}


		  	$myApiFilmsUrl = "http://api.myapifilms.com/imdb/idIMDB?idIMDB=".$imdbID."&token=870c3596-fa05-4ced-82cf-a76d58be8a5a&format=json&language=en-us&aka=0&business=0&seasons=0&seasonYear=0&technical=0&trailer=0&movieTrivia=0&awards=0&moviePhotos=0&movieVideos=0&actors=0&biography=0&uniqueName=0&filmography=0&bornAndDead=0&starSign=0&actorActress=0&actorTrivia=0&similarMovies=0";

		  	//echo $myApiFilmsUrl."<br>";

			$json = file_get_contents($myApiFilmsUrl);
			$data = json_decode($json,true); //true for array format
			//print_r($data);
			if(IsEmpty($plot)){
				$plot = mysql_real_escape_string($data['data']['movies'][0]['plot']);
			} 
			$imdbLink =  $data['data']['movies'][0]['urlIMDB'];
			
			if(IsEmpty($poster) ){
				$poster = $data['data']['movies'][0]['urlPoster'];
				//$poster = 'http://ia.media-imdb.com/images/M/MV5BMTAzNjU4MzYwNDdeQTJeQWpwZ15BbWU4MDg3NTEzMjcx._V1_SY317_CR0,0,214,317_AL_.jpg';
			} 
			
			//echo "poster is".IsEmpty($poster);
			if(!IsEmpty($poster)){
				//download
				if(IsEmpty($movieInfoRow['poster'])){
					echo "download poster for update<br>";
					downloadPoster($movieId, $poster);
				}
				
			} 
			//$plot = "plesase.";
			

			$subtitleLink = 'http://www.opensubtitles.org/en/search2/sublanguageid-all/moviename-'.$movieId;

			//cant find
			$tomatoLink = "";
			$tmdbLink="";
			$youtubeLink = "";

			echo " --inserting...-";

			$movieInfoInsertQuery = "UPDATE `movieinfo` SET 
				rated = IF(LENGTH(rated)=0, '$rated', rated),
				releaseDate = IF(LENGTH(releaseDate)=0, '$releaseDate', releaseDate),
				runtime = IF(LENGTH(runtime)=0, '$runtime', runtime),
				genre = IF(LENGTH(genre)=0, '$genre', genre),
				director = IF(LENGTH(director)=0, '$director', director),
				writer = IF(LENGTH(writer)=0, '$writer', writer),
				actors = IF(LENGTH(actors)=0, '$actors', actors),
				plot = IF(LENGTH(plot)=0, '$plot', plot),
				language = IF(LENGTH(language)=0, '$language', language),
				country = IF(LENGTH(country)=0, '$country', country),
				awards = IF(LENGTH(awards)=0, '$awards', awards),
				poster = IF(LENGTH(poster)=0, '$poster', poster),
				boxOffice = IF(LENGTH(boxOffice)=0, '$boxOffice', boxOffice),
				Website = IF(LENGTH(Website)=0, '$website', Website)
				WHERE movieId = '". mysql_real_escape_string($movieId). "'";

				echo $movieInfoInsertQuery;

			/*$movieInfoInsertQuery = "UPDATE `movieinfo` SET 
				`rated` = IF(`rated` IS NULL, '$rated', `rated`),
				`releaseDate` = '$releaseDate',
				`runtime` = '$runtime', 
				`genre` = '$genre', 
				`director` = '$director', 
				`writer` = '$writer', 
				`actors` = '$actors', 
				`plot` = '$plot', 
				`language` = '$language', 
				`country` = '$country', 
				`awards` = '$awards', 
				`poster` = '$poster', 
				`boxOffice` = '$boxOffice', 
				`Website` = '$website'
				WHERE `movieId = '$movieId'";*/
				

			$tomatoInsertQuery = "UPDATE `tomato` SET 
				tomatoMeter = '$tomatoMeter',
				tomatoImage = '$tomatoImage',
				tomatoRating = '$tomatoRating', 
				tomatoReviews = '$tomatoReviews', 
				tomatoFresh = '$tomatoFresh', 
				tomatoRotten = '$tomatoRotten', 
				tomatoUserMeter = '$tomatoUserMeter', 
				tomatoUserRating = '$tomatoUserRating', 
				tomatoUserReviews = '$tomatoUserReviews' 
				WHERE movieId = '". mysql_real_escape_string($movieId). "'";

			$linksInsertQuery = "UPDATE `links` SET 
				imdbLink = '$imdbLink'
				WHERE movieId = '". mysql_real_escape_string($movieId). "'";

			$imdbInsertQuery = "UPDATE `imdb` SET 
				metaCriticScore = '$metascore'
				WHERE movieId = '". mysql_real_escape_string($movieId). "'";

			if(IsEmpty($movieInfoRow['poster'])){
					$posterQuery = "UPDATE `movieinfo` SET 
						poster = '$poster'
						WHERE movieId = '". mysql_real_escape_string($movieId). "'";

					 mysqli_query($conn, $posterQuery)or die(mysqli_error($conn));	
				}

			  if (!mysqli_query($conn,$movieInfoInsertQuery)) {
				  die('Error: ' . mysqli_error($conn));
				}
				echo "movieinfo updated,  ";

			 if (!mysqli_query($conn,$tomatoInsertQuery)) {
				  die('Error: ' . mysqli_error($conn));
				}
				echo "tomato updated,  ";

			 if (!mysqli_query($conn,$linksInsertQuery)) {
				  die('Error: ' . mysqli_error($conn));
				}
				echo "links updated,  ";
			 if (!mysqli_query($conn,$imdbInsertQuery)) {
				  die('Error: ' . mysqli_error($conn));
				}
				echo "imdb updated,  ";

				echo "<br>";
			  /*mysqli_query($conn, $movieInfoInsertQuery) or die(mysqli_error($conn));

	          mysqli_query($conn, $imdbInsertQuery)or die(mysqli_error($conn));
	          mysqli_query($conn, $linksInsertQuery)or die(mysqli_error($conn));
	          mysqli_query($conn, $tomatoInsertQuery)or die(mysqli_error($conn));*/

	          
	          
		




		}





		
}
updateMovie();

?>