<?php


require('includes/connect.php');
require('functions/generateDataLayer.php');
require('functions/string.php');

$details = json_decode(file_get_contents("http://ipinfo.io/"));
$postcode=$details->postal; 
$date = date('Y-m-d');//today







$movieInfoQueryGen = "SELECT * FROM `movieinfo` WHERE 1=1";

$showQuery = "SELECT * FROM `tvshow` WHERE 1=1";
$showResult = mysqli_query($conn, $showQuery);

$theatreQuery = "SELECT * FROM `movieinfo` AS i INNER JOIN `intheatres` AS t on i.movieId = t.movieId INNER JOIN `moviename` as m on i.movieId=m.movieId";
$theatreResult = mysqli_query($conn, $theatreQuery);


$genreResult = mysqli_query($conn, $movieInfoQueryGen);

$datefile = file_get_contents("includes/recentDate.txt");
//echo $file."<br>";
$formattedRecentDate = $datefile;
$recentQuery = "SELECT * FROM `movieinfo` WHERE 1=1 AND releaseDate = '$formattedRecentDate'";
$recentResult = mysqli_query($conn, $recentQuery);

//recent
$datefile = file_get_contents("includes/recentDate.txt");
$formattedRecentDate = $datefile;


//p=metric trend/sentiment/rating
$p="rating";
$sentSort="pos";
$ratingSort="des";
$view="list";
$genre="All";
$searchName="";
//if theatre=moviethen it shows all movies
$movie="theatre";

if(isset($_GET['movie'])){
	$movie=$_GET['movie'];
}

//queries
$sentRankingQuery = "SELECT positive, negative, m.name, m.movieId, n.plot,n.genre FROM `sentrank` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId INNER JOIN `movieinfo` as n on i.movieId = n.movieId ";
$ratingRankingQuery = "SELECT average, m.name, m.movieId, n.plot,n.genre FROM `averagerating` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId INNER JOIN `movieinfo` as n on i.movieId = n.movieId ";


if($movie=="theatre"){
	$sentRankingQuery.="INNER JOIN `intheatres` as t on m.movieId=t.movieId ";
	$ratingRankingQuery.="INNER JOIN `intheatres` as t on m.movieId=t.movieId ";
} 

$sentRankingQuery.="WHERE 1=1 ";
//$ratingRankingQuery.="WHERE average<>'0' ";
$ratingRankingQuery.="WHERE 1=1 ";

if ($movie == "recent"){
	$sentRankingQuery.="AND releaseDate = '$formattedRecentDate'";
	$ratingRankingQuery.="AND releaseDate = '$formattedRecentDate'";
}

if(isset($_GET['genre'])){
	$genre=$_GET['genre'];
	if($genre!="All"){
		$sentRankingQuery.="AND genre LIKE '%$genre%'";
		$ratingRankingQuery.="AND genre LIKE '%$genre%'";
	}
}

if(isset($_GET['searchName'])){
	$searchName=str_replace(" ", "+", trim($_GET['searchName']));
	$sentRankingQuery.="AND m.movieId LIKE '%$searchName%'";
	$ratingRankingQuery.="AND m.movieId LIKE '%$searchName%'";
}

if(isset($_GET['p'])){
	$p=$_GET['p'];
}

if($p=="sentiment"){
	if(isset($_GET['sentSort'])){
		$sentSort=$_GET['sentSort'];
	}
	if($sentSort=="pos" || empty($sentSort)){
		$sentRankingQuery.=" ORDER BY positive DESC";
	} else if ($sentSort=="neg"){
		$sentRankingQuery.=" ORDER BY negative DESC";
	}
}

if($p=="rating"){
	if(isset($_GET['ratingSort'])){
		$ratingSort=$_GET['ratingSort'];
	}
	if($ratingSort=="asc"){
		$ratingRankingQuery.=" ORDER BY average ASC";
	} else if ($ratingSort=="des" || empty($ratingSort)){
		$ratingRankingQuery.=" ORDER BY average DESC";
	}
	
}



