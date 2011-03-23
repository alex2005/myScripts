****** Guide to MySMS v.0.2 by Tobi ******

Hi!

Thanks for using MySMS! If you've got any comments
or suggenstions, please feel free to contact me
via my email address migh_t@gmx.de!

This is the first version of MySMS, a tool to send
SMS messages with the MTNSMS-"Gateway".

URL: http://www.cms4u.com/php/mysms/

What you need is:

- A MTNSMS-Account (http://www.mtnsms.com)
- James McGlinn's JM_SMS (http://james.mcglinn.org/jm_sms/)
  I recommend the use of the newest version
- the files that are contained in this ZIP-file
- a PHP and MySQL-enabled webspace
- a running mailserver

Installation:

- create a new folder
- unzip the files into that folder
- unzip JM_SMS in the same folder
- create a new MySQL-DB ( type on your shell: mysqladmin -u username password create sms )
- create the needed tables ( type on your shell: mysql -u username password < mysms.sql )
- if you only have a free webspace account with PHP and MySQL-Support I recommend that
  you use PHPMyAdmin which can be obtained from http://phpwizard.net/phpMyAdmin/
  It provides the same functionality, so that you don't need a shell
  In the same case, if you aren't able to create a database, just edit the mysms.sql file
  to set the db to the right value ( 4th step isn't needed anymore... )
- edit the values in config.php: set the right values for the db-connection, 
  your MTNSMS-Username and -Password. You can also choose a signature. Add the right information
  for your mailserver
- On Linux machines: set the appropriate rights of the php files: CHMOD 755

- NOW YOU ARE READY TO GO! HAVE FUN!

Know issues:

- if the server is too slow, the jm_sms-script can time out. On my machine there's no problem
  with the execution time. On other servers, especially on free webspace servers, it's possible
  that this problem occurs.

History:

- v.0.2: Added mail support. Now you can send mails to any mobile phone that supports them
- v.0.1: First version with basic functionality