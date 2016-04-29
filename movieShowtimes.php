
<?php 
	require('includes/simple_html_dom.php');
	require('includes/connect.php');

	require('functions/newMovie.php');

	require('functions/string.php');


	$movie = $_GET['movie'];

	$date = str_replace("-", "", $_GET['date']);
	$postcode = $_GET['postcode'];
	$movieId = str_replace(" ", "+", $movie);
	//echo $movieId;



	$theatreQuery = "SELECT * FROM `intheatres` WHERE 1=1 AND movieId LIKE '%$movieId%'" ;
	$theatreResult = mysqli_query($conn, $theatreQuery) or die(mysqli_error($conn));   
	$row = mysqli_fetch_array($theatreResult);
	//echo $row['code'];
	if($movie == "All"){
		$url = 'http://igoogle.flixster.com/igoogle/showtimes?movie=all&date='.$date.'&postal='.$postcode.'&submit=Go';
	} else {
		$url = 'http://igoogle.flixster.com/igoogle/showtimes?movie='.$row['code'].'&date='.$date.'&postal='.$postcode.'&submit=Go';
	}

	$view = "list";
	if(isset($_GET['view'])){
		$view = $_GET['view'];
	}
	
	//echo $url;

	$html = new simple_html_dom();
	$html->load_file($url);






	
	
	
?>











	

<!DOCTYPE html>
<html>
<?php 	require('includes/head.php'); ?>


<body>

<script type="text/javascript">

dataLayer = [
				{
		            'page': 'showTimes',
		            'movieName': '<?php echo $movie; ?>',
		            'postcode': '<?php echo $postcode; ?>',
		            'date': '<?php echo $date; ?>',
		            'view': '<?php echo $view; ?>'
       			 }
        	];

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

