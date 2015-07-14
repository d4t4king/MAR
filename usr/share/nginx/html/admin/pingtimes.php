<?php

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "") {
	$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	header("Location: $redirect");
}

/*
if ( ! file_exists('/tmp/access_log') or filesize('/tmp/access_log') == 0 ) {
	system("/usr/local/bin/acclog");
}
 */
//$arr = array('' => '',);

/*
$fh = fopen('/tmp/access_log', 'r');
while ($line = fgets($fh)) {
	$ip = (preg_split('/ /', $line, "1", PREG_SPLIT_NO_EMPTY));

	if (preg_match('/127.0.0.1/', $ip[0])) {
		continue;
	}
	if (isset($ip[0])) {
		$rec = @geoip_country_code_by_name($ip[0]);
		if (isset($rec)) {
			if (isset($arr[$rec])) {
				$arr[$rec]++;
			} else {
				$arr[$rec] = 1;
			}
		}
	}
}
fclose($fh);
 */
?>
<html>
	<head>
		<title>Ping Times</title>
		<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<!-- 
		<script type="text/javascript">
			google.load("visualization", "1", {packages:["gauge"]});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['Label', 'Value'],
<?php
/*
	$db = new SQLite3('../db/pingtimes.db');
	$result = $db->query("SELECT ip,latency from pingtimes where ip='8.8.8.8' order by datetime desc LIMIT 1");
	while ($row = $result->fetcharray()) {
		print "\t\t\t\t\t['".$row['ip']."','".$row['latency']."']\n";
	}
*/
?>
				]);

				var options = {
					width: 120, height: 120,
					redFrom: 75, redTo: 100,
					yellowFrom: 50, yellowTo: 75,
					minorTicks: 5
				};

				var chart = new google.visualization.Gauge(document.getElementById('gauge_chart'));

				chart.draw(data, options);
			}
		</script> -->
		<script type="text/javascript">
			google.load('visualization', '1', {packages: ['corechart']});
			google.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = new google.visualization.DataTable();
				data.addColumn('date', 'Hour');
				data.addColumn('number', 'Latency');
				data.addRows([
<?php

	$db = new SQLite3('../db/pingtimes.db');
	$results = $db->query("SELECT datetime,latency from pingtimes where ip='8.8.8.8' order by datetime desc LIMIT 2016");
	while ($row = $results->fetcharray()) {
		list($date, $time) = preg_split("/\s/", $row["datetime"]);
		list($m,$d,$y) = preg_split("/\//", $date);
		list($h,$mm,$s) = preg_split("/\:/", $time);
		print "\t\t\t\t\t[new Date(".$y.",".$m.",".$d.",".$h.",".$mm.",".$s.",000), ".$row['latency']."],\n";
		//print "\t\t\t\t\t['".$h.":".$mm."', ".$row['latency']."],\n";
	}
?>

				]);

				var options = {
					title: "Google Public DNS: Latency over time",
					width: 900, height: 400,
					hAxis: {
						title: "Time",
						gridlines: { count: '24' }
					},
					vAxis: {
						title: "Response time in ms",
						textStyle: {
							color: 'black',
							fontSize: '16'
						}
					},
					legend: { position: "in" }
				};

				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

				chart.draw(data, options);
			}
		</script>
		<script type="text/javascript">
			google.load('visualization', '1', {packages: ['corechart']});
			google.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = new google.visualization.DataTable();
				data.addColumn('date', 'Hour');
				data.addColumn('number', 'Latency');
				data.addRows([
<?php

	$db = new SQLite3('../db/pingtimes.db');
	$results = $db->query("SELECT datetime,latency from pingtimes where ip='216.58.216.36' order by datetime desc LIMIT 2016");
	while ($row = $results->fetcharray()) {
		list($date, $time) = preg_split("/\s/", $row["datetime"]);
		list($m,$d,$y) = preg_split("/\//", $date);
		list($h,$mm,$s) = preg_split("/\:/", $time);
		print "\t\t\t\t\t[new Date(".$y.",".$m.",".$d.",".$h.",".$mm.",".$s.",000), ".$row['latency']."],\n";
		//print "\t\t\t\t\t['".$h.":".$mm."', ".$row['latency']."],\n";
	}
?>

				]);

				var options = {
					title: "www.google.com: Latency over time",
					width: 900, height: 400,
					hAxis: {
						title: "Time",
						gridlines: { count: '24' }
					},
					vAxis: {
						title: "Response time in ms",
						textStyle: {
							color: 'black',
							fontSize: '16'
						}
					},
					legend: { position: "in" }
				};

				var chart = new google.visualization.LineChart(document.getElementById('dt_chart_div'));

				chart.draw(data, options);
			}
		</script>
		<script type="text/javascript">
			google.load('visualization', '1', {packages: ['corechart']});
			google.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = new google.visualization.DataTable();
				data.addColumn('date', 'Hour');
				data.addColumn('number', 'Latency');
				data.addRows([
<?php

	$db = new SQLite3('../db/pingtimes.db');
	$results = $db->query("SELECT datetime,latency from pingtimes where ip='206.190.36.45' order by datetime desc LIMIT 2016");
	while ($row = $results->fetcharray()) {
		list($date, $time) = preg_split("/\s/", $row["datetime"]);
		list($m,$d,$y) = preg_split("/\//", $date);
		list($h,$mm,$s) = preg_split("/\:/", $time);
		print "\t\t\t\t\t[new Date(".$y.",".$m.",".$d.",".$h.",".$mm.",".$s.",000), ".$row['latency']."],\n";
		//print "\t\t\t\t\t['".$h.":".$mm."', ".$row['latency']."],\n";
	}
?>

				]);

				var options = {
					title: "www.yahoo.com: Latency over time",
					width: 900, height: 400,
					hAxis: {
						title: "Time",
						gridlines: { count: '24' }
					},
					vAxis: {
						title: "Response time in ms",
						textStyle: {
							color: 'black',
							fontSize: '16'
						}
					},
					legend: { position: "in" }
				};

				var chart = new google.visualization.LineChart(document.getElementById('du_chart_div'));

				chart.draw(data, options);
			}
		</script>
		<link rel="stylesheet" type="text/css" href="/css/scripts.css" /> 
		<meta http-equiv="refresh" content="300" />
	</head>
	<body>
		<h3>Latency</h3>
		<!--- <div id="gauge_chart" style="width: 150px; height: 150px;"></div>
		<br /><br /> -->
		<a href="/admin/index.php" target="_top">&lt; Index</a><br />
		<div id="chart_div" style="width: 900px; height: 400px"></div>
		<br /><br />
		<div id="dt_chart_div" style="width: 900px; height: 400px"></div>
		<br /><br />
		<div id="du_chart_div" style="width: 900px; height: 400px"></div>
		<br /><br />
		<div id="dmp_chart_div" style="width: 900px; height: 400px"></div>
<!-- <?php
	//var_dump($_SERVER);
?> -->
	</body>
</html>
