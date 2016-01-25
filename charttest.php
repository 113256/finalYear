<!doctype>
<head>
	<link type="text/css" rel="stylesheet" href="css/graph/graph.css">
	<link type="text/css" rel="stylesheet" href="css/graph/detail.css">
	<link type="text/css" rel="stylesheet" href="css/graph/legend.css">

	<script src="js/d3.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

	<script src="js/rickshaw.min.js"></script>

	<style>
		body { 
			font-family: Arial, sans-serif 
		}
		#chart_container {
			width: 960px;
		}
		.swatch {
			display: inline-block;
			width: 10px;
			height: 10px;
			margin: 0 8px 0 0;
		}
		.label {
			display: inline-block;
		}
		.line {
			display: inline-block;
			margin: 0 0 0 30px;
		}
		#legend {
			text-align: center;
		}
		.rickshaw_graph .detail {
			background: none;
		}
	</style>
</head>
<body>

<div id="chart_container">
	<div id="chart"></div><br>
	<div id="legend"></div>
</div>

<script>

<?php require("includes/chartData.php");?>
// instantiate our graph!
//data format [{x: abc, y:def}, {x: abc, y:def}]
var graph = new Rickshaw.Graph( {
	element: document.getElementById("chart"),
	width: 960,
	height: 500,
	renderer: 'line',
	series: [
		{
			color: "#c05020",
			data: [<?php printChartData(1);?>],
			name: 'Rating'
		}, {
			color: "#30c020",
			data: [<?php printChartData(0);?>],
			name: 'Votes'
		}
	]
} );


var x_axis = new Rickshaw.Graph.Axis.Time( { graph: graph } );

var y_axis = new Rickshaw.Graph.Axis.Y( {
        graph: graph,
        orientation: 'left',
        tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
        element: document.getElementById('y_axis'),
} );

graph.render();
var legend = document.querySelector('#legend');
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
var hover = new Hover( { graph: graph } ); 
</script>

</body>