<?php 	require('includes/navbar.php'); ?>

        	<div style = "margin-top: 50px"></div>
            <div class = "container-fluid" >
            <div class = "container-medium">	
					<h2>Showtimes</h2> 
					<p><?php 
							$mtext = ($movie=="All")?"All movies":$movie;
							echo $mtext . " on ".$_GET['date']." at ".$_GET['postcode'];
						?></p>

					
					<form class="navbar-form navbar-left form-inline" role="search" action = "movieShowtimes.php" method = "get">
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
					          <input name = "postcode" type="text" class="form-control" placeholder="Postcode">
					        </div>
					        <div class="form-group">
					          <input name = "date" type="date" class="form-control">
					        </div>
					        <button onclick= "showtimeSearchClick()" type="submit" class="btn btn-default">Display showtimes</button>
					</form><br>
				
					<br><br>
					<div style = "display:inline">
					    <a class = "btn btn-default" id="list" onclick="viewClick(this.id); viewEvent('list')">List view  <span class = "glyphicon glyphicon-list"></span></a>
					    <a class = "btn btn-default" id="grid" onclick="viewClick(this.id); viewEvent('grid')">Grid view  <span class = "glyphicon glyphicon-th-large"></span></a>
					</div>

					
				<?php 
				//no movie specified
				if ($movie == "All"){ 
					?>
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
							 	if($view=="grid"){
							 		//grid
							 		echo '<div class = "col-sm-12"><h3 style = "text-decoration: underline">'.$cinemaAddress.'</h3></div>';
							 	} else {
							 		//list
							 		echo '<h3 style = "text-decoration: underline">'.$cinemaAddress.'</h3>';
							 	}
								
							} else {
								continue;
							}

							if($view!="grid"){
								echo '<ul class="list-group">';
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

									if(empty($showId)){
										continue;
									}


									//movieinfo
									$rowQuery = "SELECT t.*,d.*,l.*,n.*,i.*,a.* FROM `movieinfo` AS i INNER JOIN `tomato` as t on i.movieId=t.movieId INNER JOIN `imdb` as d on i.movieId=d.movieId INNER JOIN `links` as l on i.movieId=l.movieId INNER JOIN `moviename` as n on i.movieId=n.movieId INNER JOIN `averagerating` as a on i.movieId=a.movieId WHERE i.movieId='$showId'";
									$rowResult = mysqli_query($conn, $rowQuery) or die(mysqli_error($conn));
									$row = mysqli_fetch_array($rowResult);

									$filename = 'poster/'.normalize($row['movieId']).'.jpg';
		                    		if(!file_exists($filename)){
		                    			continue;
		                    		}

									if($row == null)
									{	

										//newMovie($showName);
										//echo "doesnt exist";
										continue;

										//STOP THIS because its slow
								
									} 
									

									
							 
							//  echo $average;
				
				  					if($view=="grid"){
									?>
										<div class="col-lg-15 col-md-3 col-sm-4 col-xs-6 thumb " >
											<!--need urlencode because by default "+" is translated to " " in get requests-->
											<a class="" onclick="showtimeEvent(<?php echo $row['name']; ?>)" href="movieInfo.php?movieId=<?php echo urlencode($row['movieId']);?>">
						                    	<img id = "stacked" class="img-responsive   " 
						                    		data-caption="
						                    			<?php 
						                    				echo $row['name'];
						                    				echo '<br>';
						                    				echo $row['genre'];
						                    				echo '<br>';
						                    				echo 'Average Rating:'." ".$row['average'];
						                    				echo '<br>';
						                    				echo 'Showtimes:'." ".$times;
						                    				?>" 
						                    		src="<?php 	                    
						                    			echo $filename;	                    		
						                    		?>" alt="<?php echo $row['name']; ?>" 
						                    		>		           
							                </a>   
										</div>

								  <?php
								  	} else {
								  	?>
								  		<li class="list-group-item">
											<div class = "row">
												<div class = "col-xs-1">
													<div class = "miniPoster">
													<img src="
						                    		<?php 
						                    		$filename = 'poster/'.normalize($row['movieId']).'.jpg';
						                    		if(file_exists($filename)){
						                    			echo $filename;
						                    		}
						                    		?>
						                    		" alt = "<?php echo $row['name']; ?>"></img></div>
											
												</div>
												<div class = "col-xs-11">
													<a class="" href="movieInfo.php?movieId=<?php echo urlencode($row['movieId']);?>" onclick="showtimeEvent(<?php echo $row['name']; ?>)"><?php echo $row['name']; ?></a><br>
													Genre: <?php echo $row['genre']."<br>"; 
													echo 'Showtimes:'." ".$times."<br>";	
													?>
													<?php echo substr($row['plot'], 0,200)."...";?>
												</div>
											</div>
										</li>
								  		

								  	<?php 
								  }
								 //end foreach
								}
								if($view!="grid"){
									echo '</ul>';
								}
							 	

							 }
							 //echo "END SHOWTIMES---------------------------<br>";

							
							 //$i++;
							}

                        ?>		
                       
                    </div>
                </div><?php 


				} else {
				//movie specified

				?>




                <div class="row">
                    <div class="col-lg-12">
                    	<ul class = "list-group">
                      	<?php

						    if($html->find('div[class=theater clearfix]')) {
							 foreach($html->find('div[class=theater clearfix]') as $theater){
							 	?>
							 	<li class="list-group-item">
							 	<?php
								 	$cinemaListing = $theater->outertext;
									//echo $cinemaListing;

									 $cinema = new simple_html_dom();
									 $cinema->load($cinemaListing);


									 $cinemaName = $cinema->find('h2 a', 0)->innertext;//0 = index
									 $cinemaAddress = $cinema->find('h2 span', 0)->innertext;//0 = index

									 //echo "<br>";
									 echo $cinemaName; echo "<br>";
									 echo $cinemaAddress; echo "<br>";

									  foreach($cinema->find('div[class=showtimes clearfix]') as $showtime) {

									 	//echo htmlspecialchars($showtime->outertext); //to print tags as well
									 	//regex
									 	//? means lazy operator ?</div> will find FIRST occurance of </div>
									 	//NOTE [\s\S] doesnt count as index, only (.*) does, so  [\s\S]?</div> = (.*?)</div>
									 	$showtimeRegex= '#(?s)<div class="showtime">(.*?)<\/div>#';
									 	preg_match_all($showtimeRegex, $showtime->outertext, $showtimes, PREG_SET_ORDER);
									 	//print_r($showtimes);

										//echo($showtimes[0][0]);

										$times = $showtimes[0][0];

										//(?<=) is positive lookbehind. it selects all &nbsp ONLY IF the character before it is \d (digit)
										//?= is positive lookahead
										//(?!x) negative lookahead- choose this character IF character in front ISNT x

										$pattern = '#(?<=\d)&nbsp#';
										$replacement = 'pm';
										$times = preg_replace($pattern, $replacement, $times);

										}
									
									echo $times;
									?>
									</li>
									<?php
								 }
							}


							}
                      	?>
                       </ul>
                    </div>
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

			//window.snowplow('trackStructEvent', 'showtime', 'movieShowtimeClick', '0', {{movieId}}, '0.0');
			function showtimeEvent(movieId){
				dataLayer.push({
				  'event': 'movieShowtimeClick',
				  'movieId': movieId
				});
			}

			//window.snowplow('trackStructEvent', 'search', 'showtimeSearchClick', {{date}}, {{searchValue}}, {{postcode}});
			function showtimeSearchClick(){
				var movie = document.getElementById('movie').value;
				var date = document.getElementById('date').value;
				var postcode = document.getElementById('postcode').value;
				dataLayer.push({
				  'event': 'showtimeSearchClick',
				  'movieName': movie,
				  'date': date,
				  'postcode': postcode,

				});
			}

			//window.snowplow('trackStructEvent', 'view', 'changeView', '0', {{viewType}}, '0.0');
			function viewEvent(viewType){
				dataLayer.push({
				  'event': 'changeView',
				  'viewType': viewType
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
				  'event': 'navSearchClick',
				  'searchValue': searchValue
				});
			}
	</script>



</body>

</html>