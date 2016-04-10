<?php 

$formattedRecentDate="";



function getRecent(){



	require("../includes/connect.php");
	//require("../includes/string.php");


	

	/*
		find title of each recently released movie then put into omdb
	*/
	//xml
	/*<RESPONSE_DATA>
	    <FILE_INFORMATION Order_Number="19222835">

	    response_data->file_information['Order_Number']
	*/
	$xml = simplexml_load_file("http://api.myapifilms.com/imdb/inTheaters?token=870c3596-fa05-4ced-82cf-a76d58be8a5a&format=xml&language=en-us");





	//the "recently released" date
	$date = htmlentities($xml->data->movies->date);
	$trim = trim(str_replace(" ", "", $date));
	$trim = str_replace("&nbsp;", "", $trim);

	//$rest = substr("abcdef", -1);    // returns "f"
	$day = substr($trim, -2);
	$month =  substr($trim, 0,3);
	$year = date("Y");
	//echo $date;
	global $formattedRecentDate;
	$formattedRecentDate = $day. " ". $month. " ". $year;
	//echo $formattedRecentDate;

	//store formatted date for use in recent.php so you dont have to keep calling api
	$newFileName = '../includes/recentDate.txt';
	$appendContent = $formattedRecentDate;
	//If filename does not exist, the file is created. Otherwise, the existing file is overwritten, unless the FILE_APPEND flag is set.
	if(file_put_contents($newFileName,$appendContent) !=false){
	    echo "File created (".basename($newFileName).")";
	}else{
	    echo "Cannot create file (".basename($newFileName).")";
	}




	$zeroOrOne;

	//for($zeroOrOne=0; $zeroOrOne <=1; $zeroOrOne++){
	for($zeroOrOne=0; $zeroOrOne <=0; $zeroOrOne++){
		//use this to skip first row (blank)
		$b = false;
		//movies[0] is the array for recently released, [1] is in theatres now
		foreach ($xml->data->movies[$zeroOrOne] as $movie){ 


				
				
				if(!$b) {
			       $b = true;
			       continue;
			    }


				//insert to omdb if not already found

				//rating is imdb rating

				$title = htmlentities ($movie->title);	
				echo $title."<br>";
				if(empty($title)){
					continue;
				}
				//echo $title .'<br>';


				$selectQuery = "SELECT movieId FROM moviename";
				$selectResult = mysqli_query($conn, $selectQuery);
		        $exists = 0;
		        while($row = mysqli_fetch_array($selectResult)){
		        	 if (fuzzy_match($title, $row['movieId'])){
		        	 	$exists = 1;
		        	 	break;
		        	 }
		        }
		         

		          if ($exists == 1){
			          	if($zeroOrOne == 1){
			          		$movieId = str_replace(" ", "+", $title);
			          		$theatreInsertQurey = "INSERT INTO `intheatres` (`movieId`) VALUES ('$movieId')";
			          		 mysqli_query($conn, $theatreInsertQurey) or die(mysqli_error($conn));
			          	}
		               continue ;
		          }
		                      
		          else{
		          	//print("not found");
		          	//insert

		          	/*MYAPIFILMS*/

		          	//format is 20151113
		          	if($zeroOrOne == 0){
		          		$releaseDate = $formattedRecentDate;
		          	} else if ($zeroOrOne == 1){
		          		//format is 20151113
			            $releaseDate = $movie->releaseDate;
			            $day = substr($releaseDate, -2);
			            $monthNum = substr($releaseDate, 5,6);
			            $monthName = date("F", mktime(0, 0, 0, $monthNum, 15));
			            $month = substr($monthName, 0,3);

			            $year = substr($releaseDate, 0, 4);
			            $releaseDate = $day." ".$month." ".$year;
		          	}
		          	
		          

		          	//movieId
		          	$movieId = mysqli_real_escape_string($conn, str_replace(" ", "+", $title));
		          	//rated
		          	$rated = htmlentities ($movie->rated);
		          	//runtime
		          	$runtime = htmlentities ($movie->runtime);			
		          	//plot
		          	 $plot =  mysqli_real_escape_string($conn, htmlentities($movie->plot));  
		          	//poster
		          	$poster = $movie->urlPoster;
		          	echo $poster."<br>";
		          	//download
		          	downloadPoster($movieId, $poster);
		          	//imdblink
		          	$imdbLink = $movie->urlIMDB;
		          	$metascore = substr($movie->metascore, 0, -4);
		          	$imdbRating =$movie->rating;
		         	$imdbVotes = $movie->votes;
		         	$imdbID = $movie->idIMDB;
		         	
		         	


		         	try {
				        //genre
			         	$genreList = "";
			         	foreach ((array)$movie->genres->genre as $genre){ 
			         		$temp = (string)$genre;
			         		$genreList = $genreList. $temp." ";
			         	}
			         	$genreList = trim($genreList);
			         	$genre = $genreList;
				    } catch (Exception $e ) {
				       //echo "Failed to connect to MySQL: " . mysqli_connect_error();
				    }
		         	
		         	
		     		  	
		         	if(IsEmpty($movieId)){
		         		continue;
		         	}


		        		//@ to suppress warnings and notices...
			          	/*OMDB API -DOESNT EXIST FOR ALL MOVIES*/
			          	$omdbXml = @simplexml_load_file("http://www.omdbapi.com/?t=".$movieId."&y=".$year."&plot=full&r=xml&tomatoes=true");
			        
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

			          	if (@$omdbXml->root['response']=="False") {
			          		
						  // throw new Exception("Cannot load xml source.\n");
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
						} else {
							//$genre = $omdbXml->movie['genre'];
				          	$director = @$omdbXml->movie['director'];
				          	//$releaseDate = $omdbXml->movie['released'];
				          	$writer = @$omdbXml->movie['writer'];
				          	$language = @$omdbXml->movie['language'];
				          	$country = @$omdbXml->movie['country'];
				          	$actors = @$omdbXml->movie['actors'];
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

						}


			          	
			        $myApiFilmsUrl = "http://api.myapifilms.com/imdb/idIMDB?idIMDB=".$imdbID."&token=870c3596-fa05-4ced-82cf-a76d58be8a5a&format=json&language=en-us&aka=0&business=0&seasons=0&seasonYear=0&technical=0&trailer=0&movieTrivia=0&awards=0&moviePhotos=0&movieVideos=0&actors=0&biography=0&uniqueName=0&filmography=0&bornAndDead=0&starSign=0&actorActress=0&actorTrivia=0&similarMovies=0";
					$json = file_get_contents($myApiFilmsUrl);
					$data = json_decode($json,true); //true for array format
					if(IsEmpty($plot)){
						$plot = mysqli_real_escape_string($conn, $data['data']['movies'][0]['plot']);
					} 
					$imdbLink =  $data['data']['movies'][0]['urlIMDB'];
					
					if(IsEmpty($poster)){
						$poster = $data['data']['movies'][0]['urlPoster'];
					} 


					if(!IsEmpty($poster)){
						//download
						downloadPoster($movieId, $poster);
					} 	
			        

		          	$subtitleLink = 'http://www.opensubtitles.org/en/search2/sublanguageid-all/moviename-'.$movieId;

		          	//cant find
		          	$tomatoLink = "";
		          	$tmdbLink="";
		          	$youtubeLink = "";



		          	$movieInfoInsertQuery = "INSERT INTO `movieinfo` (`movieId`, `rated`, `releaseDate`, `runtime`, `genre`, `director`, `writer`, `actors`, `plot`, `language`, `country`, `awards`, `poster`, `boxOffice`, `Website`, `Screenshots`) VALUES ('$movieId', '$rated', '$releaseDate', '$runtime', '$genre', '$director', '$writer', '$actors', '$plot', '$language', '$country', '$awards', '$poster', '$boxOffice', '$website', '$boxOffice')";

		          	$movieNameInsertQuery = "INSERT INTO `moviename` (`movieId`, `name`) VALUES ('$movieId', '$title')";

		          	$imdbInsertQuery=  "INSERT INTO `imdb` (`movieId`, `metaCriticScore`, `imdbRating`, `imdbVotes`, `imdbID`) VALUES ('$movieId', '$metascore', '$imdbRating', '$imdbVotes', '$imdbID')";

		          	$linksInsertQuery = "INSERT INTO `links` (`movieId`, `youtubeLink`, `imdbLink`, `tomatoLink`, `subtitleLink`) VALUES ('$movieId', '$youtubeLink', '$imdbLink', '$tomatoLink','$subtitleLink')";

		          	$tomatoInsertQuery = "INSERT INTO `tomato` (`movieId`,`tomatoMeter`, `tomatoImage`, `tomatoRating`, `tomatoReviews`, `tomatoFresh`, `tomatoRotten`, `tomatoUserMeter`,`tomatoUserRating`, `tomatoUserReviews`) VALUES ('$movieId', '$tomatoMeter', '$tomatoImage', '$tomatoRating', '$tomatoReviews', '$tomatoFresh', '$tomatoRotten','$tomatoUserMeter', '$tomatoUserRating', '$tomatoUserReviews')";
					
		          	if($zeroOrOne == 1){
		          		$theatreInsertQurey = "INSERT INTO `intheatres` (`movieId`) VALUES ('$movieId')";
		          		 mysqli_query($conn, $theatreInsertQurey) or die(mysqli_error($conn));
		          	}

					  mysqli_query($conn, $movieInfoInsertQuery) or die(mysqli_error($conn));
		              mysqli_query($conn, $movieNameInsertQuery)or die(mysqli_error($conn));
		              mysqli_query($conn, $imdbInsertQuery)or die(mysqli_error($conn));
		              mysqli_query($conn, $linksInsertQuery)or die(mysqli_error($conn));
		              mysqli_query($conn, $tomatoInsertQuery)or die(mysqli_error($conn));
		          }
		               


				}				
				 
			}
	}
	 


?>