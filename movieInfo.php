<?php 
require('includes/connect.php');
require('functions/string.php');
require("functions/chartData.php");
require("functions/generateDataLayer.php");

$unwantedChars = array(',', '!', '?', "'", " ", ":", "+");

$movieId = mysqli_real_escape_string($conn,$_GET['movieId']);
//echo $movieId;
//$averageRatingQuery = "SELECT average FROM `averagerating` WHERE movieId = '$movieId'";

$movieInfoQuery = "SELECT t.*,d.*,l.*,n.*,i.*,a.* FROM `movieinfo` AS i INNER JOIN `tomato` as t on i.movieId=t.movieId INNER JOIN `imdb` as d on i.movieId=d.movieId INNER JOIN `links` as l on i.movieId=l.movieId INNER JOIN `moviename` as n on i.movieId=n.movieId INNER JOIN `averagerating` as a on i.movieId=a.movieId WHERE i.movieId='$movieId'";
$movieInfoResult = mysqli_query($conn, $movieInfoQuery) or die(mysqli_error($conn)); 
$movieInfoRow = mysqli_fetch_array($movieInfoResult);

$dataLayer = generateDataLayerMovie($movieInfoRow);


mysqli_data_seek($movieInfoResult,0);
?>


<!DOCTYPE html>
<html>
<?php require('includes/head.php'); ?>
<body >

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
<div id = "" style="margin-bottom:45px;" >
	
