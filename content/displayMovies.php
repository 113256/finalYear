<?php


		

			mysqli_data_seek($genreResult,0);//return to 0th index
			while ($row = mysqli_fetch_array($genreResult))//redundant
						
				{
					///$movieInfoQuery = "SELECT * FROM `movieinfo` WHERE movieId = '".$row['movieId']."'";
					///$movieInfoResult = mysqli_query($conn, $movieInfoQuery);
					///$movieInfoRow = mysqli_fetch_array($movieInfoResult);

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
							//  echo $average;
				
				  
					?>
					<!--<div class="panel panel-default">
					  <div class="panel-heading" id = "<?php 
					  	$id = str_replace(' ', '-', $row['name']);
					  	echo $id;
					  ?>">
					  <!--need urlencode because by default "+" is translated to " " in get requests-->
					    <!--<h3 class="panel-title"><?php echo$row['name']?> <a class = "btn btn-info btn-lg" href = "movieInfo.php?movieId=<?php echo urlencode($row['movieId']);?>">More info + Subtitles</a></h3>
					  </div>
					  <div class="panel-body">
					    <ul class="list-group">
					      <li class="list-group-item">Genre: <?php echo $movieInfoRow['genre']?></li>
						  <li class="list-group-item">Average Rating: <?php echo $average?></li>
						  <li class="list-group-item">Plot: <?php 

						  echo substr($movieInfoRow['plot'], 0, 150)."...";
						  ?>

						</li>
						</ul>
					  </div>
					</div>-->



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
	                    		src="
	                    		<?php 
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
				} ?>