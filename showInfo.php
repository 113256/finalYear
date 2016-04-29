<?php 
require('includes/connect.php');
require('functions/string.php');




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

<!DOCTYPE html>
<html>
<?php require('includes/head.php'); ?>
<body>
<script type="text/javascript">
dataLayer = [
				{
		            'episodeName': '<?php echo $showRow['episodeName'];?>',
		            'season': '<?php echo $showRow['season'];?>',
		            'number': '<?php echo $showRow['number'];?>',
		            'airdate': '<?php echo $showRow['airdate'];?>',
		            'airtime': '<?php echo $showRow['airtime'];?>',
		            'airstamp': '<?php echo $showRow['airstamp'];?>',
		            'showRuntime': '<?php echo $showRow['runtime'];?>',
		            'showName': '<?php echo $showRow['showName'];?>',
		            'showType': '<?php echo $showRow['showType'];?>',
		            'showLanguage': '<?php echo $showRow['showLanguage'];?>',
		            'showPremiered': '<?php echo $showRow['showPremiered'];?>',
		            'showAverageRating': '<?php echo $showRow['showAverageRating'];?>',
		            'showGenre': '<?php echo $showRow['showGenre'];?>'
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


<?php require('includes/navbar.php'); ?>

<div id = "background" class = "container-small" style="margin-bottom:45px;" >
<section id = "" class = "">	

	<article>	
		<br><br>
	<div class = "row">

	<!--change to 11 or less whens ad-->
	<div class = "col-xs-12">

		<!--main row excluding ads-->
		<div class = "row">
			<!--movie info excluding twitter feed-->
			<div class = "col-md-12">
				<div class = "row">
					<!--cast poster etc-->
					<div class = "col-md-3">
						<div class= "poster"><img src="<?php echo $image?>" class="img-thumbnail" alt = "<?php echo $urlEpisodeName; ?>"></div>

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
					<div class = "col-md-9">				
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
			
		<!--end main row excluding ads-->
		</div>

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