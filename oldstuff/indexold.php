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


$sentRankingQueryPositive = "SELECT positive, negative, m.name, m.movieId, n.plot FROM `sentrank` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId INNER JOIN `movieinfo` as n on i.movieId = n.movieId ORDER BY positive DESC LIMIT 5";
$sentRankResultPositive = mysqli_query($conn, $sentRankingQueryPositive) or die(mysqli_error($conn)); 

$sentRankingQueryNegative = "SELECT positive, negative, m.name, m.movieId, n.plot FROM `sentrank` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId INNER JOIN `movieinfo` as n on i.movieId = n.movieId ORDER BY negative DESC LIMIT 5";
$sentRankResultNegative = mysqli_query($conn, $sentRankingQueryNegative) or die(mysqli_error($conn)); 

$ratingRankingQueryPositive = "SELECT average, m.name, m.movieId, n.plot FROM `averagerating` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId INNER JOIN `movieinfo` as n on i.movieId = n.movieId WHERE average<>'0' ORDER BY average DESC LIMIT 5";
$ratingRankResultPositive = mysqli_query($conn, $ratingRankingQueryPositive) or die(mysqli_error($conn)); 

$ratingRankingQueryNegative = "SELECT average, m.name, m.movieId, n.plot FROM `averagerating` AS i INNER JOIN `moviename` as m on i.movieId = m.movieId INNER JOIN `movieinfo` as n on i.movieId = n.movieId WHERE average<>'0' ORDER BY average ASC LIMIT 5";
$ratingRankResultNegative = mysqli_query($conn, $ratingRankingQueryNegative) or die(mysqli_error($conn)); 



?>



	

<!DOCTYPE html>
<html>
<?php 
require('includes/navbar.php');
require('includes/string.php');
?>


<body>


