<?php


require('includes/connect.php');
require('includes/head.php');
require('includes/string.php');

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



if(isset($_GET['genre'])){
	$genre = $_GET['genre'];
	if($genre != "All"){
		$query .= " AND showGenre LIKE '%$genre%'";
	}
}

if(isset($_GET['searchName'])){
	//first trim all the excess whitespace
	$search = $_GET['searchName'];
	$query .= " AND showName LIKE '%$search%'";
}



$result = mysqli_query($conn, $query);

?>


	


<html>
<?php 
require('includes/navbar.php');


?>


<body>
	

	<div id="wrapper">
	
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
          <?php require("content/filterForm.php");?>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

        	<div style = "margin-top: 50px"></div>
            <div class = "container-fluid" >
            	<div class = "jumbotron">

					<h1>Subtitles for TV shows that recently aired</h1>
					 <form class="form-inline" action = "todayShows.php" method = "get">
					 	<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

					 	<!--<form action="index.php" method="get">
						  <input type="submit" name="update" value="Update movies">
						</form>-->

					  <div class="form-group">
					   
					    <input type="text" class="form-control" name = "searchName" placeholder="Search for shows">
					  </div>
					  <input type="submit" class="btn btn-default" value = "Search"></button>
					</form>
					 
					
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
                    		 <a type="" class="btn btn-default" onclick = "today()" id = ""value = ""><?php echo 'Today- '.$today;?></a>
                    		 <a type="" class="btn btn-default" onclick = "oneDay()" id = ""value = ""><?php echo $oneDayAgoDate;?></a>
                    		 <a type="" class="btn btn-default" onclick = "twoDays()" id = ""value = ""><?php echo $twoDaysAgoDate;?></a>

				</div>
                <div class="row">
                    <div class="col-lg-12">
                    	
                    	<?php 
                    	mysqli_data_seek($result,0);//return to 0th index
						while ($row = mysqli_fetch_array($result)){
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
					

					if (altered.slice(-1)=='?'){
						altered = altered.concat("day=0");
					} else {
						altered = altered.concat("?day=0");
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
					
					if (altered.slice(-1)=='?'){
						altered = altered.concat("day=1");
					} else {
						altered = altered.concat("?day=1");
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
					
					
					if (altered.slice(-1)=='?'){
						altered = altered.concat("day=2");
					} else {
						altered = altered.concat("?day=2");
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
	</script>


</body>

</html>