if(isset($_GET['view'])){
	$view=$_GET['view'];
}



$sentRankResult = mysqli_query($conn, $sentRankingQuery) or die(mysqli_error($conn)); 
$ratingRankResult= mysqli_query($conn, $ratingRankingQuery) or die(mysqli_error($conn)); 

$chosenResult = $p=="sentiment" ? $sentRankResult : $ratingRankResult;
$chosenSort= $p=="sentiment" ? $sentSort : $ratingSort;
$dataLayer = generateDataLayer($chosenResult, $p, $view, $genre, $movie, $chosenSort, $searchName);

mysqli_data_seek($ratingRankResult,0);
mysqli_data_seek($sentRankResult,0);
?>



	

<!DOCTYPE html>
<?php require('includes/head.php'); ?>
<html>

<body>

<script type="text/javascript">
//datalayer information- just make php list variable and use it here

dataLayer = <?php echo $dataLayer; ?>;

</script>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-K4D47X"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K4D47X');</script>
<!-- End Google Tag Manager -->

<?php require('includes/navbar.php'); ?>
<div id="wrapper" style = "padding-left: 300px;">

        <!-- Sidebar -->
        <div class = "formHover" id="sidebar-wrapper" style = "width: 300px; padding-left: 15px;">
            <ul class="sidebar-nav">
            	<br>
                <!--<li class="sidebar-brand">
                    <h4><br>
                        Theatre Releases
                    </h4>
                </li>-->
                <br>					
                <div id = "topMenu">													
                <li class = "<?php if($movie=="theatre"||empty($p))echo"menuActive";?>">
                	<a id = "theatre" onclick="movieClick(this.id); categoryEvent('theatre')">Theatre releases</a>
                </li>
                <li class = "<?php if($movie=="recent")echo"menuActive";?>">
                	<a id = "recent" onclick="movieClick(this.id); categoryEvent('recent')">Recently released</a>
                </li>
                <li class = "<?php if($movie=="movie")echo"menuActive";?>">
                	<a id = "movie" onclick="movieClick(this.id); categoryEvent('all')">All movies</a>
                </li>	
                </div>								
                <hr>

               
                <li class = "<?php if($p=="sentiment")echo"menuActive";?>">
                    <a id = "sentiment" onclick = "pClick(this.id); metricEvent('sentiment')">Twitter sentiment<span class="glyphicon glyphicon-play"></span></a>
                </li>
                <li class = "<?php if($p=="rating")echo"menuActive";?>">
                    <a id = "rating" onclick = "pClick(this.id); metricEvent('rating')">Rating <span class="glyphicon glyphicon-play"></span></a>
                </li>
                <hr>


                <form class="form" method = "get">
				  <div class="form-group">
				    <input type="text" class="form-control" id="searchNameHome" placeholder="Search for movies">
				  </div>
				  <a style = "curser:pointer" class="btn btn-default" onclick="searchClick(); searchEvent()">Search</a>
				</form>	
				<hr>

                <div id = "menu">
                <p>
                        Genre
                </p>	
                <li>
                    <a id="All" onclick = "genreClick(this.id); genreEvent(this.id)">All</a>
                </li>
                <li>
                    <a id="Action" onclick = "genreClick(this.id); genreEvent(this.id)">Action</a>
                </li>
                <li>
                    <a id="Comedy" onclick = "genreClick(this.id); genreEvent(this.id)">Comedy</a>
                </li>
                <li>
                    <a id="Family" onclick = "genreClick(this.id); genreEvent(this.id)">Family</a>
                </li>
                <li>
                    <a id="Musical" onclick = "genreClick(this.id); genreEvent(this.id)">Musical</a>
                </li>
                <li>
                   <a id="Adventure" onclick = "genreClick(this.id); genreEvent(this.id)">Adventure</a>
                </li>
                <li>
                    <a id="Crime" onclick = "genreClick(this.id); genreEvent(this.id)">Crime</a>
                </li>
                <li>
                    <a id="Mystery" onclick = "genreClick(this.id); genreEvent(this.id)">Mystery</a>
                </li>
                <li>
                    <a id="Fantasy" onclick = "genreClick(this.id); genreEvent(this.id)">Fantasy</a>
                </li>
                <li>
                    <a id="Thriller" onclick = "genreClick(this.id); genreEvent(this.id)">Thriller</a>
                </li>
                <li>
                    <a id="Sport" onclick = "genreClick(this.id); genreEvent(this.id)">Sport</a>
                </li>
                <li>
                    <a id="Animation" onclick = "genreClick(this.id); genreEvent(this.id)">Animation</a>
                </li>
                <li>
                    <a id="Documentary" onclick = "genreClick(this.id); genreEvent(this.id)">Documentary</a>
                </li>
                <li>
                    <a id="History" onclick = "genreClick(this.id); genreEvent(this.id)">History</a>
                </li>
                <li>
                    <a id="Romance" onclick = "genreClick(this.id); genreEvent(this.id)">Romance</a>
                </li>
                <li>
                    <a id="War" onclick = "genreClick(this.id); genreEvent(this.id)">War</a>
                </li>
                 <li>
                    <a id="Biography" onclick = "genreClick(this.id); genreEvent(this.id)">Biography</a>
                </li>
                <li>
                    <a id="Drama" onclick = "genreClick(this.id); genreEvent(this.id)">Drama</a>
                </li>
                <li>
                    <a id="Horror" onclick = "genreClick(this.id); genreEvent(this.id)">Horror</a>
                </li>
                <li>
                    <a id="Sci-Fi" onclick = "genreClick(this.id); genreEvent(this.id)">Sci-Fi</a>
                </li>
                <li>
                    <a id="Western" onclick = "genreClick(this.id); genreEvent(this.id)">Western</a>
                </li>
               	</div>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <section class = "bg-white" style = "padding-left:20px; padding-right:10px; padding-top:50px" >
		<div class="row">
			<div class="col-lg-12">
    		<div class="tab-content">

    			<?php 
    			//echo $ratingRankingQuery;
    			if($p=="rating"||$p=="sentiment"){
    			?>
    			<div role="tabpanel" id="rating">
    				<div class = "row">
    					<div class = "col-xs-12">
    						<?php
    						if($p=="rating"||empty($p)){
    							echo '<h3>Average rating today</h3>';
    						} else if($p=="sentiment"){
    							echo '<h3>Sentiment today</h3>';
    						}

    						switch($movie){
    							case "theatre":
    								echo "Theatre releases";
    								break;
    							case "":
    								echo "Theatre releases";
    								break;
    							case "recent":
    								echo "Recently Released";
    								break;
    							case "movie":
    								echo "All movies";
    								break;

    						}

    						echo " | ";
    						if(empty($genre)||$genre=="All"){
    							echo "Showing All genres";
    						} else{
	    						echo "Showing ".$genre." genre";
	    					}

	    					echo " | Sort: ";
	    					if($p=="rating" || empty ($p)){
	    						if($ratingSort=="asc"){
	    							echo "Ascending";
	    						} else {
	    							echo "Descending";
	    						}
	    					} else if ($p=="sentiment"){
	    						if($sentSort=="neg"){
	    							echo "Negative tweets";
	    						} else {
	    							echo "Positive tweets";
	    						}
	    					}
    						
    						echo " | Search: ";
    						echo $searchName;

    						?>	
    						

    						<div class = "form-inline">
    						<div class="dropdown" style = "display:inline">
							  <a class="dropdown-toggle btn btn-default" data-toggle="dropdown" href="#" >Sort <span class="caret"></span></a>
							  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">

							  	<?php 
							  	if($p=="rating" || empty($p)){
							  	?>
								    <li style = "cursor: pointer;">
								    	<a id="asc" onclick="ratingClick(this.id); sortEvent('Rating', 'Ascending')">Sort ascending</a>
								    </li>
								    <li style = "cursor: pointer;">
								    	<a id="des" onclick="ratingClick(this.id); sortEvent('Rating', 'Descending')">Sort descending</a>
								    </li>
								<?php 
								} else {
								?>
								<li style = "cursor: pointer;">
							    	<a id="pos" onclick="sentClick(this.id); sortEvent('Sentiment', 'Positive')">Sort by Positive tweets</a>
							    </li>
							    <li style = "cursor: pointer;">
							    	<a id="neg" onclick="sentClick(this.id); sortEvent('Sentiment', 'Negative')">Sort by Negative tweets</a>
							    </li>
							    <?php 
								}	
								?>

							  </ul>
							</div>

							<div style = "display:inline">
							    <a class = "btn btn-default" id="list" onclick="viewClick(this.id); viewEvent('list')">List view  <span class = "glyphicon glyphicon-list"></span></a>
							    <a class = "btn btn-default" id="grid" onclick="viewClick(this.id); viewEvent('grid')">Grid view  <span class = "glyphicon glyphicon-th-large"></span></a>
							</div>
							</div>
							<br>
    						
    						<?php 
    						$finalResult="";
							if($p=="rating"||empty($p)){
								$finalResult=$ratingRankResult;
							} else if ($p=="sentiment"){
								$finalResult=$sentRankResult;
							}
							
    						if($view=="list"||empty($view)){
    						?>
    							<ul class="list-group">
								<?php 
								//$movie['title'].'<br>'. $movie['description']['description']
								
								while($row = mysqli_fetch_array($finalResult)){

									$movieNameQuery = "SELECT * FROM `moviename` WHERE movieId = '".$row['movieId']."'";
									$movieNameResult = mysqli_query($conn, $movieNameQuery);
									
									if(!$movieNameResult)
									{
										continue;
									}

									$filename = 'poster/'.normalize($row['movieId']).'.jpg';
				            		if(!file_exists($filename)){
				            			continue;
				            		}

									echo '<li class="list-group-item">';
										echo '<div class = "row">';
											echo '<div class = "col-xs-1">';
											//poster
											?>
											<div class = "miniPoster">
											<img src="
				                    		<?php 
				                    		$filename = 'poster/'.normalize($row['movieId']).'.jpg';
				                    		if(file_exists($filename)){
				                    			echo $filename;
				                    		}
				                    		?>
				                    		" alt = "<?php echo $row['name']; ?>"></img></div>
											<?php
											echo '</div>';
											echo '<div class = "col-xs-11">';
											//text
											echo '<a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'" onclick="movieEvent('.$row['movieId'].')">'.$row['name'].'</a><br>';
											if($p=="rating"||empty($p)){
												if($row['average']==0){
													echo "Rating: not calculated<br>";
												} else {
													echo "Rating: ".$row['average']."<br>";
												}
											} else if($p=="sentiment"){
												if($sentSort=="neg" ){
													echo "Number of negative tweets: ".$row['negative']."<br>";
												} else if($sentSort=="pos" || empty($sentSort)){
													echo "Number of positive tweets: ".$row['positive']."<br>";
												}
											}
											echo "Genre: ".$row['genre']."<br>";
											echo substr($row['plot'], 0,200)."...";

											echo '</div>';
											
										echo '</div>';
									echo '</li>';
									
								}
								?>
								</ul>
							<?php
							} else {
								while ($row = mysqli_fetch_array($finalResult))//redundant
								{
									$movieNameQuery = "SELECT * FROM `moviename` WHERE movieId = '".$row['movieId']."'";
									$movieNameResult = mysqli_query($conn, $movieNameQuery);
									
									if(!$movieNameResult)
									{
										continue;
									}

									$filename = 'poster/'.normalize($row['movieId']).'.jpg';
				            		if(!file_exists($filename)){
				            			continue;
				            		}


									$averageRatingQuery = "SELECT average FROM `averagerating` WHERE movieId = '".$row['movieId']."'";
									$averageRatingResult = mysqli_query($conn, $averageRatingQuery);
									$averageRatingRow = mysqli_fetch_array($averageRatingResult);
									$average = $averageRatingRow['average'];
											//  echo $average;
								
								  
									?>
									<div class="col-lg-15 col-md-3 col-sm-4 col-xs-6 thumb " >
										<!--need urlencode because by default "+" is translated to " " in get requests-->
										<a class="" href="movieInfo.php?movieId=<?php echo urlencode($row['movieId']);?>" onclick="movieEvent(<?php echo $row['name']; ?>)">
					                    	<img id = "stacked" class="img-responsive   " 
					                    		data-caption="
					                    			<?php 
					                    				echo $row['name'];
					                    				echo '<br>';
					                    				echo $row['genre'];
					                    				echo '<br>';
					                    				if($p=="rating"||empty($p)){
															echo "Rating: ".$row['average']."<br>";
														} else if($p=="sentiment"){
															if($sentSort=="neg" ){
																echo "Number of negative tweets: ".$row['negative']."<br>";
															} else if($sentSort=="pos" || empty($sentSort)){
																echo "Number of positive tweets: ".$row['positive']."<br>";
															}
														}
					                    				?>" 
					                    		src="
					                    		<?php 
					                    			echo $filename;
					                    		?>
					                    		" alt="<?php echo $row['name']; ?>" 
					                    		>		           
						                </a>   
									</div>
									<?php 
									} 

							}
							?>	
    					</div>
    				</div>
    			</div>
    			<?php 
    			}
    			?>

    		</div>
	        </div>
	    </div>
        </section>
 
