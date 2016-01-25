<?php


require('includes/connect.php');
require('includes/head.php');









$genre = "";
$movieInfoQueryGen = "SELECT * FROM `movieinfo` WHERE 1=1";

if(isset($_GET['genre'])){
	$genre = $_GET['genre'];
	if($genre != "All"){
		$movieInfoQueryGen .= " AND genre LIKE '%$genre%'";
	}
}

if(isset($_GET['searchName'])){
	//first trim all the excess whitespace
	$search = str_replace(" ", "+", trim($_GET['searchName']));
	$movieInfoQueryGen .= " AND movieId LIKE '%$search%'";
}
		





$genreResult = mysqli_query($conn, $movieInfoQueryGen);








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
					<h1>Find subtitles for the latest movies</h1>
					<p><?php 

					if(isset($_GET['genre'])){
						if($genre!="All"){
							echo $_GET['genre'];
						}
					}
					?></p>
					 
					 <form class="form-inline" action = "movies.php" method = "get">
					 	<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

					 	<!--<form action="index.php" method="get">
						  <input type="submit" name="update" value="Update movies">
						</form>-->

					  <div class="form-group">
					   
					    <input type="text" class="form-control" name = "searchName" placeholder="Search for a movie">
					  </div>
					  <input type="submit" class="btn btn-default" value = "Search"></button>
					</form>


				</div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php 
                        	//if "in theatres" clicked then displayTheatrs.php
                        	require("content/displayMovies.php");

                        ?>		
                       
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

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


</body>

</html>