<?php

/* gets the data from a URL */
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


$text = get_data('http://www.google.com/trends/fetchComponent?q=ex%20machina&cid=TIMESERIES_GRAPH_0&export=3');
//echo $text;
/*
$text = '// Data table response
google.visualization.Query.setResponse({"version":"0.6","status":"ok","sig":"354640350","table":{"cols":[{"id":"date","label":"Date","type":"date","pattern":""},{"id":"query0","label":"ex machina","type":"number","pattern":""}],"rows":[{"c":[{"v":new Date(2004,0,1),"f":"December 2003"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2004,1,1),"f":"January 2004"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2004,2,1),"f":"February 2004"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2004,3,1),"f":"March 2004"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2004,4,1),"f":"April 2004"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2004,5,1),"f":"May 2004"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2004,6,1),"f":"June 2004"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2004,7,1),"f":"July 2004"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2004,8,1),"f":"August 2004"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2004,9,1),"f":"September 2004"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2004,10,1),"f":"October 2004"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2004,11,1),"f":"November 2004"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2005,0,1),"f":"December 2004"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,1,1),"f":"January 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,2,1),"f":"February 2005"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2005,3,1),"f":"March 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,4,1),"f":"April 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,5,1),"f":"May 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,6,1),"f":"June 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,7,1),"f":"July 2005"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2005,8,1),"f":"August 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,9,1),"f":"September 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,10,1),"f":"October 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2005,11,1),"f":"November 2005"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,0,1),"f":"December 2005"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2006,1,1),"f":"January 2006"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2006,2,1),"f":"February 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,3,1),"f":"March 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,4,1),"f":"April 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,5,1),"f":"May 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,6,1),"f":"June 2006"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2006,7,1),"f":"July 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,8,1),"f":"August 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,9,1),"f":"September 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,10,1),"f":"October 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2006,11,1),"f":"November 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,0,1),"f":"December 2006"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,1,1),"f":"January 2007"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2007,2,1),"f":"February 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,3,1),"f":"March 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,4,1),"f":"April 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,5,1),"f":"May 2007"},{"v":3.0,"f":"3"}]},{"c":[{"v":new Date(2007,6,1),"f":"June 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,7,1),"f":"July 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,8,1),"f":"August 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,9,1),"f":"September 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,10,1),"f":"October 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2007,11,1),"f":"November 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2008,0,1),"f":"December 2007"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2008,1,1),"f":"January 2008"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2008,2,1),"f":"February 2008"},{"v":9.0,"f":"9"}]},{"c":[{"v":new Date(2008,3,1),"f":"March 2008"},{"v":6.0,"f":"6"}]},{"c":[{"v":new Date(2008,4,1),"f":"April 2008"},{"v":6.0,"f":"6"}]},{"c":[{"v":new Date(2008,5,1),"f":"May 2008"},{"v":6.0,"f":"6"}]},{"c":[{"v":new Date(2008,6,1),"f":"June 2008"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2008,7,1),"f":"July 2008"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2008,8,1),"f":"August 2008"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2008,9,1),"f":"September 2008"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2008,10,1),"f":"October 2008"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2008,11,1),"f":"November 2008"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,0,1),"f":"December 2008"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,1,1),"f":"January 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,2,1),"f":"February 2009"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2009,3,1),"f":"March 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,4,1),"f":"April 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,5,1),"f":"May 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,6,1),"f":"June 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,7,1),"f":"July 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,8,1),"f":"August 2009"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2009,9,1),"f":"September 2009"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2009,10,1),"f":"October 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2009,11,1),"f":"November 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,0,1),"f":"December 2009"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,1,1),"f":"January 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,2,1),"f":"February 2010"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2010,3,1),"f":"March 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,4,1),"f":"April 2010"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2010,5,1),"f":"May 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,6,1),"f":"June 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,7,1),"f":"July 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,8,1),"f":"August 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,9,1),"f":"September 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,10,1),"f":"October 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2010,11,1),"f":"November 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,0,1),"f":"December 2010"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,1,1),"f":"January 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,2,1),"f":"February 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,3,1),"f":"March 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,4,1),"f":"April 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,5,1),"f":"May 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,6,1),"f":"June 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,7,1),"f":"July 2011"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2011,8,1),"f":"August 2011"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2011,9,1),"f":"September 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,10,1),"f":"October 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2011,11,1),"f":"November 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,0,1),"f":"December 2011"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,1,1),"f":"January 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,2,1),"f":"February 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,3,1),"f":"March 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,4,1),"f":"April 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,5,1),"f":"May 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,6,1),"f":"June 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,7,1),"f":"July 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,8,1),"f":"August 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,9,1),"f":"September 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,10,1),"f":"October 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2012,11,1),"f":"November 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,0,1),"f":"December 2012"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,1,1),"f":"January 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,2,1),"f":"February 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,3,1),"f":"March 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,4,1),"f":"April 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,5,1),"f":"May 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,6,1),"f":"June 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,7,1),"f":"July 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,8,1),"f":"August 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,9,1),"f":"September 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,10,1),"f":"October 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2013,11,1),"f":"November 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,0,1),"f":"December 2013"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,1,1),"f":"January 2014"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,2,1),"f":"February 2014"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,3,1),"f":"March 2014"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,4,1),"f":"April 2014"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,5,1),"f":"May 2014"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,6,1),"f":"June 2014"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2014,7,1),"f":"July 2014"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,8,1),"f":"August 2014"},{"v":4.0,"f":"4"}]},{"c":[{"v":new Date(2014,9,1),"f":"September 2014"},{"v":5.0,"f":"5"}]},{"c":[{"v":new Date(2014,10,1),"f":"October 2014"},{"v":6.0,"f":"6"}]},{"c":[{"v":new Date(2014,11,1),"f":"November 2014"},{"v":6.0,"f":"6"}]},{"c":[{"v":new Date(2015,0,1),"f":"December 2014"},{"v":14.0,"f":"14"}]},{"c":[{"v":new Date(2015,1,1),"f":"January 2015"},{"v":11.0,"f":"11"}]},{"c":[{"v":new Date(2015,2,1),"f":"February 2015"},{"v":14.0,"f":"14"}]},{"c":[{"v":new Date(2015,3,1),"f":"March 2015"},{"v":45.0,"f":"45"}]},{"c":[{"v":new Date(2015,4,1),"f":"April 2015"},{"v":100.0,"f":"100"}]},{"c":[{"v":new Date(2015,5,1),"f":"May 2015"},{"v":45.0,"f":"45"}]},{"c":[{"v":new Date(2015,6,1),"f":"June 2015"},{"v":42.0,"f":"42"}]},{"c":[{"v":new Date(2015,7,1),"f":"July 2015"},{"v":32.0,"f":"32"}]},{"c":[{"v":new Date(2015,8,1),"f":"August 2015"},{"v":23.0,"f":"23"}]},{"c":[{"v":new Date(2015,9,1),"f":"September 2015"},{"v":18.0,"f":"18"}]},{"c":[{"v":new Date(2015,10,1),"f":"October 2015"},{"v":19.0,"f":"19"}]},{"c":[{"v":new Date(2015,11,1),"f":"November 2015"},{"v":24.0,"f":"24"}]},{"c":[{"v":new Date(2016,0,1),"f":"December 2015"},{"v":31.0,"f":"31"}]}]}});';
*/

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

?>
<!DOCTYPE html>
<html>
<body>
<div id="chart2"  style = "height:300px">
  <svg></svg>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.zrssfeed.js" type="text/javascript"></script>
<script src="js/zframework.js" type="text/javascript"></script>

<script src="js/jqcloud.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="js/nv.d3.min.js"></script>

<script>

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
</script>
</body>
</html>