<div id="wrapper" style = "padding-left: 300px;">

        <!-- Sidebar -->
        <div id="sidebar-wrapper" style = "width: 300px; padding-left: 15px;">
            <ul class="sidebar-nav">
            	<br>
                <h3><?php echo $movieInfoRow['name']; ?></h3>
                <div class= "poster"><img src="<?php 
        		$filename = 'poster/'.normalize($movieId).'.jpg';
        		if(file_exists($filename)){
        			echo $filename;
        		}
        		?>
        		" alt = "<?php echo $movieInfoRow['name']; ?>" class="img-thumbnail"></div>
                <li>
                    <a href="#trends" onclick= "infoCategoryEvent('trends')" role="tab" data-toggle="tab">Trends <span class="glyphicon glyphicon-play"></span></a>
                </li>
                <li>
                    <a href="#general" onclick= "infoCategoryEvent('general')" role="tab" data-toggle="tab">General information <span class="glyphicon glyphicon-play"></span></a>
                </li>
                <li>
                    <a href="#social" onclick= "infoCategoryEvent('socialMedia')" role="tab" data-toggle="tab">Social media <span class="glyphicon glyphicon-play"></span></a>
                </li>
                <br><br>
                <li class="sidebar-brand">
                    <a href="#">
                       Links
                    </a>
                </li>
                <li>
                    <a id = "imdb" onclick="linkEvent(this.id)"  href="<?php echo $movieInfoRow['imdbLink'];?>" >IMDB</a>
                </li>
                <li>
                    <a id = "tmdb" onclick="linkEvent(this.id)"href="<?php echo $movieInfoRow['tmdbLink'];?>" >The movie database</a>
                </li>
                <li>
                    <a id = "rottenTomatoes" onclick="linkEvent(this.id)" href="<?php echo $movieInfoRow['tomatoLink'];?>" >Rotten tomatoes</a>
                </li>
                <li>
                    <a id = "subtitle" onclick="linkEvent(this.id)" href="<?php echo $movieInfoRow['subtitleLink'];?>">Download subtitles</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        
            	<section class = "bg-white" style = "padding-left:20px; padding-right:10px" >
            		<div class="row">
            			<div class="col-lg-12">
	            		<div class="tab-content">
	            		<br><br>
	            		<div role="tabpanel" class="tab-pane fade" id="trends">
	            			<div class = "row">
	            				<div class = "col-xs-6">
	            					<div class = "row" style = "padding-left:20px">
	            						<h4>Interest over time (past 12 months)</h4>
	            						<script type="text/javascript"
										src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $movieInfoRow['name'];?>&date=today%2012-m&w=600&h=400&cid=TIMESERIES_GRAPH_0">
										</script>
	            					</div>
	            					<div class = "row" style = "padding-left:20px">
	            						<h4>Related searches</h4>
	            						<div class = "col-xs-6">
	            							<script type="text/javascript"
											src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $movieInfoRow['name'];?>&date=today%2012-m&w=350&h=400&cid=TOP_QUERIES_0_0 ">
											</script>
											</script>
	            						</div>
	            						<div class = "col-xs-6">
	            							<script type="text/javascript"
											src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $movieInfoRow['name'];?>&date=today%2012-m&w=350&h=400&cid=TOP_ENTITIES_0_0 ">
											</script>
											</script>
	            						</div>
	            					</div>
	            				</div>
	            				<div class = "col-xs-6">
	            					<h4>Regional interest</h4>
	            					<script type="text/javascript"
								src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $movieInfoRow['name'];?>&date=today%2012-m&w=700&h=400&cid=GEO_MAP_0_0">
								</script>
								<script type="text/javascript"
								src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $movieInfoRow['name'];?>&date=today%2012-m&w=700&h=400&cid=GEO_TABLE_0_0">
								</script>
	            				</div>
	            			</div>
	            		</div>

	            		<div role="tabpanel" class="tab-pane fade" id="general">
	            			
	            				<div class = "">
									<div class = "">
										<div class = "row rotten">
											<div class = "col-xs-6">
												<p>Tomatometer</p>	
												<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $movieInfoRow['tomatoMeter']?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $movieInfoRow['tomatoMeter']?>%;"><?php echo $movieInfoRow['tomatoMeter']?>%</div>
												</div>
												<p >Average rating: <?php if(IsEmpty($movieInfoRow['tomatoRating'])){
													echo 'N/A';
												}else {echo $movieInfoRow['tomatoRating'].'/10';}
												?>
												</p>
												  <p >Reviews: <?php echo $movieInfoRow['tomatoReviews']?></p>
												  <p >Fresh: <?php echo $movieInfoRow['tomatoFresh']?></p>
												  <p >Rotten: <?php echo $movieInfoRow['tomatoRotten']?></p>
											</div>
											<div class = "col-xs-6">
													<p>Audience Score</p>	
												<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $movieInfoRow['tomatoUserMeter']?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $movieInfoRow['tomatoUserMeter']?>%;"><?php echo $movieInfoRow['tomatoUserMeter']?>%</div>
												</div>
												<p>Average Rating: <?php if(IsEmpty($movieInfoRow['tomatoUserRating'])){
													echo 'N/A';
												}else {echo $movieInfoRow['tomatoUserRating'].'/5';}?></p>
												 <p>Reviews: <?php echo $movieInfoRow['tomatoUserReviews']?></p>
											</div>
											
										</div>
									</div>
								</div>
								<hr style="border: 1px outset #595955;">

								<div class = "row">
									<div class = "col-xs-6">
										<?php echo $movieInfoRow['plot']?>	

										<table class="table table-hover table-condensed">
				 	 						<tr><td>Rated</td><td> <?php echo $movieInfoRow['rated']?></li></td></tr>
											<tr><td>Run time</td><td><?php echo $movieInfoRow['runtime']?></li></td></tr>
											<tr><td>Genre</td><td><?php echo $movieInfoRow['genre']?></li></td></tr>
											<tr><td>Awards</td><td><?php echo $movieInfoRow['awards']?></li></td></tr>
											<tr><td>Box Office</td><td><?php echo $movieInfoRow['boxOffice']?></li></td></tr>
											<tr><td>Website</td> <td><a href="<?php 
									  if ($movieInfoRow['Website']=="N/A" ) echo "#"; else 
									  echo $movieInfoRow['Website']?>"><?php echo $movieInfoRow['Website']?></a></td></tr>
											<tr><td>Release Date</td><td><?php echo $movieInfoRow['releaseDate']?></li></td></tr>
					 	 					<tr><td>Country</td><td><?php echo $movieInfoRow['country']?></li></td></tr>
					 	 					<tr><td>Language</td><td><?php echo $movieInfoRow['language']?></li></td></tr>
										</table>

									</div>
									<div class = "col-xs-6">

										<table class="table table-hover table-condensed">
						 	 				<tr  class = "active"><td>Total Weighted Average Rating (Metacritic, IMDB Rotten Tomatoes)</td><td> 
						 	 				<?php 
						 	 				
										  echo $movieInfoRow['average'];
										  ?></td></tr>
										  
										  <tr  class = "active"><td>IMDb</td><td></td></tr>
										  <tr><td>ID</td><td><?php echo $movieInfoRow['imdbID']?></td></tr>
										  <tr><td>Rating</td><td><?php echo $movieInfoRow['imdbRating']?></td></tr>
										  <tr><td>Votes</td><td><?php echo $movieInfoRow['imdbVotes']?></td></tr>
										  <tr  class = "active"> <td>Metacritic score</td><td><?php echo $movieInfoRow['metaCriticScore']?></td></tr>
										</table>

										<table class="table table-hover table-condensed">
				 	 						<tr><td>Director</td><td> <?php echo $movieInfoRow['director']?></li></td></tr>
											<tr><td>Writer</td><td><?php echo $movieInfoRow['writer']?></li></td></tr>
											<tr><td>Cast</td><td><?php echo $movieInfoRow['actors']?></li></td></tr>
										</table>
									</div>
								</div>
								
								<?php 
								$screenshotList = $movieInfoRow['Screenshots'];
								$temp = explode(" ", $screenshotList);//split subtitles
								array_pop($temp);//remove last element as its a " "
								?>
								<div class = "row screenshots" style = "margin-top: 20px">
								<?php foreach ($temp as $value) { //echo "aaa ".$value; ?>
									<div class = "col-lg-4">
									<img src = "<?php echo $value; ?>" ></img></div>
									<?php } ?>

								</div>

								<br>
								<div class = "fluidMedia">
									<?php if($movieInfoRow['youtubeLink']!=null){?>
									<iframe style = " display:block; width:90%; height:80%;" src="<?php 
										$noHttps = str_replace("https","http",$movieInfoRow['youtubeLink']);
										$embed = str_replace("watch?v=", "embed/", $noHttps);
										echo $embed;?>"
										>
									</iframe>
									<?php } ?>	
								</div>
								
	            		</div>

	            		<div role="tabpanel" class="tab-pane fade in active" id="social">

	            			<div class = "row">
	            				<div class = "col-xs-5">
	            					<!--ratings chart-->
									<div class="panel panel-default">
									  <div class="panel-heading">
									    <h3 class="panel-title">Ratings and votes over time</h3>
									  </div>
									  <div class="panel-body">
											<div id="chart1"  style = "height:300px">
											  <svg></svg>
											</div>
									  </div>
									</div>

			            		</div>
	            				<div class = "col-xs-7">
	            					<div class="panel panel-default">
									  <div class="panel-heading">
									    <h3 class="panel-title">Twitter Sentiment</h3>
									  </div>
									  <div class="panel-body">   
											<div id="chart2"  style = "height:300px">
											  <svg></svg>
											</div>
									  </div>
									</div>
	            				</div>
	            			</div>
	            			
							
							 <div class = "row">
							 	<div class = "col-lg-50">
							 		<div id="cloud" style="width: 750px; height: 350px;"></div>
							 	</div>
							 	<div class = "col-lg-50">
							 		<div id="zrotate" style = "margin-right:10px"></div>
							 	</div>
							 </div>
							
							  
								
						</div>
	            		

	            		</div>
	                    </div>
	                </div>
            	</section>
 
    </div>
    <!-- /#wrapper -->

	
	

		








