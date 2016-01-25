<?php


require('includes/connect.php');
require('includes/head.php');


$details = json_decode(file_get_contents("http://ipinfo.io/"));
$postcode=$details->postal; 
$date = date('Y-m-d');//today







$movieInfoQueryGen = "SELECT * FROM `movieinfo` WHERE 1=1";

$showQuery = "SELECT * FROM `tvshow` WHERE 1=1";
$showResult = mysqli_query($conn, $showQuery);

$theatreQuery = "SELECT * FROM `movieinfo` AS i INNER JOIN `intheatres` AS t on i.movieId = t.movieId WHERE 1=1";
$theatreResult = mysqli_query($conn, $theatreQuery);


$genreResult = mysqli_query($conn, $movieInfoQueryGen);

$datefile = file_get_contents("includes/recentDate.txt");
//echo $file."<br>";
$formattedRecentDate = $datefile;
$recentQuery = "SELECT * FROM `movieinfo` WHERE 1=1 AND releaseDate = '$formattedRecentDate'";
$recentResult = mysqli_query($conn, $recentQuery);


$sentRankingQueryPositive = "SELECT positive, negative, m.name, m.movieId FROM `sentrank` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId ORDER BY positive DESC LIMIT 5";
$sentRankResultPositive = mysqli_query($conn, $sentRankingQueryPositive) or die(mysqli_error($conn)); 

$sentRankingQueryNegative = "SELECT positive, negative, m.name, m.movieId FROM `sentrank` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId ORDER BY negative DESC LIMIT 5";
$sentRankResultNegative = mysqli_query($conn, $sentRankingQueryNegative) or die(mysqli_error($conn)); 

$ratingRankingQueryPositive = "SELECT average, m.name, m.movieId FROM `averagerating` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId WHERE average<>'0' ORDER BY average DESC LIMIT 5";
$ratingRankResultPositive = mysqli_query($conn, $ratingRankingQueryPositive) or die(mysqli_error($conn)); 

$ratingRankingQueryNegative = "SELECT average, m.name, m.movieId FROM `averagerating` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId WHERE average<>'0' ORDER BY average ASC LIMIT 5";
$ratingRankResultNegative = mysqli_query($conn, $ratingRankingQueryNegative) or die(mysqli_error($conn)); 



?>


	


<html>
<?php 
require('includes/navbar.php');
require('includes/string.php');
?>


<body>





<!-- Sidebar -->
        <!--<div id="sidebar-wrapper" class = "rightStick">
            <ul class="sidebar-nav">
                	<?php 
			mysqli_data_seek($result,0);//return to 0th index
			while ($row = mysqli_fetch_array($result)){?>
				<a href = "#<?php 
					$id = str_replace(' ', '-', $row['name']);
					echo $id;
				?>"><?php echo $row['name']."<br>";?></a>
			<?php }?>
            </ul>
        </div>-->
        <!-- /#sidebar-wrapper -->


<!--<div class = "row"  >	
	<div class = "container-medium" >

	<div class = "jumbotron">
		<h1>Find subtitles for the latest movies</h1>
	</div>

	<div class = "">
		
		<?php //require("content/displayMovies.php");?>		

		

	</div>
	</div>
