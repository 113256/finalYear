<?php 
	function newMovie($title)
	{	
		//require("connect.php");
		//require("string.php");

		

		$movieId = str_replace(" ", "+", $title);
		$movieId = mysqli_real_escape_string($conn, $movieId);//in case of apostrophes etc.
			//@ to suppress warnings and notices...
	  	/*OMDB API -DOESNT EXIST FOR ALL MOVIES*/
	  	$omdbXml = @simplexml_load_file("http://www.omdbapi.com/?t=".urlencode($movieId)."&plot=full&r=xml&tomatoes=true");

	  	$poster = "";
	  	$metascore = "";
	  	$imdbRating = "";
	  	$imdbVotes = "";
	  	$imdbID = "";
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
		  	$imdbID = "";
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
	      	$director = mysqli_real_escape_string($conn, htmlentities(@$omdbXml->movie['director']));
	      	//$releaseDate = $omdbXml->movie['released'];
	      	$writer = mysqli_real_escape_string($conn, htmlentities(@$omdbXml->movie['writer']));
	      	$language = @$omdbXml->movie['language'];
	      	$country = @$omdbXml->movie['country'];
	      	$actors = mysqli_real_escape_string($conn, htmlentities(@$omdbXml->movie['actors']));
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
		  	$imdbID = @$omdbXml->movie['imdbID'];
		  	$runtime = @$omdbXml->movie['runtime'];
		  	$plot= mysqli_real_escape_string($conn, @$omdbXml->movie['plot']);
		  	$releaseDate = @$omdbXml->movie['releaseDate'];
		  	$rated = @$omdbXml->movie['rated'];
		  	$genre = @$omdbXml->movie['genre'];
		  	$poster = @$omdbXml->movie['poster'];
		  	
		  	$imdbLink = "";
		}

		if(!IsEmpty($imdbID)){
			echo "getting myapi films ";

		  	$myApiFilmsUrl = "http://api.myapifilms.com/imdb/idIMDB?idIMDB=".$imdbID."&token=870c3596-fa05-4ced-82cf-a76d58be8a5a&format=json&language=en-us&aka=0&business=0&seasons=0&seasonYear=0&technical=0&trailer=0&movieTrivia=0&awards=0&moviePhotos=0&movieVideos=0&actors=0&biography=0&uniqueName=0&filmography=0&bornAndDead=0&starSign=0&actorActress=0&actorTrivia=0&similarMovies=0";
			$json = file_get_contents($myApiFilmsUrl);
			$data = json_decode($json,true); //true for array format
			if(IsEmpty($plot)){
				$plot = mysqli_real_escape_string($conn, $data['data']['movies'][0]['plot']);
			} 
			$imdbLink =  $data['data']['movies'][0]['urlIMDB'];
			
			if(IsEmpty($poster)){
				$poster = $data['data']['movies'][0]['urlPoster'];
				//$poster = 'http://ia.media-imdb.com/images/M/MV5BMTAzNjU4MzYwNDdeQTJeQWpwZ15BbWU4MDg3NTEzMjcx._V1_SY317_CR0,0,214,317_AL_.jpg';
			} 

			echo "poster is".IsEmpty($poster);
			if(!IsEmpty($poster)){
				//download
				echo "download poster";
				downloadPoster($movieId, $poster);
			} 
		}
		

		$subtitleLink = 'http://www.opensubtitles.org/en/search2/sublanguageid-all/moviename-'.$movieId;

		//cant find
		$tomatoLink = "";
		$tmdbLink="";
		$youtubeLink = "";

		if(IsEmpty($movieId)){
			return;
		}

		$title = mysqli_real_escape_string($conn, $title);

		$movieInfoInsertQuery = "INSERT INTO `movieinfo` (`movieId`, `rated`, `releaseDate`, `runtime`, `genre`, `director`, `writer`, `actors`, `plot`, `language`, `country`, `awards`, `poster`, `boxOffice`, `Website`, `Screenshots`) VALUES ('$movieId', '$rated', '$releaseDate', '$runtime', '$genre', '$director', '$writer', '$actors', '$plot', '$language', '$country', '$awards', '$poster', '$boxOffice', '$website', '$boxOffice')";

		$movieNameInsertQuery = "INSERT INTO `moviename` (`movieId`, `name`) VALUES ('$movieId', '$title')";

		$imdbInsertQuery=  "INSERT INTO `imdb` (`movieId`, `metaCriticScore`, `imdbRating`, `imdbVotes`, `imdbID`) VALUES ('$movieId', '$metascore', '$imdbRating', '$imdbVotes', '$imdbID')";

		$linksInsertQuery = "INSERT INTO `links` (`movieId`, `youtubeLink`, `imdbLink`, `tomatoLink`, `subtitleLink`) VALUES ('$movieId', '$youtubeLink', '$imdbLink', '$tomatoLink','$subtitleLink')";

		$tomatoInsertQuery = "INSERT INTO `tomato` (`movieId`,`tomatoMeter`, `tomatoImage`, `tomatoRating`, `tomatoReviews`, `tomatoFresh`, `tomatoRotten`, `tomatoUserMeter`,`tomatoUserRating`, `tomatoUserReviews`) VALUES ('$movieId', '$tomatoMeter', '$tomatoImage', '$tomatoRating', '$tomatoReviews', '$tomatoFresh', '$tomatoRotten','$tomatoUserMeter', '$tomatoUserRating', '$tomatoUserReviews')";

		 mysqli_query($conn, $movieInfoInsertQuery) or die(mysqli_error($conn));
		 echo "info d  ";
          mysqli_query($conn, $movieNameInsertQuery)or die(mysqli_error($conn)); echo "name d  ";
          mysqli_query($conn, $imdbInsertQuery)or die(mysqli_error($conn)); echo "imdb d  ";
          mysqli_query($conn, $linksInsertQuery)or die(mysqli_error($conn)); echo "links d  ";
          mysqli_query($conn, $tomatoInsertQuery)or die(mysqli_error($conn)); echo "tomato d <br>";
} 

?>