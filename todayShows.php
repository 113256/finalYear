<?php
require('includes/connect.php');
require('functions/string.php');
require('functions/generateDataLayer.php');

$twoDaysAgoDate = new DateTime('-2 day');
$twoDaysAgoDate= $twoDaysAgoDate->format('Y-m-d ');

$oneDayAgoDate = new DateTime('-1 day');
$oneDayAgoDate= $oneDayAgoDate->format('Y-m-d ');

$today = new DateTime();
$today= $today->format('Y-m-d ');

$query = "SELECT * FROM `tvshow` WHERE 1=1";

if(isset($_GET['day'])){
	//first trim all the excess whitespace
	$day = $_GET['day'];

	switch ($day) {
		case 0:
			$query .= " AND airdate = '$today'";
			break;
		case 1:
			$query .= " AND airdate = '$oneDayAgoDate'";
			break;
		case 2:
			$query .= " AND airdate = '$twoDaysAgoDate'";
			break;
	}
}

$genre="All";

if(isset($_GET['genre'])){
	$genre = $_GET['genre'];
	if($genre != "All"){
		$query .= " AND showGenre LIKE '%$genre%'";
	}
}

$search="";
if(isset($_GET['searchName'])){
	//first trim all the excess whitespace
	$search = $_GET['searchName'];
	$query .= " AND showName LIKE '%$search%'";
}

$view = "list";
if(isset($_GET['view'])){
	//first trim all the excess whitespace
	$view = $_GET['view'];
}

$day="";
if(isset($_GET['day'])){
	//first trim all the excess whitespace
	$day = $_GET['day'];
}

$result = mysqli_query($conn, $query);
$dataLayer = generateDataLayerShow($result, $view, $genre, $search,$day);


mysqli_data_seek($result, 0);

?>


	

<!DOCTYPE html>
<html>
<?php 
require('includes/head.php');
?>


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

            	<br><br><br><br>
                <form class="form" method = "get">
				  <div class="form-group">
				    <input type="text" class="form-control" id="searchNameShow" placeholder="Enter show name">
				  </div>
				  <a style = "curser:pointer" class="btn btn-default" onclick="searchClick(); showSearchEvent()">Search</a>
				</form>	
				<hr>

                <div id = "menu">
                <p>
                        Genre
                </p>	
                <li>
                    <a id="All" onclick = "genreClick(this.id); showGenreEvent(this.id)">All</a>
                </li>
                <li>
                    <a id="Action" onclick = "genreClick(this.id); showGenreEvent(this.id)">Action</a>
                </li>
                <li>
                    <a id="Comedy" onclick = "genreClick(this.id); showGenreEvent(this.id)">Comedy</a>
                </li>
                <li>
                    <a id="Family" onclick = "genreClick(this.id); showGenreEvent(this.id)">Family</a>
                </li>
                <li>
                    <a id="Musical" onclick = "genreClick(this.id); showGenreEvent(this.id)">Musical</a>
                </li>
                <li>
                   <a id="Adventure" onclick = "genreClick(this.id); showGenreEvent(this.id)">Adventure</a>
                </li>
                <li>
                    <a id="Crime" onclick = "genreClick(this.id); showGenreEvent(this.id)">Crime</a>
                </li>
                <li>
                    <a id="Mystery" onclick = "genreClick(this.id); showGenreEvent(this.id)">Mystery</a>
                </li>
                <li>
                    <a id="Fantasy" onclick = "genreClick(this.id); showGenreEvent(this.id)">Fantasy</a>
                </li>
                <li>
                    <a id="Thriller" onclick = "genreClick(this.id); showGenreEvent(this.id)">Thriller</a>
                </li>
                <li>
                    <a id="Sport" onclick = "genreClick(this.id); showGenreEvent(this.id)">Sport</a>
                </li>
                <li>
                    <a id="Animation" onclick = "genreClick(this.id); showGenreEvent(this.id)">Animation</a>
                </li>
                <li>
                    <a id="Documentary" onclick = "genreClick(this.id); showGenreEvent(this.id)">Documentary</a>
                </li>
                <li>
                    <a id="History" onclick = "genreClick(this.id); showGenreEvent(this.id)">History</a>
                </li>
                <li>
                    <a id="Romance" onclick = "genreClick(this.id); showGenreEvent(this.id)">Romance</a>
                </li>
                <li>
                    <a id="War" onclick = "genreClick(this.id); showGenreEvent(this.id)">War</a>
                </li>
                 <li>
                    <a id="Biography" onclick = "genreClick(this.id); showGenreEvent(this.id)">Biography</a>
                </li>
                <li>
                    <a id="Drama" onclick = "genreClick(this.id); showGenreEvent(this.id)">Drama</a>
                </li>
                <li>
                    <a id="Horror" onclick = "genreClick(this.id); showGenreEvent(this.id)">Horror</a>
                </li>
                <li>
                    <a id="Sci-Fi" onclick = "genreClick(this.id); showGenreEvent(this.id)">Sci-Fi</a>
                </li>
                <li>
                    <a id="Western" onclick = "genreClick(this.id); showGenreEvent(this.id)">Western</a>
                </li>
               	</div>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

        	<div style = "margin-top: 50px"></div>
            <div class = "container-fluid" >

					<h2>Recent TV shows</h2>
										
					<p>Selected air date: <?php 

                    			if(isset($_GET['day'])){
								//first trim all the excess whitespace
								$day = $_GET['day'];

								switch ($day) {
									case 0:
										echo "Today ". $today;
										break;
									case 1:
										echo $oneDayAgoDate;
										break;
									case 2:
										echo $twoDaysAgoDate;
										break;
								}
							}
                    		?></p>

                     <div style = "display:inline">
					    <a class = "btn btn-default" id="list" onclick="viewClick(this.id); showViewEvent('list')">List view  <span class = "glyphicon glyphicon-list"></span></a>
					    <a class = "btn btn-default" id="grid" onclick="viewClick(this.id); showViewEvent('grid')">Grid view  <span class = "glyphicon glyphicon-th-large"></span></a>
					</div><br><br>

            		 <a type="" class="btn btn-default" onclick = "today()" id = ""value = ""><?php echo 'Today- '.$today;?></a>
            		 <a type="" class="btn btn-default" onclick = "oneDay()" id = ""value = ""><?php echo $oneDayAgoDate;?></a>
            		 <a type="" class="btn btn-default" onclick = "twoDays()" id = ""value = ""><?php echo $twoDaysAgoDate;?></a>
            		 <br><br>
			
                <div class="row">
                    <div class="col-lg-12">
                    	
                    	<?php 
                    	mysqli_data_seek($result,0);//return to 0th index

                    	if($view=="list"){
                    		echo '<ul class="list-group">';
                    	}

						while ($row = mysqli_fetch_array($result)){
							if($view=="grid"){
	                    	?>
	                         <div class="col-lg-15 col-md-3 col-sm-4 col-xs-6 thumb " >
					            <!--need urlencode because by default "+" is translated to " " in get requests-->
					            <a onclick="showClickEvent('<?php echo $row['showName']; ?>" class="" href="showInfo.php?showName=<?php echo $row['episodeName'];?>">
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
				      		} 
				      	 	else { 
				      	?>

				      		<li class="list-group-item">
								<div class = "row">
									<div class = "col-xs-1">
										<div class = "miniPoster">
										<img src="<?php echo $row['image'];?>"></img></div>
									</div>
									<div class = "col-xs-11">
										Show: <?php echo $row['showName']."<br>"; ?>
										<a onclick="showClickEvent('<?php echo $row['showName']; ?>" class="" href="showInfo.php?showName=<?php echo $row['episodeName'];?>" ><?php echo $row['episodeName']; ?></a><br>
										Genre: <?php echo $row['showGenre']."<br>"; ?>
										<?php echo substr($row['showSummary'], 0,200)."...";?>
									</div>
								</div>
							</li>


				      	
				      	<?php 
				      		}	
				      	}
				        ?>





                       
                    </div>
                </div>
            </div>
      	</div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->




        
	




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

