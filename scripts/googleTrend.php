<?php
include("../includes/connect.php");
$ch = curl_init();                    // initiate curl
$url = "http://www.google.com/trends/topcharts/trendingchart"; // where you want to post data
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
curl_setopt($ch, CURLOPT_POSTFIELDS, "ajax=1&cid=films&geo=US&date=2015"); // define what you want to post
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
$output = curl_exec ($ch); // execute
 
curl_close ($ch); // close curl handle

//dont remove \\ since json decode does it 
//$output = str_replace("\\", "", json_encode($output, JSON_UNESCAPED_SLASHES)); // show output
//echo $output;

$output = json_decode($output, true);
var_dump($output['data']['entityList']);

foreach($output['data']['entityList'] as $movie){
	echo $movie['title'].'<br>';
	echo $movie['description']['description'].'<br>';
}





?>
<!--http://www.techvigil.com/tips-tricks/392/embed-google-trends-chart/-->
<!--<script type="text/javascript"
src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=bit coin&w=500&h=330&cid=TIMESERIES_GRAPH_0">
</script>

<script type="text/javascript"
src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=bit coin&w=500&h=330&cid=GEO_MAP_0_0">
</script>	


<script type="text/javascript"
src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=bit coin&w=500&h=330&cid=GEO_TABLE_0_0 ">
</script>

<script type="text/javascript"
src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=bit coin&w=500&h=330&cid=TOP_QUERIES_0_0 ">
</script>

<script type="text/javascript"
src="//www.google.co.in/trends/embed.js?hl=en-US&content=1&export=5&q=bit coin&w=500&h=330&cid=TOP_ENTITIES_0_0  ">
</script>-->





