
<html>
<?php require('includes/head.php');
require('includes/connect.php');
require('includes/navbar.php');
require('includes/string.php');




$urlEpisodeName = $_GET['showName'];

$showQuery = "SELECT * FROM `tvshow` WHERE episodeName = '".$urlEpisodeName."'";
$showResult = mysqli_query($conn, $showQuery);
$showRow = mysqli_fetch_array($showResult);

$date = date(('Y-m-d'));





//episode
$episodeName = $showRow['episodeName'];
$season = $showRow['season'];
$number = $showRow['number'];
$airdate = $showRow['airdate'];
$airtime = $showRow['airtime'];
$airstamp = $showRow['airstamp'];
$runtime = $showRow['runtime'];
$episodeSummary = $showRow['episodeSummary'];


//show info
$showName= $showRow['showName'];
$subtitleLink = $showRow['subtitleLink'];
$showType= $showRow['showType'];
$showLanguage= $showRow['showLanguage'];
$showPremiered = $showRow['showPremiered'];
$showAverageRating = $showRow['showAverageRating'];
$showGenre = $showRow['showGenre'];
$image = $showRow['image'];
$showSummary = $showRow['showSummary'];
	   
    
    


?>

<body>

<div id = "background" class = "container-small" style="margin-bottom:45px;" >
<section id = "" class = "">	

	<article>	
	<!--<div class = "jumbotron">
		<h1>ad</h1>
	</div>-->


	<div class="btn-group" role="group" aria-label="...">
	 <a href = "<?php echo $subtitleLink?>" class="btn btn-primary btn-lg">Subtitles</a>
	</div>
	
	

	


	<div class = "row">

	<!--change to 11 or less whens ad-->
	<div class = "col-xs-12">
	<div class="jumbotron">


		<!--main row excluding ads-->
		<div class = "row">
			<!--movie info excluding twitter feed-->
			<div class = "col-md-9">
				<div class = "row">
					<!--cast poster etc-->
					<div class = "col-md-5">
						<div class= "poster"><img src="<?php echo $image?>" class="img-thumbnail"></div>

						<br>
						<div class="panel panel-default">
							  <div class="panel-body">
						  <table class="table table-hover table-condensed">
			 	 			<tr  class = "active"><td><?php echo "S".$season."E".$number; ?></td><td> </td></tr>				  
							  <tr  class = "active"><td>Airdate</td><td><?php echo $airdate?></td></tr>
							  <tr><td>Air time</td><td><?php echo $airtime;?></td></tr>
							  <tr><td>Air stamp</td><td><?php echo $airstamp; ?></td></tr>
							  <tr><td>Run time</td><td><?php  echo $runtime." min";?></td></tr>
							</table>
						</div></div>
				
					<!--end cast poster etc-->
					</div>
					<!--ratings etc-->
					<h2><?php echo $episodeName."    -".$showName."   -S".$season."E".$number?></h2>
					<div class = "col-md-7">				
						<div class="panel panel-default">
								<div class="panel-heading">Episode summary</div>
							  <div class="panel-body" >  
								<p ><?php echo $episodeSummary?></p>
							  </div>
							</div>


							<div class="panel panel-default">
							  <div class="panel-body">
						  <table class="table table-hover table-condensed">
			 	 			<tr class = "active"><td>Show name</td><td><?php echo $showName; ?></td></tr>				  
							  <tr ><td>Genre</td><td><?php echo $showGenre?></td></tr>
							  <tr><td>Premiered date</td><td><?php echo $showPremiered;?></td></tr>
							  <tr><td>Language</td><td><?php echo $showLanguage; ?></td></tr>
							  <tr><td>Average rating</td><td><?php echo $showAverageRating; ?></td></tr>
							  <tr><td>Type</td><td><?php  echo $showType;?></td></tr>			
							</table>
						</div></div>


						<div class="panel panel-default">
								<div class="panel-heading">Show summary</div>
							  <div class="panel-body" >  
								<p ><?php echo $showSummary?></p>
							  </div>
							</div>

					
								
					<!--end ratings etc-->	
					</div>
				</div>
				

				
		
			<!--end movie info excluding twitter feed-->	
			</div>
			<!--twitter feed-->
			<div class = "col-md-3">
				<div id="zrotate"></div>
			<!--end twitter feed-->	
			</div>
		<!--end main row excluding ads-->
		</div>

	</div><!--end jumbotron-->
	<!--jumbotron row (currently 12 but 11 with ads)-->
	</div>

	<!--ad-->
	<!--<div class = "col-xs-1"></div>-->

	</div><!--end full row-->
	
	</article>
	</section>
</div>








<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.zrssfeed.js" type="text/javascript"></script>
<script src="js/zframework.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {

	var url = "<?php echo 'https://queryfeed.net/tw?q=%23'.str_replace(" ", "", $showName) ?>";
	console.log(url);
	$('#zticker').rssfeed(url,{
		header: false,
		titletag: 'div',
		date: false,
		content: false
	}, function(e) {
		$.zazar.ticker({selector: '#zticker ul'});
	});

	$('#zslider').rssfeed(url,{
		header: false,
		titletag: 'div',
		date: false,
		content: false,
		limit: 5
	}, function(e) {
		$.zazar.slider({selector: '#zslider ul'});
	});

	$('#zrotate').rssfeed(url,{
		limit: 10
	}, function(e) {
		$.zazar.rotate({selector: '#zrotate ul'});
	});


	$('#test').rssfeed(url);

});
</script>

		<!-- jquery-->
		
		<!-- javascript-->
		<script src = "js/bootstrap.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		
		<!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

</body>
</html>