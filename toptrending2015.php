<?php


require('includes/connect.php');
require('includes/head.php');

?>



	

<!DOCTYPE html>
<html>
<?php 
require('includes/navbar.php');
require('includes/string.php');
?>


<body>


        <section class = "bg-white" style = "padding-left:20px; padding-right:10px; padding-top:50px" >
		<div class="row">
			<div class="col-lg-12">
    		<div class="tab-content">
    			<div role="tabpanel" class="tab-pane fade in active" id="trending">
    				<h3>Highest searched films 2015</h3>
    				<ul class="list-group">
					<?php 
					$text = file_get_contents('topGoogleTrends2015/movies.txt');
					$movieArray = explode("###", $text);

					$i = 0;

					foreach ($movieArray as $movieString) {
						echo '<div class = "row">';
						$movieArray = explode("///", $movieString);

						$name = $movieArray[0];
						$description = $movieArray[1];
						$graphString = $movieArray[2];
						?>
						<div class = "col-xs-2">
							<div class = "miniPoster">
							<img src="
                    		<?php 
                    		$filename = 'poster/'.normalize($name).'.jpg';
                    		if(file_exists($filename)){
                    			echo $filename;
                    		}
                    		?>
                    		" alt = "<?php echo $name; ?>"></img></div>
						</div>

						<div class = "col-xs-4">
							<?php 
							echo '<a class="" href="movieInfo.php?movieId='.str_replace("+", "%2B", urlencode((ucwords($name)))).'">'.ucwords($name).'</a><br>';
							echo "<br>";
							echo $description; 

							?>
						</div>

						<div class = "col-xs-6">
							<script>
							   var testdata<?php echo $i;?> = [
							        {
							            "key" : "Interest" ,
							            "bar": true,
							             "color": "blue",
							            "values" : [ <?php echo $graphString;?>]
							        }
							    ].map(function(series) {
							            series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
							            return series;
							        });
							    //console.log(testdata);
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

							    d3.select('#chart<?php echo $i;?> svg')
							        .datum(testdata<?php echo $i;?>)
							        .transition().duration(500)
							        .call(chart)
							        ;

							    nv.utils.windowResize(chart.update);

							    return chart;
							});
							</script>
							<div id="chart<?php echo $i;?>"  style = "height:180px">
							  <svg></svg>
							</div>

						</div>

					<?php	
					$i++;
					//end foreach
					echo '</div>';
					}
					?>
					
					</ul>
    			</div>

    		</div>
	        </div>
	    </div>
        </section>
 


            
<img src="phpjobscheduler/firepjs.php?return_image=1" border="0" alt="phpJobScheduler">

        
	




	<!-- Scrolling Nav JavaScript -->
	
    
    <script src = "js/bootstrap.min.js"></script>

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

		



	


</body>

</html>