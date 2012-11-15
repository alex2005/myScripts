<?

	// Database settings
	
	$MySQL_Host="localhost";			// Your MySQL-Host
	$MySQL_User="dorn";		// Your MySQL-Username
	$MySQL_Passw="";		// Your MySQL-Password
	$db="sms";				// Database to be used
	
	// Account settings
	
	$email = "dorn@kip.uni-heidelberg.de";			// The username of your MTNSMS-Account
	$password = "yourpassword";		// The password of your MTNSMS-Account

	// Siganture

	$signature = "yoursignature";		// The signature which is use when you send a message, 
						// can be left blank
	
	// Message Length
	
	$MaxLengthOfMessage = 160;		// The allowed length of the SMS message, maximum for SMS 
						// at mtnsms is 143 due to advertising
									
	// Email settings

	$EmailSender = "you";			// The name which should appear as sender
	$EmailSubject = "Message from MySMS";	// The subject which should be shown in the email
	$EmailSignature = TRUE;			// Whether to use the signature in the email
	$EmailReplyAddress = "replyadress";	// The email address on which you want to receive the replies
	$EmailServerName = "servername";	// The name of your server; can be a fantasy name
	
	$debug = "0";
?>
