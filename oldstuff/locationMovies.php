
<?php 
	require('includes/simple_html_dom.php');


	$date = str_replace("-", "", $_GET['date']);
	$postcode = $_GET['postcode'];

	$scrapeUrl = 'http://igoogle.flixster.com/igoogle/showtimes?movie=all&date='.$date.'&postal='.$postcode.'&submit=Go';
	//echo $scrapeUrl;
	$year = 2015;
	//USE DOM PARSER AS THERE ARE NESTED DIVS!
	











	    //global $cinemas;
	    $html = new simple_html_dom();
	    $html->load_file($scrapeUrl);
	 

	   
	
	


?>











	

<!DOCTYPE html>
<html>
<?php 
require('includes/connect.php');
require('includes/head.php');
require('includes/newMovie.php');
require('includes/navbar.php');
require('includes/string.php');
?>


<body>

        	<div style = "margin-top: 50px"></div>
            <div class = "container-fluid" >
            	<div class = "jumbotron">
					<h1>Find subtitles for the latest movies</h1>
				</div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php 
    						
							foreach($html->find('div[class=theater clearfix]') as $theater) {
							 //echo $i . "<br>";
							 $cinemaListing = $theater->outertext;
							 //echo $cinemaListing;

							 $cinema = new simple_html_dom();
							 $cinema->load($cinemaListing);


							 $cinemaName = $cinema->find('h2 a', 0)->innertext;//0 = index
							 $cinemaAddress = $cinema->find('h2 span', 0)->innertext;//0 = index

							 if($cinema->find('div[class=showtimes clearfix]')){
							 ?>
							 <div class = "jumbotron col-sm-12">
								<h3><?php echo $cinemaAddress;?></h3>
							</div>

							 <?php
							}

							 // echo "address   ".$cinemaAddress;
							 //echo "SHOWTIMES---------------------------<br>";
							 foreach($cinema->find('div[class=showtimes clearfix]') as $showtime) {

							 	//echo htmlspecialchars($showtime->outertext); //to print tags as well
							 	//regex
							 	//? means lazy operator ?</div> will find FIRST occurance of </div>
							 	//NOTE [\s\S] doesnt count as index, only (.*) does, so  [\s\S]?</div> = (.*?)</div>
							 	$showtimeRegex= '#<div class="showtime">[\s\S]*?title="(.*?)"[\s\S]*?<\/h3>(.*?)<\/div>#';
							 	preg_match_all($showtimeRegex, $showtime->outertext, $showtimes, PREG_SET_ORDER);
							 	//print_r($showtimes);

							 
							 	foreach($showtimes as $show)
								{

									$times = $show[2];

									//(?<=) is positive lookbehind. it selects all &nbsp ONLY IF the character before it is \d (digit)
									//?= is positive lookahead
									//(?!x) negative lookahead- choose this character IF character in front ISNT x

									$pattern = '#(?<=\d)&nbsp#';
									$replacement = 'pm';
									$times = preg_replace($pattern, $replacement, $times);
									//$times = str_replace('&nbsp', "pm", (trim($show[2])));
									//$timesArray = explode(" ", trim($show[2]));
									//$unwantedChars = array(',', '!', '?', "'"); // create array with unwanted chars

									

									$showName = $show[1];
									$showId = str_replace(" ", "+", $showName);
									$movieNameQuery = "SELECT * FROM `moviename` WHERE movieId = '".$showId."'";
									$movieNameResult = mysqli_query($conn, $movieNameQuery);
									$movieNameRow = mysqli_fetch_array($movieNameResult);
								   // echo  "show ". $j ." ".$show[2]."<br>";
								   // echo  "show ". $j ." ".$show[1]."<br>";
									//echo $showName . $movieNameRow['movieId'];

									if($movieNameRow == null)
									{
										//echo "sadadsa";
										//continue;
										newMovie($showName);
									} 

									

									//movieinfo
									$rowQuery = "SELECT * FROM `movieinfo` WHERE movieId = '".$showId."'";
									$rowResult = mysqli_query($conn, $rowQuery);
									$row = mysqli_fetch_array($rowResult);

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
							 
							//  echo $average;
				
				  
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
					                    				echo '<br>';
					                    				echo 'Showtimes:'." ".$times;
					                    				?>" 
					                    		src="<?php echo $row['poster']; ?>" alt="" 
					                    		>		           
						                </a>   
									</div>

								  <?php
								}

							 	

							 }
							 //echo "END SHOWTIMES---------------------------<br>";

							
							 //$i++;
							}

                        ?>		
                       
                    </div>
                </div>
            </div>
   



    <!--uncomment in server-->    
	<!--<img src="phpjobscheduler/firepjs.php?return_image=1" border="0" alt="phpJobScheduler">-->





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