</div>
<!-- /#wrapper -->

            
<img src="phpjobscheduler/firepjs.php?return_image=1" border="0" alt="phpJobScheduler">

        



</script>


	<!-- Scrolling Nav JavaScript -->
	
    
    <script src = "js/bootstrap.min.js"></script>

    <script type="text/javascript">
    function genreClick(clickedId){
			var gen = location.search.split('genre=')[1] ? location.search.split('genre=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = url;
					

					if (url.indexOf('?') > -1){
						//has question mark
						altered = altered.concat("&genre=").concat(clickedId);
					} else {
						//no question mark
						altered = altered.concat("?&genre=").concat(clickedId);
					}
					//alert(altered);
					//go to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("genre", url);
					
					altered = altered.concat("&genre=").concat(clickedId);
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
			

		}

	function removeParam(key, sourceURL) {
		    var rtn = sourceURL.split("?")[0],
		        param,
		        params_arr = [],
		        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
		    if (queryString !== "") {
		        params_arr = queryString.split("&");
		        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
		            param = params_arr[i].split("=")[0];
		            if (param === key) {
		                params_arr.splice(i, 1);
		            }
		        }
		        rtn = rtn + "?" + params_arr.join("&");
		    }
		    return rtn;
		}	


		function movieClick(clickedId){

			var gen = location.search.split('movie=')[1] ? location.search.split('movie=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = url;
					//reset search
					if (url.indexOf('searchName') > -1){
						altered = removeParam("searchName", url);
					}

					if (url.indexOf('?') > -1){
						//has question mark
						altered = altered.concat("&movie=").concat(clickedId);
					} else {
						//no question mark
						altered = altered.concat("?&movie=").concat(clickedId);
					}
					//alert(altered);
					//go to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("movie", url);
					//reset search
					if (url.indexOf('searchName') > -1){
						altered = removeParam("searchName", url);
					}

					altered = altered.concat("&movie=").concat(clickedId);
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
			

		}

		function sentClick(clickedId){
			var gen = location.search.split('sentSort=')[1] ? location.search.split('sentSort=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = url;
					

					if (url.indexOf('?') > -1){
						//has question mark
						altered = altered.concat("&sentSort=").concat(clickedId);
					} else {
						//no question mark
						altered = altered.concat("?&sentSort=").concat(clickedId);
					}
					//alert(altered);
					//go to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("sentSort", url);
					
					altered = altered.concat("&sentSort=").concat(clickedId);
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
			

		}

		function viewClick(clickedId){
			var gen = location.search.split('view=')[1] ? location.search.split('view=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = url;
					

					if (url.indexOf('?') > -1){
						//has question mark
						altered = altered.concat("&view=").concat(clickedId);
					} else {
						//no question mark
						altered = altered.concat("?&view=").concat(clickedId);
					}
					//alert(altered);
					//go to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("view", url);
					
					altered = altered.concat("&view=").concat(clickedId);
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
			

		}

		function ratingClick(clickedId){
			var gen = location.search.split('ratingSort=')[1] ? location.search.split('ratingSort=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = url;
					

					if (url.indexOf('?') > -1){
						//has question mark
						altered = altered.concat("&ratingSort=").concat(clickedId);
					} else {
						//no question mark
						altered = altered.concat("?&ratingSort=").concat(clickedId);
					}
					//alert(altered);
					//go to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("ratingSort", url);
					
					altered = altered.concat("&ratingSort=").concat(clickedId);
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
			

		}

		function pClick(clickedId){
			var gen = location.search.split('p=')[1] ? location.search.split('p=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = url;
					

					if (url.indexOf('?') > -1){
						//has question mark
						altered = altered.concat("&p=").concat(clickedId);
					} else {
						//no question mark
						altered = altered.concat("?&p=").concat(clickedId);
					}
					//alert(altered);
					//go to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("p", url);
					
					altered = altered.concat("&p=").concat(clickedId);
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
			

		}


	function searchClick(){
			var searchText = document.getElementById('searchNameHome').value;
			var gen = location.search.split('searchName=')[1] ? location.search.split('searchName=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = url;
					

					if (url.indexOf('?') > -1){
						//has question mark
						altered = altered.concat("&searchName=").concat(searchText);
					} else {
						//no question mark
						altered = altered.concat("?&searchName=").concat(searchText);
					}
					//alert(altered);
					//go to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("searchName", url);
					
					altered = altered.concat("&searchName=").concat(searchText);
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
			

		}


	//adds active class if the button clicked has same name as $_GET['genre']
	$(document).ready(function () {
		$( "#menu a" ).addClass(function(){
			console.log($(this).text());
			if($(this).text()=== "<?php echo $genre; ?>"){
				return "menuActive";
			}
			else {
				return;
			}
		});
	});


	//Datalayer events

	/*
	generic code (need to map our own fields to each of these 5 event tracking fields)

	<!-- Snowplow event tracking -->
	<script type="text/javascript">
	window.snowplow('trackStructEvent', {{CATEGORY}}, {{ACTION}}, {{LABEL}}, {{PROPERTY}}, {{VALUE}});
	/script>
	VALUE is usually associated with price

	e.g. window.snowplow('trackStructEvent', 'video', 'playVideo', {{videoId}}, {{videoFormat}}, '0.0');
	(PASTE THIS INTO GOOGLE TAG MANAGER, for {{videoId}} and {{videoFormat}} remember to create a macro or else it wont work)
	

	Category	Yes	The name you supply for the group of objects you want to track e.g. 'media', 'ecomm'
	Action		A string which defines the type of user interaction for the web object e.g. 'play-video', 'add-to-basket'
	Label		An optional string which identifies the specific object being actioned e.g. ID of the video being played, or the SKU or the product added-to-basket
	Property	An optional string describing the object or the action performed on it. This might be the quantity of an item added to basket
	Value		An optional float to quantify or further describe the user action. This might be the price of an item added-to-basket, or the starting time of the video where play was just pressed
	*/

	//window.snowplow('trackStructEvent', 'sort', 'sortClick', {{sortType}}, {{sortValue}}, '0.0');
	function sortEvent(sortType, sortValue){
		dataLayer.push({
		  'event': 'sortClick',
		  'sortType': sortType,
		  'sortValue': sortValue,
		  
		});
	}

	//window.snowplow('trackStructEvent', 'view', 'changeView', '0', {{viewType}}, '0.0');
	function viewEvent(viewType){
		dataLayer.push({
		  'event': 'changeView',
		  'viewType': viewType
		});
	}

	//window.snowplow('trackStructEvent', 'genre', 'changeGenre', '0', {{genre}}, '0.0');
	function genreEvent(genre){
		dataLayer.push({
		  'event': 'changeGenre',
		  'genre': genre
		});
	}

	//window.snowplow('trackStructEvent', 'search', 'searchClick', '0', {{searchValue}}, '0.0');
	function searchEvent(){
		var searchValue = document.getElementById('searchNameHome').value;
		dataLayer.push({
		  'event': 'searchClick',
		  'searchValue': searchValue
		});
	}

	//window.snowplow('trackStructEvent', 'movie', 'movieClick', '0', {{movieId}}, '0.0');
	function movieEvent(movieId){
		dataLayer.push({
		  'event': 'movieClick',
		  'movieId': movieId
		});
	}

	//window.snowplow('trackStructEvent', 'metric', 'changeMetric', '0', {{metric}}, '0.0');
	function metricEvent(metric){
		dataLayer.push({
		  'event': 'changeMetric',
		  'metric': metric
		});
	}

	//window.snowplow('trackStructEvent', 'category', 'changeCategory', '0', {{category}}, '0.0');
	function categoryEvent(category){
		dataLayer.push({
		  'event': 'changeCategory',
		  'category': category
		});
	}

	//window.snowplow('trackStructEvent', 'link', 'navLinkClick', '0', {{link}}, '0.0');
	function navClickEvent(link){
		dataLayer.push({
		  'event': 'navLinkClick',
		  'link': link
		});
	}

	//window.snowplow('trackStructEvent', 'search', 'navSearchClick', '0', {{searchValue}}, '0.0');
	function navSearchEvent(){
		var searchValue = document.getElementById('searchNameNavbar').value;
		dataLayer.push({
		  'event': 'searchClick',
		  'searchValue': searchValue
		});
	}
	
    </script>

    <script>
    $('.dropdown-toggle').dropdown();
    </script>

   <script src="js/jquery.caption.js" type="text/javascript"></script>
    
    		<script type="text/javascript">
		$(window).load(function(){

			/*
			'class_name'      : 'captionjs', // Class name for each <figure>
	        'schema'          : true,        // Use schema.org markup (i.e., itemtype, itemprop)
	        'mode'            : 'stacked',   // default | stacked | animated | hide
	        'debug_mode'      : false,       // Output debug info to the JS console
	        'force_dimensions': true,        // Force the dimensions in case they cannot be detected (e.g., image is not yet painted to viewport)
	        'is_responsive'   : true,       // Ensure the figure and image change size when in responsive layout. Requires a container to control responsiveness!
	        'inherit_styles'  : false        // Have the caption.js container inherit box-model properties from the original image

			*/
			$('img#example-1').captionjs({
				'force_dimensions': true
			});

			$('img#stacked').captionjs({
				'force_dimensions': true,
				'is_responsive'   : true,
				'mode'            : 'stacked'

			});

			$('img#example-3').captionjs({
				'force_dimensions': true,
				'mode'            : 'hide'
			});

			$('img#example-4').captionjs({
				'force_dimensions': true,
				'mode'            : 'animated'
			});
		});
	</script>

		



	


</body>

</html>