#!/bin/sh

# a shell script used to download a specific url.
# this is executed from a crontab entry every day or
# a while(true) loop with sleep 60
# while (true); do ./wget_webcampic.sh ; sleep 60; done
# convert -adjoin -delay 2 webcam.20110717_08* animation.gif


DIR=/tmp

# wget output file
FILE=webcam.`date +"%Y%m%d_%H%M%S"`.jpg

# wget log file
LOGFILE=wget.log

# wget download url
URL=http://www.edingen-neckarhausen.de/webcam/webcam/current.jpg

cd $DIR
wget $URL -O $FILE -o $LOGFILE
