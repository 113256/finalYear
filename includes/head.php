	<head>
		<title>Find subtitles for the latest movies and tv shows</title>
		<!--bootstrap.min.css and bootstrap.css are the same
		but the min file has all spaces removed hence its faster
		to load-->
		<!-- meta tag 
		on mobile, screen will scale down to mobile version so we use this tag, tablet verison 
		on tablet and desktop version on desktop
		-->
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0" >
		<link href = "css/bootstrap.css" rel = "stylesheet">
		<!--custom styles -->
		<link href = "css/styles.css" rel = "stylesheet">
		<link href = "css/sidebar.css" rel = "stylesheet">
		  <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		  
		  <!-- morris js-->

		  



<!--picture captions-->
<script src="js/jquery.caption.js" type="text/javascript"></script>
<script src="js/jquery1.7.1.min.js" type="text/javascript"></script>
<!--twitter feed-->
<script src="js/zframework.js" type="text/javascript"></script>
<!--rickshaw js charts-->
<script src="js/d3.min.js"></script>
<script src="js/d3.v3.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="js/rickshaw.min.js"></script>
<!--wordcloud-->

<link rel="stylesheet" href="css/jqcloud.min.css">

<link href="css/captionjs.min.css" rel="stylesheet"/>
<link href="css/jquery.zrssfeed.css" rel="stylesheet" type="text/css" />
<link href="css/zframework.css" rel="stylesheet" type="text/css" />
<!--rickshaw js charts-->
<link type="text/css" rel="stylesheet" href="css/graph/graph.css">
<link type="text/css" rel="stylesheet" href="css/graph/detail.css">
<link type="text/css" rel="stylesheet" href="css/graph/legend.css">





	


	<style>
		.captionjs, .captionjs figcaption {
			margin: 0 0 20px;
			padding: 0;
		}
		.captionjs figcaption {
			font-size: 13px;
			line-height: 1.5;
			padding: 10px 15px;
			border: 1px solid #ddd;
			border-top: none;
			background-color: #eee;
		}
		.captionjs.stacked figcaption {
			background-color: rgba(0, 0, 0, 0.75);
			color: #fff;
			border: none;
		}
		.captionjs.animated figcaption {
			border-top: 1px solid rgba(255, 255, 255, 0.3);
			background-color: rgba(0, 0, 0, 0.75);
			color: #fff;
			border: none;
		}
		.captionjs.hide figcaption {
			border-top: 1px solid rgba(255, 255, 255, 0.3);
			background-color: rgba(0, 0, 0, 0.75);
			color: #fff;
			border: none;
		}
		.captionjs.default a {
			color: #000;
		}

		/*rickshaw js*/
		#chart_container, #sentchart_container {
			width: 960px;
		}
		.swatch {
			display: inline-block;
			width: 10px;
			height: 10px;
			margin: 0 8px 0 0;
		}
		.label {
			color: black;
			display: inline-block;
		}
		.line {
			display: inline-block;
			margin: 0 0 0 30px;
		}
		#legend, #sentlegend {
			text-align: center;
		}
		.rickshaw_graph .detail {
			background: none;
		}
		#y_axis, #senty_axis {
	        position: absolute;
	        top: 0;
	        bottom: 0;
	        width: 40px;
		}
		
				#axis0 {
		    position: absolute;
		    height: 800px;
		    width: 40px;
		  }
		  #axis1 {
		    position: absolute;
		    left: 1050px;
		    height: 800px;
		    width: 40px;
		  }


.svg-container {font: 8px Arial;
    display: inline-block;
    position: relative;
    width: 100%;
    padding-bottom: 50%; /* aspect ratio */
    vertical-align: top;
    overflow: hidden;
}
.svg-content-responsive {
    display: inline-block;
    position: absolute;
    top: 10px;
    left: 0;
}


path { 
    stroke: steelblue;
    stroke-width: 2;
    fill: none;
}

.axis path,
.axis line {
    fill: none;
    stroke: grey;
    stroke-width: 1;
    shape-rendering: crispEdges;
}

 svg {
    display: block;
}
html, body, #chart1, svg {
    margin: 0px;
    padding: 0px;
    height: 100%;
    width: 100%;
}





	</style>


	</head>