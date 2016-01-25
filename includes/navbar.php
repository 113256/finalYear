	<div class = "belowNav">
	<div class = "navbar navbar-default navbar-fixed-top"> <!--navbar-static-top will make it disappear if you scroll horizontally -->
			<div class = "container-wide">
				<!--navbar-brand is used for titles - it has larger text -->
				
				
				
				<!-- button 
				this button will appear if screen collapses (smaller screen) 
				-->
				<button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
				<!--we want button to have an icon -->
				<!-- list of icons (glythicons) here http://getbootstrap.com/components/#glyphicons-glyphs -->
					<span class = "glyphicon glyphicon-list"></span>
				<!-- we can add more glyths on the same button by adding more span tags-->
				</button>
				
				<!-- responsive navbar 
				
				To add the responsive features to the navbar, the content that you
				want to be collapsed needs to be wrapped in a div with classes .collapse, .navbar-collapse. 
				
				3 classes we used 
				(collapse and navbar-collaspse are the same i think)
				navHeaderCollapse is like an id so we will reference it
				-->
					
				<div class = "collapse navbar-collapse navHeaderCollapse">
					<!--navbar-nav gives styling and navbar-right aligns it to the right-->				
					<ul class = "nav navbar-nav navbar-left" style = "font-size:80% !important">
						<!-- add some items -->
						<!-- we add a home button
						but this will disappear if screen is smaller if didn't add a responsive button
						-->
						<!-- active means it will be highlighted in the bar-->
						<li class = "" ><a href = "index.php">Home</a></li>
						<li class = "" ><a href = "movies.php">2015 Films</a></li>
						<li class = "" ><a href = "theatre.php">In Theatres</a></li>
						<li class = "" ><a href = "recent.php">Recently Released</a></li>
						<li class = "" ><a href = "todayShows.php">Recent TV Shows</a></li>
						 <form class="navbar-form navbar-left form-inline" role="search" action = "movieShowtimes.php" method = "get">
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
					          <input name = "postcode" type="text" class="form-control" placeholder="Postcode">
					        </div>
					        <div class="form-group">
					          <input name = "date" type="date" class="form-control">
					        </div>
					        <button type="submit" class="btn btn-default">Display showtimes</button>
					      </form>

						<!--button as dropdown -->
						<!--<li class = "dropdown">
						<!-- b class = "caret" means we put a small arrow next to text to show its a dropdown -->
							<!--<a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">About<b class = "caret"></b></a>
							<!-- dropdown items -->
							<!--<ul class = "dropdown-menu">
								<li><a href = '/about.php'>Why StrengthsFinder</a></li>
								<li><a href = "/strengthsTable.php">Strengths Dictionary</a></li>
								
							</ul>-->
						<!--</li>
						
						
						<!--button as dropdown -->
						
						
						<!--<li><a href = '#'>Contact Us</a></li>-->
					</ul>
				</div>
			
			</div></div></div>
			<!--end of nav bar-->