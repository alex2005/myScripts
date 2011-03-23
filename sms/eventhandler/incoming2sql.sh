#!/bin/sh
#Smsd gives two or three arguments to the eventhandler. The first one is SENT, RECEIVED, FAILED, REPORT or CALL. 
#The second one is the SMS file filename. The third argument is the message id of the SENT message, 
#it is only used if you sent a message successfully with status report enabled. 

if [ "$1" == "SENT" ]; then 
	mail -s "SMS $3 verschickt" markus.dorn@gmx.de <$2
	exit; 
fi


#run this script only when a message was received.
if [ "$1" != "RECEIVED" ]; then exit; fi;

#Define the database parameters
SQL_HOST=localhost
SQL_USER=dorn
SQL_PASSWORD=test
SQL_DATABASE=sms
SQL_incoming=incoming
SQL_contact=contact

#Extract data from the SMS file
FROM=`formail -zx From: < $2`
RECEIVED=`formail -zx Received: < $2`
TEXT=`formail -I "" <$2 | sed -e"1d"`

SQL_ARGS="-p$SQL_PASSWORD -h $SQL_HOST -u $SQL_USER $SQL_ARGS -D $SQL_DATABASE -s -e"

#Do the SQL Query
NAME=`mysql $SQL_ARGS "select Name from $SQL_contact where Number=\"+$FROM\";"`
#echo mysql $SQL_ARGS "select Name from $SQL_contact where Number=\"+$FROM\";"

#Do the SQL Query
insert=`mysql $SQL_ARGS "INSERT INTO $SQL_incoming (Name,Number,Message,Datum) VALUES (\"$NAME\",\"$FROM\",\"$TEXT\",\"$RECEIVED\");"`
#echo mysql $SQL_ARGS "INSERT INTO $SQL_incoming (Name,Number,Message,Datum) VALUES (\"$NAME\",\"$FROM\",\"$TEXT\",\"$RECEIVED\");"

mail -s "SMS von $NAME $FROM" markus.dorn@gmx.de <$2
