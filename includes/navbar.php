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
						<a class = "navbar-brand">Clueue- Social media metrics for films and movies</a>
						<!-- active means it will be highlighted in the bar-->
						<li class = "" ><a href = "index.php">Films</a></li>

						 <li class = "" ><a onclick = "navClickEvent('recentTvShows')" href = "todayShows.php">Recent TV Shows</a></li>
						 <li class = "" ><a onclick = "navClickEvent('topTrending2015')"href = "toptrending2015.php">Top trending films 2015</a></li>
						 <?php $dateToday = date('Y-m-d');?>
				         <li class = "" ><a onclick = "navClickEvent('movieShowtimes')"href = "movieShowtimes.php?movie=All&postcode=nw1&date=<?php echo $dateToday?>">Showtimes</a></li>
						<!--<li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Movies and shows <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li class = "" ><a href = "todayShows.php">Recent TV Shows</a></li>
				            <li class = "" ><a href = "toptrending2015.php">Top trending films 2015</a></li>
				            <?php $dateToday = date('Y-m-d');?>
				            <li class = "" ><a href = "movieShowtimes.php?movie=All&postcode=nw1&date=<?php echo $dateToday?>">Showtimes</a></li>
				          </ul>
				        </li>-->
						<form class="navbar-form navbar-left form-inline" action = "index.php" method = "get">
						  <div class="form-group">
						    <input type="text" class="form-control" id = "searchNameNavbar" name = "searchNameNavbar" placeholder="Search for movies">
						  </div>
						  <input type="submit" onclick = "navSearchEvent()" class="btn btn-default" value = "Search"></button>
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