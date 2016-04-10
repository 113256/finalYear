
<html>
<?php require('includes/head.php');
require('includes/connect.php');
require('includes/navbar.php');
require('includes/string.php');
require("includes/chartData.php");

$unwantedChars = array(',', '!', '?', "'", " ", ":", "+");

$movieId = $_GET['movieId'];
echo $movieId;


$movieInfoQuery = "SELECT * FROM `movieinfo` WHERE movieId = '".$movieId."'";
$movieInfoResult = mysqli_query($conn, $movieInfoQuery);
$movieInfoRow = mysqli_fetch_array($movieInfoResult);

$tomatoQuery = "SELECT * FROM `tomato` WHERE movieId = '".$movieId."'";
$tomatoResult = mysqli_query($conn, $tomatoQuery);
$tomatoRow = mysqli_fetch_array($tomatoResult);


$imdbQuery = "SELECT * FROM `imdb` WHERE movieId = '".$movieId."'";
$imdbResult = mysqli_query($conn, $imdbQuery);
$imdbRow = mysqli_fetch_array($imdbResult);

$linkQuery = "SELECT * FROM `links` WHERE movieId = '".$movieId."'";
$linkResult = mysqli_query($conn, $linkQuery);
$linkRow = mysqli_fetch_array($linkResult);

$nameQuery = "SELECT * FROM `moviename` WHERE movieId = '".$movieId."'";
$nameResult = mysqli_query($conn, $nameQuery);
$nameRow = mysqli_fetch_array($nameResult);

?>

<body>





	


		