<!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
		

	<script>


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
	   
	</script>

	<script>

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

		function today(){
			var gen = location.search.split('genre=')[1] ? location.search.split('genre=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = removeParam("day", url);
					

					if (url.indexOf('?') > -1){
						altered = altered.concat("&day=0");
					} else {
						altered = altered.concat("?&day=0");
					}
					//alert(altered);
					//append to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("day", url);
					
					altered = altered.concat("&day=0");
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
			

		}
		function oneDay(){
			var gen = location.search.split('genre=')[1] ? location.search.split('genre=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = removeParam("day", url);
					
					if (url.indexOf('?') > -1){
						altered = altered.concat("&day=1");
					} else {
						altered = altered.concat("?&day=1");
					}
					
					//alert(altered);
					//append to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("day", url);
					
					altered = altered.concat("&day=1");
					//alert(altered);
					//append to url
					window.location.href=  altered;
				}
		}
		function twoDays(){
			var gen = location.search.split('genre=')[1] ? location.search.split('genre=')[1] : 'undef';
				if(gen == 'undef'){
					var url = window.location.href;
					var altered = removeParam("day", url);
					
					
					if (url.indexOf('?') > -1){
						altered = altered.concat("&day=2");
					} else {
						altered = altered.concat("?&day=2");
					}
					//alert(altered);
					//append to url
					window.location.href=  altered;
				} else {
					var url = window.location.href;
					var altered = removeParam("day", url);
					
					altered = altered.concat("&day=2");
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

		function searchClick(){
			var searchText = document.getElementById('searchNameShow').value;
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


		//datalayer events

	//window.snowplow('trackStructEvent', 'view', 'showChangeView', '0', {{viewType}}, '0.0');
	function showViewEvent(viewType){
		dataLayer.push({
		  'event': 'showChangeView',
		  'viewType': viewType
		});
	}

	//window.snowplow('trackStructEvent', 'genre', 'showChangeGenre', '0', {{genre}}, '0.0');
	function showGenreEvent(genre){
		dataLayer.push({
		  'event': 'showChangeGenre',
		  'genre': genre
		});
	}

	//window.snowplow('trackStructEvent', 'search', 'showSearchClick', '0', {{searchValue}}, '0.0');
	function showSearchEvent(){
		var searchValue = document.getElementById('searchNameHome').value;
		dataLayer.push({
		  'event': 'showSearchClick',
		  'searchValue': searchValue
		});
	}

	//window.snowplow('trackStructEvent', 'show', 'showInfoClick', '0', {{showName}}, '0.0');
	function showClickEvent(showName){
		var searchValue = document.getElementById('searchNameHome').value;
		dataLayer.push({
		  'event': 'showInfoClick',
		  'showName': showName
		});
	}

	</script>


</body>

</html>