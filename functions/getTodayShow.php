<?php 


	function getShows($date){
		require("../includes/connect.php");

		//phpinfo();

		//$date = date(('Y-m-d'));

		$url = 'http://api.tvmaze.com/schedule?country=US&date='.$date;
		$json = file_get_contents($url);
		$data = json_decode($json,true);
		//print_r($data);

		foreach ($data as $show) {
			//episode info
			$episodeName = ($show['name']);

			$selectQuery = "SELECT episodeName FROM tvshow";
			$selectResult = mysqli_query($conn, $selectQuery) or die(mysqli_error($conn));
	        $exists = 0;

	        echo "row epn is". $row['episodeName']."<br>";
			echo " epn is ". $episodeName."<br>";

	        while($row = mysqli_fetch_array($selectResult)){
	        	 if (fuzzy_match($episodeName, $row['episodeName'])){
	        	 	$exists = 1;
	        	 	break;
	        	 }
	        }
	         

          if ($exists == 1){
          	echo "exists!";
               continue ;
          }
	                      
          else{
          	$unwantedChars = array(',', '!', '?', "'"); // create array with unwanted chars


          	echo "doesnt exist";
          	$season = "";
	    	$number = "";
	    	$airdate = "";
	    	$airtime = "";
	    	$airstamp = "";
	    	$runtime = "";
	    	$episodeSummary = "";
	    	$showName= "";
	    	$showType= "";
	    	$showLanguage= "";
	    	$showPremiered = "";
	    	$showAverageRating = "";
	    	$showGenre = "";
	    	$image = "";
	    	$showSummary =  "";

	    	$season = @$show['season'];
	    	$number = @$show['number'];
	    	$airdate = @$show['airdate'];
	    	$airtime = @$show['airtime'];
	    	$airstamp = @$show['airstamp'];
	    	$runtime = @$show['runtime'];
	    	$episodeSummary = @str_replace($unwantedChars,"",(($show['summary'])));

	    	//show info
	    	$showName=@str_replace($unwantedChars,"",(htmlentities($show['show']['name'])));
	    	$subtitleLink = "http://www.opensubtitles.org/en/search2/sublanguageid-eng/searchonlytvseries-on/moviename-".str_replace(" ", "+", $showName);
	    	$showType= @$show['show']['type'];
	    	$showLanguage= @$show['show']['language'];
	    	$showPremiered = @$show['show']['premiered'];
	    	$showAverageRating = @$show['show']['rating']['average'];
	    	//some genres are blank
	    	$showGenre = "";
	    	foreach(@$show['show']['genres'] as $genre)
	    	{
	    		$showGenre = $showGenre . " ". $genre;
	    	}
	    	//echo $showGenre.'<br>';
	    	$image = @$show['show']['image']['original'];
	    	$showSummary =  @str_replace($unwantedChars,"",(($show['show']['summary'])));

			
	    	 
 		 	//$hello = str_replace($unwantedChars, '', $hello); // remove them
	    	$episodeName = @str_replace($unwantedChars,"",(htmlentities($show['name'])));
	    	echo "newepname ". $episodeName;

	    	$showInsertQuery = "INSERT INTO `tvshow` (`episodeName`, `season`, `number`, `airdate`, `airtime`, `airstamp`, `runtime`, `episodeSummary`, 
	    		`showName`, `subtitleLink`, `showType`, `showLanguage`, `showPremiered`, `showAverageRating`, `showGenre`, `image`, `showSummary`) 
				VALUES ('$episodeName', '$season', '$number', '$airdate', '$airtime', '$airstamp', '$runtime', '$episodeSummary', 
	    		'$showName', '$subtitleLink', '$showType', '$showLanguage', '$showPremiered', '$showAverageRating', '$showGenre', '$image', '$showSummary')";
		    mysqli_query($conn, $showInsertQuery) or die(mysqli_error($conn));
	    	}

    	}
	}
?>