<div id = "background" class = "container-small" style="margin-bottom:45px;" >
<section id = "" class = "">	

	<article>	
	<!--<div class = "jumbotron">
		<h1>ad</h1>
	</div>-->


	<div class="btn-group" role="group" aria-label="...">
	   <a href = "<?php echo $linkRow['imdbLink'];?>" class="btn btn-primary btn-lg">IMDb</a>
	   <a href = "<?php echo $linkRow['tmdbLink'];?>" class="btn btn-primary btn-lg">The movie db</a>
	 <a href = "<?php echo $linkRow['tomatoLink'];?>" class="btn btn-primary btn-lg">Rotten Tomatoes</a>
	 <a href = "<?php echo $linkRow['subtitleLink']?>" class="btn btn-primary btn-lg">Subtitles</a>
	</div>
	
	

	


	<div class = "row">

	<!--change to 11 or less whens ad-->
	<div class = "col-xs-12">
	<div class="jumbotron">


		<!--main row excluding ads-->
		<div class = "row">
			<!--movie info excluding twitter feed-->
			<div class = "col-md-8">
				<div class = "row">
					<!--cast poster etc-->
					<div class = "col-md-5">
						<div class= "poster"><img src="<?php 
                    		$filename = 'poster/'.normalize($movieId).'.jpg';
                    		if(file_exists($filename)){
                    			echo $filename;
                    		}
                    		?>
                    		" class="img-thumbnail"></div>

						<br>
						<div class="panel panel-default">
							  <div class="panel-body">
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
							</div>		

						<div class="panel panel-default">
						  <div class="panel-body">
						  	<table class="table table-hover table-condensed">
		 	 						<tr><td>Director</td><td> <?php echo $movieInfoRow['director']?></li></td></tr>
									<tr><td>Writer</td><td><?php echo $movieInfoRow['writer']?></li></td></tr>
									<tr><td>Cast</td><td><?php echo $movieInfoRow['actors']?></li></td></tr>

							</table>
						  </div>
						</div>
					<!--end cast poster etc-->
					</div>
					<!--ratings etc-->
					<h2><?php echo $nameRow['name'];?></h2>
					<div class = "col-md-7">
							<div class="panel panel-default">
							  <div class="panel-body">  
								<?php echo $movieInfoRow['plot']?>
							  </div>
							</div>
							
							<div class="panel panel-default">
							  <div class="panel-body">
						  <table class="table table-hover table-condensed">
			 	 				<tr  class = "active"><td>Average Rating</td><td> 


			 	 				<?php 


			 	 				$averageRatingQuery = "SELECT average FROM `averagerating` WHERE movieId = '$movieId'";
								$averageRatingResult = mysqli_query($conn, $averageRatingQuery);
								$averageRatingRow = mysqli_fetch_array($averageRatingResult);
								$average = $averageRatingRow['average'];
							 	
							  echo $average;
							  ?></td></tr>
							  
							  <tr  class = "active"><td>IMDb</td><td></td></tr>
							  <tr><td>ID</td><td><?php echo $imdbRow['imdbID']?></td></tr>
							  <tr><td>Rating</td><td><?php echo $imdbRow['imdbRating']?></td></tr>
							  <tr><td>Votes</td><td><?php echo $imdbRow['imdbVotes']?></td></tr>
							  <tr  class = "active"> <td>Metacritic score</td><td><?php echo $imdbRow['metaCriticScore']?></td></tr>
							</table>
						</div></div>

						<div class = "panel panel-default">
							<div class = "panel-body">
								<div class = "row rotten">
									<div class = "col-xs-6">
										<p>Tomatometer</p>	
										<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $tomatoRow['tomatoMeter']?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $tomatoRow['tomatoMeter']?>%;"><?php echo $tomatoRow['tomatoMeter']?>%</div>
										</div>
										<p >Average rating: <?php if(IsEmpty($tomatoRow['tomatoRating'])){
											echo 'N/A';
										}else {echo $tomatoRow['tomatoRating'].'/10';}
										?>
										</p>
										  <p >Reviews: <?php echo $tomatoRow['tomatoReviews']?></p>
										  <p >Fresh: <?php echo $tomatoRow['tomatoFresh']?></p>
										  <p >Rotten: <?php echo $tomatoRow['tomatoRotten']?></p>
									</div>
									<div class = "col-xs-6">
											<p>Audience Score</p>	
										<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $tomatoRow['tomatoUserMeter']?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $tomatoRow['tomatoUserMeter']?>%;"><?php echo $tomatoRow['tomatoUserMeter']?>%</div>
										</div>
										<p>Average Rating: <?php if(IsEmpty($tomatoRow['tomatoUserRating'])){
											echo 'N/A';
										}else {echo $tomatoRow['tomatoUserRating'].'/5';}?></p>
										 <p>Reviews: <?php echo $tomatoRow['tomatoUserReviews']?></p>
									</div>
									
								</div>
							</div>
						</div>
						<?php if($linkRow['youtubeLink']!=null){?>
						<iframe style = " display:block; width:100%; height:50%;" src="<?php 
							$noHttps = str_replace("https","http",$linkRow['youtubeLink']);
							$embed = str_replace("watch?v=", "embed/", $noHttps);
							echo $embed;?>"
							>
						</iframe>
						<?php } ?>		
					<!--end ratings etc-->	
					</div>
				</div>
				

				
		
			<!--end movie info excluding twitter feed-->	
			</div>
			<!--twitter feed-->
			<div class = "col-md-4">

				
			
						<?php 
					$screenshotList = $movieInfoRow['Screenshots'];
					$temp = explode(" ", $screenshotList);//split subtitles
					array_pop($temp);//remove last element as its a " "
					?>
					<div class = "row screenshots" style = "margin-top: 20px">
					<?php foreach ($temp as $value) { //echo "aaa ".$value; ?>
						
						<img src = "<?php echo $value; ?>" ></img><br><br>
						<?php } ?>

					</div>
					
					<div id="zrotate"></div>
			</div>		
					
				
			<!--end twitter feed-->	
			</div>
		<!--end main row excluding ads-->
		</div>



		<!--trends-->
		<div class = "row">
			
			<div class = "col-lg-12">
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">Trends</h3>
				  </div>
				  <div class="panel-body">
					   
						<div class = "row">
							<div class = "col-xs-6">
								<script type="text/javascript"
								src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $nameRow['name'];?>&w=700&h=430&cid=TIMESERIES_GRAPH_0">
								</script>
							</div>
						  	<div class = "col-xs-6">
						  		<script type="text/javascript"
								src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $nameRow['name'];?>&w=700&h=530&cid=GEO_MAP_0_0">
								</script>
						  	</div>
						</div>


						<div class = "row">
							<div class = "col-xs-6">
								<script type="text/javascript"
								src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $nameRow['name'];?>&w=700&h=430&cid=GEO_TABLE_0_0 ">
								</script>
							</div>
						  	<div class = "col-xs-6">
								<script type="text/javascript"
								src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $nameRow['name'];?>&w=700&h=330&cid=TOP_QUERIES_0_0 ">
								</script>

								<script type="text/javascript"
								src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=<?php echo $nameRow['name'];?>&w=700&h=330&cid=TOP_ENTITIES_0_0  ">
								</script>
						  	</div>
						</div>
				  </div>
				</div>
				
			</div>
		</div>

		<div class="panel panel-default">
				  <div class="panel-body">
				    <div id="cloud" style="width: 750px; height: 350px;"></div>
				  </div>
				</div>
			

		<!--ratings chart-->
		<div class = "row">
			
			<div class = "col-lg-12">

				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">Ratings and votes over time</h3>
				  </div>
				  <div class="panel-body">
					   
						<div id="chart1">
						  <svg></svg>
						</div>
				  </div>
				</div>
				
			</div>
		</div>


		<!--ratings chart-->
		<div class = "row">
			
			<div class = "col-lg-12">

				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">Sentiment</h3>
				  </div>
				  <div class="panel-body">
					   
						<div id="chart2">
						  <svg></svg>
						</div>
				  </div>
				</div>
				
			</div>
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