<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.zrssfeed.js" type="text/javascript"></script>
<script src="js/zframework.js" type="text/javascript"></script>

<script src="js/jqcloud.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="js/nv.d3.min.js"></script>


<script>
    $('.sidebar-nav li').click(function(e) {
    $('.sidebar-nav li.menuActive').removeClass('menuActive');
    var $this = $(this);
    if (!$this.hasClass('menuActive')) {
        $this.addClass('menuActive');
    }
    e.preventDefault();
});
    </script>

<script>

	<?php 
		printWordCloud(normalize($movieId));
	?>
	console.log(words);
	$(function() {
        // When DOM is ready, select the container element and call the jQCloud method, passing the array of words as the first argument.
        $("#cloud").jQCloud(words);
      });
</script>

<script type="text/javascript">
$(document).ready(function () {

	var url = "<?php echo 'https://queryfeed.net/tw?q=%23'.normalize($movieInfoRow['movieId']); ?>";
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
		limit: 30
	}, function(e) {
		$.zazar.rotate({selector: '#zrotate ul'});
	});


	$('#test').rssfeed(url);

});
</script>


<!--newer ratings using nvd3-->



<script>
   var testdata1 = [
        {
            "key" : "Rating" ,
            "color" : "#333",
            "values" : [ <?php printChartData(1, $movieInfoRow['imdbID']);?>]
        },
        {
            "key" : "Votes" ,
            "bar": true,
            "color": "#ccf",
            "values" : [ <?php printChartData(0, $movieInfoRow['imdbID']);?>]
        }
    ].map(function(series) {
            series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
            return series;
        });
    //console.log(testdata1);
    var chart;
    nv.addGraph(function() {
        chart = nv.models.linePlusBarChart()
            .margin({top: 50, right: 80, bottom: 30, left: 80})
            .legendRightAxisHint(' [Line]')
            .forceY([0,10])
            .color(d3.scale.category10().range());
        chart.xAxis.tickFormat(function(d) {
                return d3.time.format('%x')(new Date(d))
            })
            .showMaxMin(false).axisLabel("Date");
        chart.y1Axis.tickFormat(function(d) { return d3.format(',f')(d) }).axisLabel("Votes (bar)");
        chart.y2Axis.axisLabel("Rating (Line)");
        chart.bars.forceY([0]).padData(false);

        d3.select('#chart1 svg')
            .datum(testdata1)
            .transition().duration(500).call(chart);
        nv.utils.windowResize(chart.update);
        chart.dispatch.on('stateChange', function(e) { nv.log('New State:', JSON.stringify(e)); });
        return chart;
    });
