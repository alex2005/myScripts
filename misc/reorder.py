#!/usr/bin/env python

AES_HASH = '16794c20640d4544'

SQLSTRING='''INSERT INTO virtual_users 
(domain_id, loginuser, password, username, mailprotect, quota, editlevel, active) 
VALUES 
( 2, "%s", %s, "%s", 0, 0, 0, 1 )'''

myFile= open( "user.sql", "rU" )
for aRow in myFile:
    fields = aRow.split('\t')
    #alt: uid	email	cryptpass	clearpass	username	mailprotect	quota	quota_exceeded	active	signature
    #neu: id	domain_id	loginuser	password		username	datacomment	mailprotect	quota	editlevel	active	signature

    if fields[3] == "":
    	AESSTRING = "AES_ENCRYPT('secure','"+ AES_HASH +"')"
    else:
	AESSTRING = "AES_ENCRYPT('"+fields[3]+"','"+ AES_HASH +"')"
    
    if fields[4] != "username":
        print SQLSTRING % ( fields[4], AESSTRING, fields[4] )

myFile.close()