<div id="wrapper" style = "padding-left: 300px;">

        <!-- Sidebar -->
        <div id="sidebar-wrapper" style = "width: 300px; padding-left: 15px;">
            <ul class="sidebar-nav" id = "tabMenu">
                <li class="sidebar-brand">
                    <a href="#">
                        
                    </a>
                </li>
                
                <li>
                    <a href="#trending" role="tab" data-toggle="tab">Top trending 2015 <span class="glyphicon glyphicon-play"></span></a>
                </li>
                <li>
                    <a href="#sentiment" role="tab" data-toggle="tab">Twitter sentiment<span class="glyphicon glyphicon-play"></span></a>
                </li>
                <li>
                    <a href="#rating" role="tab" data-toggle="tab">Rating <span class="glyphicon glyphicon-play"></span></a>
                </li>
                <br><br>
               <div class="">
							  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							    Dropdown
							    <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							  	<!--this (clicking links on dropdowns) only works with bootstrap, not the html select tag-->
							    <li><a class = "" href="?p=rating&ratingSort=asc" >Sort ascending</a></li>
							    <li><a class = "" href="?p=rating&ratingSort=des" >Sort descending</a></li>
							  </ul>
							</div><br>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <section class = "bg-white" style = "padding-left:20px; padding-right:10px; padding-top:50px" >
		<div class="row">
			<div class="col-lg-12">
    		<div class="tab-content">
    			<div role="tabpanel" class="tab-pane fade in active" id="trending">
    				<h3>Highest searched films 2015</h3>
    				<ul class="list-group">
					<?php 
					$text = file_get_contents('topGoogleTrends2015/movies.txt');
					$movieArray = explode("###", $text);

					$i = 0;

					foreach ($movieArray as $movieString) {
						echo '<div class = "row">';
						$movieArray = explode("///", $movieString);

						$name = $movieArray[0];
						$description = $movieArray[1];
						$graphString = $movieArray[2];
						?>
						<div class = "col-xs-2">
							<div class = "miniPoster">
							<img src="
                    		<?php 
                    		$filename = 'poster/'.normalize($name).'.jpg';
                    		if(file_exists($filename)){
                    			echo $filename;
                    		}
                    		?>
                    		"></img></div>
						</div>

						<div class = "col-xs-4">
							<?php 
							echo '<a class="" href="movieInfo.php?movieId='.str_replace("+", "%2B", urlencode((ucwords($name)))).'">'.ucwords($name).'</a><br>';
							echo "<br>";
							echo $description; 

							?>
						</div>

						<div class = "col-xs-6">
							<script>
							   var testdata<?php echo $i;?> = [
							        {
							            "key" : "Interest" ,
							            "bar": true,
							             "color": "blue",
							            "values" : [ <?php echo $graphString;?>]
							        }
							    ].map(function(series) {
							            series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
							            return series;
							        });
							    //console.log(testdata);
							    var chart;
							    nv.addGraph(function() {
							    var chart = nv.models.multiBarChart();

							    chart.xAxis
							        .tickFormat(function(d) {
							                return d3.time.format('%x')(new Date(d))
							            })
							            .showMaxMin(false);

							    chart.yAxis
							        .tickFormat(d3.format(',.1f'));

							    d3.select('#chart<?php echo $i;?> svg')
							        .datum(testdata<?php echo $i;?>)
							        .transition().duration(500)
							        .call(chart)
							        ;

							    nv.utils.windowResize(chart.update);

							    return chart;
							});
							</script>
							<div id="chart<?php echo $i;?>"  style = "height:180px">
							  <svg></svg>
							</div>

						</div>

					<?php	
					$i++;
					//end foreach
					echo '</div>';
					}
					?>
					
					</ul>
    			</div>


    			<div role="tabpanel" class="tab-pane fade" id="sentiment">
    				<div class = "row">
    					<div class = "col-xs-6">
    							<ul class="list-group">
    								<h3>Highest positive sentiment today</h3>
    								
								<?php 
								//$movie['title'].'<br>'. $movie['description']['description']
								while($row = mysqli_fetch_array($sentRankResultPositive)){
									echo '<li class="list-group-item">';
										echo '<div class = "row">';
											echo '<div class = "col-xs-2">';
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
				                    		"></img></div>
											<?php
											echo '</div>';
											echo '<div class = "col-xs-10">';
											//text
											echo '<a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'">'.$row['name'].'</a><br>';
											echo "Number of positive tweets: ".$row['positive']."<br>";
											echo substr($row['plot'], 0,200)."...";

											echo '</div>';
											
										echo '</div>';
									echo '</li>';
									
								}
								?>
								</ul>
    					</div>
    					<div class = "col-xs-6">
    							<ul class="list-group">
    								<h3>Lowest positive sentiment today</h3>
								<?php 
								//$movie['title'].'<br>'. $movie['description']['description']
								while($row = mysqli_fetch_array($sentRankResultNegative)){
									echo '<li class="list-group-item">';
										echo '<div class = "row">';
											echo '<div class = "col-xs-2">';
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
				                    		"></img></div>
											<?php
											echo '</div>';
											echo '<div class = "col-xs-10">';
											//text
											echo '<a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'">'.$row['name'].'</a><br>';
											echo "Number of negative tweets: ".$row['positive']."<br>";
											echo substr($row['plot'], 0,200)."...";

											echo '</div>';
											
										echo '</div>';
									echo '</li>';
									
								}
								?>
								</ul>
    					</div>
    				</div>
    			</div>



    			<div role="tabpanel" class="tab-pane fade" id="rating">
    				<div class = "row">
    					<div class = "col-xs-6">
    						<h3>Highest average rating</h3>
    							<ul class="list-group">
								<?php 
								//$movie['title'].'<br>'. $movie['description']['description']
								while($row = mysqli_fetch_array($ratingRankResultPositive)){
									echo '<li class="list-group-item">';
										echo '<div class = "row">';
											echo '<div class = "col-xs-2">';
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
				                    		"></img></div>
											<?php
											echo '</div>';
											echo '<div class = "col-xs-10">';
											//text
											echo '<a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'">'.$row['name'].'</a><br>';
											echo "Rating: ".$row['average']."<br>";
											echo substr($row['plot'], 0,200)."...";

											echo '</div>';
											
										echo '</div>';
									echo '</li>';
									
								}
								?>
								</ul>
    					</div>
    					<div class = "col-xs-6">
    						<h3>Lowest average rating</h3>
    							<ul class="list-group">
								<?php 
								//$movie['title'].'<br>'. $movie['description']['description']
								while($row = mysqli_fetch_array($ratingRankResultNegative)){
									echo '<li class="list-group-item">';
										echo '<div class = "row">';
											echo '<div class = "col-xs-2">';
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
				                    		"></img></div>
											<?php
											echo '</div>';
											echo '<div class = "col-xs-10">';
											//text
											echo '<a class="" href="movieInfo.php?movieId='.urlencode($row['movieId']).'">'.$row['name'].'</a><br>';
											echo "Rating: ".$row['average']."<br>";
											echo substr($row['plot'], 0,200)."...";

											echo '</div>';
											
										echo '</div>';
									echo '</li>';
									
								}
								?>
								</ul>
    					</div>
    				</div>
    			</div>


    		</div>
	        </div>
	    </div>
        </section>
 
</div>
<!-- /#wrapper -->

            
<img src="phpjobscheduler/firepjs.php?return_image=1" border="0" alt="phpJobScheduler">

        
	




	<!-- Scrolling Nav JavaScript -->
	
    
    <script src = "js/bootstrap.min.js"></script>

    <script>
    $('.sidebar-nav li').click(function(e) {
    $('.sidebar-nav li.menuActive').removeClass('menuActive');
    var $this = $(this);
    if (!$this.hasClass('menuActive')) {
        $this.addClass('menuActive');
    }
    e.preventDefault();
});
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