<!--end row-->
<!--</div>-->




        	<div style = "margin-top: 50px"></div>
        
            	<div class = "jumbotron">
					<h1>Find subtitles for the latest movies</h1>
					<p><?php 

					if(isset($_GET['genre'])){
						if($genre!="All"){
							echo $_GET['genre'];
						}
					}
					?></p>
					 
					 <form class="form-inline" action = "movies.php" method = "get">
					

					  <div class="form-group">
					   
					    <input type="text" class="form-control" name = "searchName" placeholder="Search for movies">
					  </div>
					  <input type="submit" class="btn btn-default" value = "Search"></button>
					</form>					 

					<form class="navbar-form navbar-left form-inline" role="search" action = "movieShowtimes.php"
					  method = "get">
						 	<div class = "form-group">Display showtimes</div>
						 	<div class = "form-group">
							<select class="form-control" id = "movie" name = "movie" required>
								<option value="All">All movies</option>
								<!--<option value="Afganistan">Afghanistan</option>-->
								<?php
									$theatreQuery = "SELECT * FROM `movieinfo` AS i INNER JOIN `intheatres` AS t on i.movieId = t.movieId WHERE 1=1";
									$theatreResult = mysqli_query($conn, $theatreQuery);
									mysqli_data_seek($theatreResult,0);//return to 0th index
									while ($row = mysqli_fetch_array($theatreResult))//redundant
									{			
										$movieNameQuery = "SELECT * FROM `moviename` WHERE movieId = '".$row['movieId']."'";
										$movieNameResult = mysqli_query($conn, $movieNameQuery);

										if(!$movieNameResult)
										{
											continue;
										}

										$movieNameRow = mysqli_fetch_array($movieNameResult);
										echo '<option value="'.$movieNameRow['name'].'">'.$movieNameRow['name'].'</option>';
									}

								?>
								
							</select>
						</div>
					        
					        <div class="form-group">
					          <input name = "date" type="date" class="form-control">
					        </div>

					        <div class="form-group">
					        	<!--hidden because value is php postcode but it will still be passed as param to url-->
					          <input type="hidden" name="postcode" value="<?php echo $postcode; ?>">
					        </div>
					        

					        <button type="submit" class="btn btn-default">Display showtimes near me</button>
					      </form>
						<br><br>
					


				</div>

				<div class = "row">			
					<div class = "col-xs-6">
						<div class="panel panel-default">
						  <div class="panel-heading">
						    <h3 class="panel-title">Most positive tweets today</h3>
						  </div>
						  <div class="panel-body">
						  		<table class="table table-hover table-condensed">
						  			<tr><th style= "text-align: center">Name</th><th style= "text-align: center">Number of positive tweets</th></tr>
								<?php
									while($row = mysqli_fetch_array($sentRankResultPositive)){
										echo'<tr><td><a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'">'.$row['name'].'</a></td><td>'.$row['positive'].'</td></tr>';
									}

								?>
								</table>
						  </div>
						</div>
						
					</div>
					<div class = "col-xs-6">
						<div class="panel panel-default">
						  <div class="panel-heading">
						    <h3 class="panel-title">Most negative tweets today</h3>
						  </div>
						  <div class="panel-body">
						  		<table class="table table-hover table-condensed">
						  			<tr><th style= "text-align: center">Name</th><th style= "text-align: center">Number of negative tweets</th></tr>
								<?php
									while($row = mysqli_fetch_array($sentRankResultNegative)){
										echo'<tr><td><a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'">'.$row['name'].'</a></td><td>'.$row['negative'].'</td></tr>';
									}

								?>
								</table>
						  </div>
						</div>
						
					</div>
				</div>


				<div class = "row">			
					<div class = "col-xs-6">
						<div class="panel panel-default">
						  <div class="panel-heading">
						    <h3 class="panel-title">Highest average rating today</h3>
						  </div>
						  <div class="panel-body">
						  		<table class="table table-hover table-condensed">
						  			<tr><th style= "text-align: center">Name</th><th style= "text-align: center">Rating</th></tr>
								<?php
								
									while($row = mysqli_fetch_array($ratingRankResultPositive)){
										echo'<tr><td><a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'">'.$row['name'].'</a></td><td>'.$row['average'].'</td></tr>';
								
									}

								?>
								</table>
						  </div>
						</div>
						
					</div>
					<div class = "col-xs-6">
						<div class="panel panel-default">
						  <div class="panel-heading">
						    <h3 class="panel-title">Lowest average rating today</h3>
						  </div>
						  <div class="panel-body">
						  		<table class="table table-hover table-condensed">
						  			<tr><th style= "text-align: center">Name</th><th style= "text-align: center">Rating</th></tr>
								<?php
									while($row = mysqli_fetch_array($ratingRankResultNegative)){
										echo'<tr><td><a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'">'.$row['name'].'</a></td><td>'.$row['average'].'</td></tr>';
									}

								?>
								</table>
						  </div>
						</div>
						
					</div>
				</div>

                <div class="row">

                    <div class="col-lg-12">
                    	<section class = "bg-light-gray" style = "margin-bottom:9px; padding-left:30px"><h2>Movies  <a href = "movies.php"><input class="btn btn-default" type="button" value="View all"></a></h2></section>
                        <?php
                        	$i = 0;
							mysqli_data_seek($genreResult,0);//return to 0th index
							while ($row = mysqli_fetch_array($genreResult))//redundant
										
								{
									
									$movieNameQuery = "SELECT * FROM `moviename` WHERE movieId = '".$row['movieId']."'";
									$movieNameResult = mysqli_query($conn, $movieNameQuery);

									if(!$movieNameResult)
									{
										continue;
									}

									$movieNameRow = mysqli_fetch_array($movieNameResult);

									$tomatoQuery = "SELECT * FROM `tomato` WHERE movieId = '".$row['movieId']."'";
									$tomatoResult = mysqli_query($conn, $tomatoQuery);
									$tomatoRow = mysqli_fetch_array($tomatoResult);


									$imdbQuery = "SELECT * FROM `imdb` WHERE movieId = '".$row['movieId']."'";
									$imdbResult = mysqli_query($conn, $imdbQuery);
									$imdbRow = mysqli_fetch_array($imdbResult);

									$linkQuery = "SELECT * FROM `links` WHERE movieId = '".$row['movieId']."'";
									$linkResult = mysqli_query($conn, $linkQuery);
									$linkRow = mysqli_fetch_array($linkResult);
								 	
								 	$averageRatingQuery = "SELECT average FROM `averagerating` WHERE movieId = '".$row['movieId']."'";
									$averageRatingResult = mysqli_query($conn, $averageRatingQuery);
									$averageRatingRow = mysqli_fetch_array($averageRatingResult);
									$average = $averageRatingRow['average'];
								  
									?>						

									<div class="col-lg-15 col-md-3 col-sm-4 col-xs-6 thumb " >
										<!--need urlencode because by default "+" is translated to " " in get requests-->
										<a class="" href="movieInfo.php?movieId=<?php echo urlencode($row['movieId']);?>">
					                    	<img id = "stacked" class="img-responsive   " 
					                    		data-caption="
					                    			<?php 
					                    				echo $movieNameRow['name'];
					                    				echo '<br>';
					                    				echo $row['genre'];
					                    				echo '<br>';
					                    				echo 'Average Rating:'." ".$average;
					                    				?>" 
					                    		src="<?php 
						                    		$filename = 'poster/'.normalize($row['movieId']).'.jpg';
						                    		if(file_exists($filename)){
						                    			echo $filename;
						                    		}
						                    		?>
						                    		" alt="" 
					                    		>		           
						                </a>   
									</div>

						<?php 
						$i++;
						if($i == 5)
						{
							break;
						}
						} ?>	
                       
                    </div>
                </div>







                <!--tvshow-->
                 <div class="row">
                    <div class="col-lg-12">
                    	<section class = "bg-light-gray" style = "margin-bottom:9px; padding-left:30px"><h2>Latest TV shows  <a href = "todayShows.php"><input class="btn btn-default" type="button" value="View all"></a></h2></section>
                    	<?php 
                    	$j = 0;
                    	mysqli_data_seek($showResult,0);//return to 0th index
						while ($row = mysqli_fetch_array($showResult)){
                    	?>
                         <div class="col-lg-15 col-md-3 col-sm-4 col-xs-6 thumb " >
				            <!--need urlencode because by default "+" is translated to " " in get requests-->
				            <a class="" href="showInfo.php?showName=<?php echo $row['episodeName'];?>">
				                        <img id = "stacked" class="img-responsive   " 
				                          data-caption="
				                            <?php 
				                              echo $row['episodeName'];
				                              echo '<br>';
				                              echo $row['showName'];
				                              echo '<br>';
				                              echo "S".$row['season']. "E".$row['number'];
				                              echo '<br>';
				                              echo "Show average rating: ".$row['showAverageRating'];
				                             
				                              ?>" 
				                          src="<?php echo $row['image'];?>" alt="" >              
				                    </a>   
				          </div>
				          <?php 
				          	$j++;
				          	if($j == 5){
				          		break;
				          	}	
				      		} 
				          ?>





                       
                    </div>
                </div>



            	







            	<div class="row">

                    <div class="col-lg-12">
                    	<section class = "bg-light-gray" style = "margin-bottom:9px; padding-left:30px"><h2>Recently Released  <a href = "recent.php"><input class="btn btn-default" type="button" value="View all"></a></h2></section>
                        <?php
                        	$i = 0;
							mysqli_data_seek($recentResult,0);//return to 0th index
							while ($row = mysqli_fetch_array($recentResult))//redundant
										
								{
									
									$movieNameQuery = "SELECT * FROM `moviename` WHERE movieId = '".$row['movieId']."'";
									$movieNameResult = mysqli_query($conn, $movieNameQuery);

									if(!$movieNameResult)
									{
										continue;
									}

									$movieNameRow = mysqli_fetch_array($movieNameResult);

									$tomatoQuery = "SELECT * FROM `tomato` WHERE movieId = '".$row['movieId']."'";
									$tomatoResult = mysqli_query($conn, $tomatoQuery);
									$tomatoRow = mysqli_fetch_array($tomatoResult);


									$imdbQuery = "SELECT * FROM `imdb` WHERE movieId = '".$row['movieId']."'";
									$imdbResult = mysqli_query($conn, $imdbQuery);
									$imdbRow = mysqli_fetch_array($imdbResult);

									$linkQuery = "SELECT * FROM `links` WHERE movieId = '".$row['movieId']."'";
									$linkResult = mysqli_query($conn, $linkQuery);
									$linkRow = mysqli_fetch_array($linkResult);
								 	
								 	$averageRatingQuery = "SELECT average FROM `averagerating` WHERE movieId = '".$row['movieId']."'";
									$averageRatingResult = mysqli_query($conn, $averageRatingQuery);
									$averageRatingRow = mysqli_fetch_array($averageRatingResult);
									$average = $averageRatingRow['average'];
								  
									?>						

									<div class="col-lg-15 col-md-3 col-sm-4 col-xs-6 thumb " >
										<!--need urlencode because by default "+" is translated to " " in get requests-->
										<a class="" href="movieInfo.php?movieId=<?php echo urlencode($row['movieId']);?>">
					                    	<img id = "stacked" class="img-responsive   " 
					                    		data-caption="
					                    			<?php 
					                    				echo $movieNameRow['name'];
					                    				echo '<br>';
					                    				echo $row['genre'];
					                    				echo '<br>';
					                    				echo 'Average Rating:'." ".$average;
					                    				?>" 
					                    		src="<?php 
						                    		$filename = 'poster/'.normalize($row['movieId']).'.jpg';
						                    		if(file_exists($filename)){
						                    			echo $filename;
						                    		}
						                    		?>
						                    		"  alt="" 
					                    		>		           
						                </a>   
									</div>

						<?php 
						$i++;
						if($i == 5)
						{
							break;
						}
						} ?>	
                       
                    </div>
                </div>








                <div class="row">

                    <div class="col-lg-12">
                    	<section class = "bg-light-gray" style = "margin-bottom:9px; padding-left:30px"><h2>In Theatres   <a href = "theatre.php"><input class="btn btn-default" type="button" value="View all"></a></h2></section>
                        <?php
                        	$i = 0;
							mysqli_data_seek($theatreResult,0);//return to 0th index
							while ($row = mysqli_fetch_array($theatreResult))//redundant
										
								{
									
									$movieNameQuery = "SELECT * FROM `moviename` WHERE movieId = '".$row['movieId']."'";
									$movieNameResult = mysqli_query($conn, $movieNameQuery);

									if(!$movieNameResult)
									{
										continue;
									}

									$movieNameRow = mysqli_fetch_array($movieNameResult);

									$tomatoQuery = "SELECT * FROM `tomato` WHERE movieId = '".$row['movieId']."'";
									$tomatoResult = mysqli_query($conn, $tomatoQuery);
									$tomatoRow = mysqli_fetch_array($tomatoResult);


									$imdbQuery = "SELECT * FROM `imdb` WHERE movieId = '".$row['movieId']."'";
									$imdbResult = mysqli_query($conn, $imdbQuery);
									$imdbRow = mysqli_fetch_array($imdbResult);

									$linkQuery = "SELECT * FROM `links` WHERE movieId = '".$row['movieId']."'";
									$linkResult = mysqli_query($conn, $linkQuery);
									$linkRow = mysqli_fetch_array($linkResult);
								 	
								 	$averageRatingQuery = "SELECT average FROM `averagerating` WHERE movieId = '".$row['movieId']."'";
									$averageRatingResult = mysqli_query($conn, $averageRatingQuery);
									$averageRatingRow = mysqli_fetch_array($averageRatingResult);
									$average = $averageRatingRow['average'];
								  
									?>						

									<div class="col-lg-15 col-md-3 col-sm-4 col-xs-6 thumb " >
										<!--need urlencode because by default "+" is translated to " " in get requests-->
										<a class="" href="movieInfo.php?movieId=<?php echo urlencode($row['movieId']);?>">
					                    	<img id = "stacked" class="img-responsive   " 
					                    		data-caption="
					                    			<?php 
					                    				echo $movieNameRow['name'];
					                    				echo '<br>';
					                    				echo $row['genre'];
					                    				echo '<br>';
					                    				echo 'Average Rating:'." ".$average;
					                    				?>" 
					                    		src="<?php 
						                    		$filename = 'poster/'.normalize($row['movieId']).'.jpg';
						                    		if(file_exists($filename)){
						                    			echo $filename;
						                    		}
						                    		?>
						                    		"  alt="" 
					                    		>		           
						                </a>   
									</div>

						<?php 
						$i++;
						if($i == 5)
						{
							break;
						}
						} ?>	
                       
                    </div>
                </div>
     








<img src="phpjobscheduler/firepjs.php?return_image=1" border="0" alt="phpJobScheduler">

        
	




	<!-- Scrolling Nav JavaScript -->
	
    
    <script src = "js/bootstrap.min.js"></script>
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