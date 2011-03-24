#!/bin/bash

if [ ! -e $1 ]; then
	echo "Usage: $0 covername.jpg "
	exit
fi

artist=`cd ..; pwd | rev | awk -F \/ '{print $1}' | rev`
album=`pwd | rev | awk -F \/ '{print $1}' | rev`

if [ -e ${artist}_-_${album}_a.jpg ]; then
	echo "ERROR: ${artist}_-_${album}_a.jpg exists!"
	exit
fi

echo "moving $1 to ${artist}_-_${album}_a.jpg"