<script src="js/jqcloud.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="js/nv.d3.min.js"></script>

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

	var url = "<?php echo 'https://queryfeed.net/tw?q=%23'.normalize($nameRow['movieId']); ?>";
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
            "bar": true,
             "color": "#ccf",
            "values" : [ <?php printChartData(1, $imdbRow['imdbID']);?>]
        },
        {
            "key" : "Votes" ,
            "color" : "#333",
            "values" : [ <?php printChartData(0, $imdbRow['imdbID']);?>]
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
            .legendRightAxisHint(' [Using Right Axis]')
            .color(d3.scale.category10().range());
        chart.xAxis.tickFormat(function(d) {
                return d3.time.format('%x')(new Date(d))
            })
            .showMaxMin(false);
        chart.y1Axis.tickFormat(function(d) { return d3.format(',f')(d) });
        chart.bars.forceY([0]).padData(false);
        chart.x2Axis.tickFormat(function(d) {
            return d3.time.format('%x')(new Date(d))
        }).showMaxMin(false);
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
            "values" : [ <?php printSentiment(0, normalizeCaseSen($nameRow['name']));?>]
        },
        {
            "key" : "Negative" ,
            "bar": true,
            "color" : "red",
            "values" : [ <?php printSentiment(1, normalizeCaseSen($nameRow['name']));?>]
        },{
            "key" : "Neutral" ,
            "bar": true,
             "color": "#ccf",
            "values" : [ <?php printSentiment(2, normalizeCaseSen($nameRow['name']));?>]
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


<!--new ratings chart d3-->
<script>

/*var margin = {top: 30, right: 40, bottom: 30, left: 50},
    width = 600 - margin.left - margin.right,
    height = 270 - margin.top - margin.bottom;

var parseDate = d3.time.format("%d/%m/%Y").parse;

var x = d3.time.scale().range([0, width]);
var y0 = d3.scale.linear().range([height, 0]);
var y1 = d3.scale.linear().range([height, 0]);

var xAxis = d3.svg.axis().scale(x)
    .orient("bottom").ticks(5);

var yAxisLeft = d3.svg.axis().scale(y0)
    .orient("left").ticks(5);

var yAxisRight = d3.svg.axis().scale(y1)
    .orient("right").ticks(5); 

var valueline = d3.svg.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y0(d.votes); });
    
var valueline2 = d3.svg.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y1(d.rating); });
  
var svg = d3.select("#graph")
       .append("div")
	   .classed("svg-container", true) //container class to make it responsive
	   .append("svg")
	   //responsive SVG needs these 2 attributes and no width and height attr
	   .attr("preserveAspectRatio", "xMinYMin meet")
	   .attr("viewBox", "0 0 600 400")
	   //class to make it responsive
	   .classed("svg-content-responsive", true)
	   .append("g")
        .attr("transform", 
              "translate(" + margin.left + "," + margin.top + ")"); 

    

// Get the data
d3.csv("<?php echo "ratings/".$imdbRow['imdbID'].".csv";?>", function(error, data) {
    data.forEach(function(d) {
        d.date = parseDate(d.date);
        d.votes = +d.votes;
        d.rating = +d.rating;
    });

    // Scale the range of the data
    x.domain(d3.extent(data, function(d) { return d.date; }));
    y0.domain([0, d3.max(data, function(d) {
		return Math.max(d.votes); })]); 
    y1.domain([0, d3.max(data, function(d) { 
		return Math.max(d.rating); })]);

    svg.append("path")        // Add the valueline path.
        .attr("d", valueline(data));

    svg.append("path")        // Add the valueline2 path.
        .style("stroke", "red")
        .attr("d", valueline2(data));

    svg.append("g")            // Add the X Axis
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);

    svg.append("g")
        .attr("class", "y axis")
        .style("fill", "steelblue")
        .call(yAxisLeft);	

    svg.append("g")				
        .attr("class", "y axis")	
        .attr("transform", "translate(" + width + " ,0)")	
        .style("fill", "red")		
        .call(yAxisRight);

});*/

</script>

<!--RATINGS CHART-->
<script>


// instantiate our graph!
//data format [{x: abc, y:def}, {x: abc, y:def}]
/*var graph2 = new Rickshaw.Graph( {
	element: document.getElementById("chart"),
	width: 960,
	height: 500,
	renderer: 'line',
	series: [
		{
			color: "#c05020",
			data: [<?php printChartData(1, $imdbRow['imdbID']);?>],
			name: 'Rating'
		}, {
			color: "#30c020",
			data: [<?php printChartData(0, $imdbRow['imdbID']);?>],
			name: 'Votes'
		}
	]
} );


var x_axis2 = new Rickshaw.Graph.Axis.Time( { graph: graph2 } );

var y_axis2 = new Rickshaw.Graph.Axis.Y( {
        graph: graph2,
        orientation: 'left',
        tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
        element: document.getElementById('y_axis'),
} );

graph2.render();
var legend2 = document.querySelector('#legend');
var Hover = Rickshaw.Class.create(Rickshaw.Graph.HoverDetail, {
	render: function(args) {
		legend2.innerHTML = args.formattedXValue;
		args.detail.sort(function(a, b) { return a.order - b.order }).forEach( function(d) {
			var line = document.createElement('div');
			line.className = 'line';
			var swatch = document.createElement('div');
			swatch.className = 'swatch';
			swatch.style.backgroundColor = d.series.color;
			var label = document.createElement('div');
			label.className = 'label';
			label.innerHTML = d.name + ": " + d.formattedYValue;
			line.appendChild(swatch);
			line.appendChild(label);
			legend2.appendChild(line);
			var dot = document.createElement('div');
			dot.className = 'dot';
			dot.style.top = graph2.y(d.value.y0 + d.value.y) + 'px';
			dot.style.borderColor = d.series.color;
			this.element.appendChild(dot);
			dot.className = 'dot active';
			this.show();
		}, this );
        }
});
var hover = new Hover( { graph: graph2 } ); */
</script>


<script>
// instantiate our graph!
//data format [{x: abc, y:def}, {x: abc, y:def}]
/*var graph = new Rickshaw.Graph( {
	element: document.getElementById("sentchart"),
	width: 960,
	height: 500,
	renderer: 'line',
	series: [
		{
			color: "#c05020",
			data: [<?php printSentiment(0, str_replace($unwantedChars, "", $nameRow['name']));?>],
			name: 'Positive'
		}, {
			color: "#30c020",
			data: [<?php printSentiment(1, str_replace($unwantedChars, "", $nameRow['name']));?>],
			name: 'Negative'
		},{
			color: "#c05020",
			data: [<?php printSentiment(2, str_replace($unwantedChars, "", $nameRow['name']));?>],
			name: 'Neutral'
		},{
			color: "#c05020",
			data: [<?php printSentiment(3, str_replace($unwantedChars, "", $nameRow['name']));?>],
			name: 'Tweet Count'
		}
	]
} );


var x_axis= new Rickshaw.Graph.Axis.Time( { graph: graph } );

var y_axis = new Rickshaw.Graph.Axis.Y( {
        graph: graph,
        orientation: 'left',
        tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
        element: document.getElementById('senty_axis'),
} );

graph.render();
var legend = document.querySelector('#sentlegend');
var Hover = Rickshaw.Class.create(Rickshaw.Graph.HoverDetail, {
	render: function(args) {
		legend.innerHTML = args.formattedXValue;
		args.detail.sort(function(a, b) { return a.order - b.order }).forEach( function(d) {
			var line = document.createElement('div');
			line.className = 'line';
			var swatch = document.createElement('div');
			swatch.className = 'swatch';
			swatch.style.backgroundColor = d.series.color;
			var label = document.createElement('div');
			label.className = 'label';
			label.innerHTML = d.name + ": " + d.formattedYValue;
			line.appendChild(swatch);
			line.appendChild(label);
			legend.appendChild(line);
			var dot = document.createElement('div');
			dot.className = 'dot';
			dot.style.top = graph.y(d.value.y0 + d.value.y) + 'px';
			dot.style.borderColor = d.series.color;
			this.element.appendChild(dot);
			dot.className = 'dot active';
			this.show();
		}, this );
        }
});
var hover = new Hover( { graph: graph } ); */
</script>




		<!-- jquery-->
		
		<!-- javascript-->
		<script src = "js/bootstrap.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		
		<!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

</body>
</html>