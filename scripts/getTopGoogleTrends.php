<?php

/* gets the data from a URL */
function get_data($url) {
	$ch = curl_init();
	//$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
error_reporting(~0);
ini_set('display_errors', 1);

//$text = get_data('http://www.google.com/trends/fetchComponent?q=ex+machina&cid=TIMESERIES_GRAPH_0&export=3');
//echo $text;


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
$topTrendOutput = json_decode($output, true);

$bigString = ""; //all moviestrings combined 
foreach($topTrendOutput['data']['entityList'] as $movie){
    //title and description
    $title = $movie['title'];
    $description = $movie['description']['description'];

    //generate the graph string
    $url = 'http://www.google.com/trends/fetchComponent?q='.str_replace(" ", "+", $title).'&cid=TIMESERIES_GRAPH_0&export=3';
    $text = get_data($url);
    echo $url."<br>";
    //capture this {"v":new Date(2004,0,1),"f":"December 2003"},{"v":4.0,"f":"4"}
    //2004,0,1 (last digit 1 is the date), 0 means january, so december means 11 

    //we want the date and the value of f 
    $regex = '#{"v":new Date\((.*?)\),"f":".*?"},{"v":.*?,"f":"(.*?)"}#s';
    preg_match_all($regex, $text, $matches, PREG_SET_ORDER);//need preg_Set_order so array indexes are capture groups

    $graphString = "";

    foreach ($matches as $match) {
        //unformatted
        $date = $match[1]; 
        $dateArray = explode(",",$date);
        $year = $dateArray[0];
        $month = $dateArray[1]+1;
        $day = 1;

        $formatDate = $year."-".$month."-".$day;
        //echo $formatDate;
        $epoch = strtotime($formatDate)*1000;
        //echo "<Br>";
        //echo $epoch;
        //echo "<Br>";
        $interest = $match[2];
        //echo $interest;
        //echo "<Br>";
        $graphString.="[".$epoch.",".$interest."],";
    }

    $graphString = rtrim($graphString, ",");

    //moviestring = string for each movie, separated by /// 
    $movieString = $title."///".$description."///".$graphString;
    echo $movieString."<br>";
    //concatenate all moviestrings into one big string, separate each movie string by ###
    $bigString .= $movieString."###";
}

$bigString = rtrim($bigString, "###");

$file = "../topGoogleTrends2015/movies.txt";
if(file_put_contents($file,$bigString) !=false){
    echo "added";
}else{
    echo "Cannot create file (".basename($file).")";
}
echo "done ";

?>
<!DOCTYPE html>
<html>
<body>
    <!--
<div id="chart2"  style = "height:300px">
  <svg></svg>
</div>-->


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.zrssfeed.js" type="text/javascript"></script>
<script src="js/zframework.js" type="text/javascript"></script>

<script src="js/jqcloud.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="js/nv.d3.min.js"></script>

<script>
/*
   var testdata = [
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
*/
</script>
</body>
</html>