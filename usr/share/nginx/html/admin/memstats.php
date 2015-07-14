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
		<title>Memory and swap Stats for salt.dataking.us</title>
		<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
			google.load('visualization', '1', {packages: ['corechart']});
			google.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = new google.visualization.DataTable();
				data.addColumn('date', 'Hour');
				data.addColumn('number', 'mem_used');
				data.addColumn('number', 'swap_used');
				data.addRows([
<?php

	date_default_timezone_set('US/Pacific');

	$lweek = time() - (7 * 24 * 60 * 60);
	$now = time();
	$db = new SQLite3('../db/mem.db');
	$results = $db->query("SELECT date,mem_used,swap_used from mem where date between '".date('Y-n-j', $lweek)."' and '".date('Y-n-j', $now)."'");
	while ($row = $results->fetcharray()) {
		# 2015-05-06T17:59:02+00:00
		if (preg_match("/(\d{4})-(\d\d?)-(\d\d?) (\d\d?):(\d\d?):(\d\d?)+.*/", $row["date"], $matches_out)) {
			#list($date, $time) = preg_split("/\s/", $row["date"]);
			#list($m,$d,$y) = preg_split("/\//", $date);
			#list($h,$mm,$s) = preg_split("/\:/", $time);
			$y = $matches_out[1];
			$m = $matches_out[2] - 1;
			$d = $matches_out[3];
			$h = $matches_out[4];
			$mm = $matches_out[5];
			$s = $matches_out[6];
			print "\t\t\t\t\t[new Date(".$y.",".$m.",".$d.",".$h.",".$mm.",".$s.",000), ".$row['mem_used'].",".$row["swap_used"]."],\n";
			#print "\t\t\t\t\t['".$h.":".$mm."', ".$row['latency']."],\n";
		}
		else
		{
			print "ERROR:  regex mismatch <br />\n";
		}
	}
?>

				]);

				var options = {
					title: "Memory Stats for dataking.us",
					width: 900, height: 400,
					hAxis: {
						title: "Time",
						gridlines: { count: '24' }
					},
					vAxis: {
						title: "in MiB",
						textStyle: {
							color: 'black',
							fontSize: '16'
						}
					},
					legend: { position: "in" }
				};

				var options_stacked = {
					isStacked: true,
				};

				var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));

				chart.draw(data, options);
			}
		</script>
		<link rel="stylesheet" type="text/css" href="/css/scripts.css" /> 
		<meta http-equiv="refresh" content="300" />
	</head>
	<body>
		<h3>FW Hits</h3>
		<a href="/admin/index.php" target="_top">&lt; Index</a><br />
		<div id="chart_div" style="width: 900px; height: 400px"></div>
		<br /><br />
<!-- <?php
	//var_dump($_SERVER);
?> -->
	</body>
</html>
