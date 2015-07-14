#!/usr/bin/perl -w

use warnings;
use strict;

use Term::ANSIColor;
use DBI;

my %ips = (
	'Google DNS' => '8.8.8.8',
	'www.google.com' => '216.58.216.36',
	'www.yahoo.com' => '206.190.36.45',
	'news.yahoo.com' => '206.190.61.106',
	'wow.blizzard.1' => '12.129.222.10',
	'wow.blizzard.2' => '199.108.62.157'
);

my $dbh = DBI->connect("dbi:SQLite:dbname=/var/www/localhost/htdocs/db/pingtimes.db","","");
my $sth = $dbh->prepare("INSERT INTO pingtimes(datetime,ip,latency) VALUES (?,?,?)");
foreach my $ip ( sort keys %ips ) {
	my $avg = 0;
	my $text = `ping -c 5 $ips{$ip} | grep '^rtt min'`;
	#print "$text\b";
	if ( $text =~ /rtt min\/avg\/max\/mdev = \d+\.\d+\/(\d+\.\d+)\/\d+\.\d+\/\d+\.\d+ ms/ ) {
		$avg = $1;
	}
	my ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = localtime();
	$year += 1900;
	if ($sec < 10) { $sec = "0$sec"; }
	if ($min < 10) { $min = "0$min"; }
	if ($hour < 10) { $hour = "0$hour"; }
	if ($mday < 10) { $mday = "0$mday"; }
	if ($mon < 10) { $mon = "0$mon"; }
	my $datestr = "$mon/$mday/$year $hour:$min:$sec";
	print "$datestr|";
	print colored("$ips{$ip}|", "red");
	print "$avg\n";
	$sth->execute( $datestr, $ips{$ip}, $avg );
}

$dbh->disconnect;


