
A GO1/GO Start script
	
Thank you for purchasing our beta splash page signup form. We hope you enjoy using it. 

Installation should be straightforward. Simply upload all files to your web host and then it's ready to go. There is no need to create and link up to a database as this script stores data in a CSV file which it will create on the server. 


For help please email support@go1.com.au


+++++++++++++++++++++++++++++++++++
HOW TO DOWNLOAD THE CSV OF EMAILS /
+++++++++++++++++++++++++++++++++++

Go to http://yoursite.com/beta-script/index.php?pass=$exportPass. 
$exportPass is set in index.php and then click 'Export all entries'

- OR - 

Download data.csv via FTP


+++++++++++++++++++++++++++++++++++
CUSTOMISATIONS ////////////////////
+++++++++++++++++++++++++++++++++++

You can customise the script options by:

index.php

	$name = 0; 		// hides the name input field
	$name = 1; 		// shows the name field to users

	$successMessage = ""; 	// change this to the message you would like to display to users when the form 
				// is successfully submitted

	$exportPass = ""; 	// IMPORTANT - change this to something secure. 
				// By going to http://yoursite.com/beta-script/index.php?export=true&pass=$exportPass 
				// you will be able to download the CSV of submitted values

submit.php

	$successMessage = ""; 	// change this to the message you would like to display to users when the form 
				// is successfully submitted (without JavaScript)
	$emailRequired = ""; 	// change this to the message you would like to display to users when an invalid 
				// email is sent (without JavaScript)


Before using this on a live site you should also delete line 8 to 10 in index.php where it says:

	/* Delete This */
	$_REQUEST['pass']=$exportPass; 
	/* End Delete */

... as this is used to allow you to quickly access the download in the demo version and while testing/setting up. 

+++++++++++++++++++++++++++++++++++
THE END ///////////////////////////
+++++++++++++++++++++++++++++++++++

Remember, for any help or customisation requests please email support@go1.com.au


Enjoy!