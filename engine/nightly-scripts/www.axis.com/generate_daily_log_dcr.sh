#!/bin/bash

server="http://45.118.132.111/"
script="dcr-dailylog-jobs.php?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C"
#command="wget "
command="curl -s "

### case if will use the argument of the date
### e.g. 2015-05-13

### case else will use the current date
### in php date('Y-m-d);

if [ "$1" != "" ]; then
	shellExec=${command}${server}${script}"&date="${1}
	$shellExec
else
	shellExec=${command}${server}${script}
	$shellExec
fi