</script>



<script>
/*
	,{
            "key" : "Tweet count" ,
            "bar": true,
             "color": "#ccf",
            "values" : [ <?php printSentiment(3, normalize($nameRow['name']));?>]
        }
*/
   var testdata = [
        {
            "key" : "Positive" ,
            "bar": true,
             "color": "blue",
            "values" : [ <?php printSentiment(0, normalizeCaseSen($movieInfoRow['name']));?>]
        },
        {
            "key" : "Negative" ,
            "bar": true,
            "color" : "red",
            "values" : [ <?php printSentiment(1, normalizeCaseSen($movieInfoRow['name']));?>]
        },{
            "key" : "Neutral" ,
            "bar": true,
             "color": "#ccf",
            "values" : [ <?php printSentiment(2, normalizeCaseSen($movieInfoRow['name']));?>]
        }
    ].map(function(series) {
            series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
            return series;
        });
    console.log(testdata);
    var chart;
    nv.addGraph(function() {
    var chart = nv.models.multiBarChart();

    chart.xAxis
        .tickFormat(function(d) {
                return d3.time.format('%x')(new Date(d))
            })
            .showMaxMin(false);

    chart.yAxis
        .tickFormat(d3.format(',.1f'));

    d3.select('#chart2 svg')
        .datum(testdata)
        .transition().duration(500)
        .call(chart)
        ;

    nv.utils.windowResize(chart.update);

    return chart;
});
</script>

<script type="text/javascript">
//datalayer events

////window.snowplow('trackStructEvent', 'link', 'linkClick', {{movieId}}, {{link}}, '0.0');
function linkEvent(link){
	dataLayer.push({
	  'event': 'linkClick',
	  'movieId': '<?php echo mysqli_real_escape_string($conn,$movieInfoRow['movieId']);?>',
	  'link': link
	});
}

////window.snowplow('trackStructEvent', 'category', 'changeInformationCategory', {{movieId}}, {{infoCategory}}, '0.0');
function infoCategoryEvent(category){
	dataLayer.push({
	  'event': 'changeInformationCategory',
	  'movieId': '<?php echo mysqli_real_escape_string($conn,$movieInfoRow['movieId']);?>',
	  'infoCategory': category
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
	  'event': 'searchClick',
	  'searchValue': searchValue
	});
}

</script>






		<!-- jquery-->
		
		<!-- javascript-->
		<script src = "js/bootstrap.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		
		<!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

</body>
</html>