<head>

<title>
<?php 

$urlPage = $_SERVER['PHP_SELF'];
if(strpos($urlPage, "index")!=false){
	//home page
	echo "Clueue - Social media metrics for films, theatre releases and showtimes";
} else if(strpos($urlPage, "movieInfo")!=false){
	//movieinfo
	$id = $_GET['movieId'];
	$id = urldecode($id);
	echo "Clueue- Social media metrics for ".$id;
} else if(strpos($urlPage, "showInfo")!=false){
	//showinfo
	echo "Clueue- Social media metrics for ".$showName;
} else if(strpos($urlPage, "todayShows")!=false){
	//todayshows
	echo "Clueue- Social media metrics for Recent TV shows";
} else if(strpos($urlPage, "movieShowtimes")!=false){
	//showtimes
	echo "Clueue- Movie showtimes";
} else if(strpos($urlPage, "toptrending2015")!=false){
	//toptrending2015
	echo "Clueue- Top searched films 2015";
}

?>
</title>

<meta name = "viewport" content = "width=device-width, initial-scale=1.0" >

<meta name="description" content="
<?php 


if(strpos($urlPage, "index")!=false){
	//home page
	echo "Clueue displays social media metrics for the latest films and TV shows and the ratings/twitter sentiment charts for each film.";
} else if(strpos($urlPage, "movieInfo")!=false){
	//movieinfo
	//echo $movieInfoRow['plot'];
	echo "View Social media metrics, trends, info and download subtitles for ". $movieInfoRow['name'];
} else if(strpos($urlPage, "showInfo")!=false){
	//showinfo
	echo $showSummary;
} else if(strpos($urlPage, "todayShows")!=false){
	//todayshows
	echo "Search for TV shows released today and up to two days back";
} else if(strpos($urlPage, "movieShowtimes")!=false){
	//showtimes
	echo "Search for movie showtimes";
} else if(strpos($urlPage, "toptrending2015")!=false){
	//toptrending2015
	echo "Top 10 searched films (Google) in 2015 along with the relative search interest ";
}


?>
">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link href = "css/bootstrap.css" rel = "stylesheet">
<!--custom styles -->
<link href = "css/styles.css" rel = "stylesheet">
<link href = "css/sidebar.css" rel = "stylesheet">
<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  
<!-- morris js-->

<script src="js/jquery-1.11.3.min.js"></script>
<!--bootstrap-->
<script src="js/bootstrap.min.js"></script>
<!--picture captions-->
<script src="js/jquery.caption.js" type="text/javascript"></script>
<!--<script src="js/jquery1.7.1.min.js" type="text/javascript"></script>-->
<!--twitter feed-->
<script src="js/zframework.js" type="text/javascript"></script>
<!--rickshaw js charts-->
<script src="js/d3.min.js"></script>
<script src="js/d3.v3.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="js/rickshaw.min.js"></script>
<!--wordcloud-->

<link rel="stylesheet" href="css/jqcloud.min.css">

<link href="css/captionjs.min.css" rel="stylesheet"/>
<link href="css/jquery.zrssfeed.css" rel="stylesheet" type="text/css" />
<link href="css/zframework.css" rel="stylesheet" type="text/css" />
<!--rickshaw js charts-->
<link type="text/css" rel="stylesheet" href="css/graph/graph.css">
<link type="text/css" rel="stylesheet" href="css/graph/detail.css">
<link type="text/css" rel="stylesheet" href="css/graph/legend.css">


<link href="http://nvd3-community.github.io/nvd3/build/nv.d3.css" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js" charset="utf-8"></script>
<script src="http://nvd3-community.github.io/nvd3/build/nv.d3.js"></script>
<script src="http://nvd3-community.github.io/nvd3/examples/lib/stream_layers.js"></script>
    
</head>