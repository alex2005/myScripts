#!/bin/sh

# a shell script used to download a specific url.
# this is executed from a crontab entry every day or
# a while(true) loop with sleep 60

DIR=/tmp

# wget output file
FILE=webcam.`date +"%Y%m%d_%H%M%S"`.jpg

# wget log file
LOGFILE=wget.log

# wget download url
URL=http://www.edingen-neckarhausen.de/webcam/webcam/current.jpg

cd $DIR
wget $URL -O $FILE -o $LOGFILE
