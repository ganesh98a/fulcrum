#!/usr/bin/php -q
<?php

// This code demonstrates how to lookup the country and region by IP Address
// It is designed to work with GeoIP Organization or GeoIP ISP available from MaxMind

include("geoip.inc");

$giorg = geoip_open("/usr/local/share/GeoIP/GeoIPLocA.dat",GEOIP_STANDARD);

$org = geoip_org_by_addr($giorg,"80.24.24.24");
print "80.24.24.24 belongs to " . $org . "ZZ\n";

geoip_close($giorg);

?>

