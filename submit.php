<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php 
$successMessage = '<h1>Thank you for your interest!</h1><p>Get some of your friends to sign up too, and get earlier access</p>';
																			
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Beta Splash Page</title>
</head>

<body>


<!--main div start -->
    	<div id="mainDiv" class="emailForm3Bg">
        	<!--opacity part start -->
            	<div class="opacityDiv">
                	<!--left part start -->
                    	<div id="left">
                       	  <h2>hello there!</h2>
                            <p>It’s nice to see that you’re interested in our site.<br />
                            Enter your details and we’ll notify you on launch!</p>
                        </div>
                    <!--left part end -->
                    <!--right part start -->
                    	<div id="right">
<?php
$file = 'data.csv';
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$time = time();
$additional = array($name,$email,$time);

if($email!=""&&$email!="Email"){
	$fp = fopen($file, 'a');
	fputcsv($fp, $additional, ',');
	fclose($fp); 
	chmod($file,0600);
	echo $successMessage;
}else{
	?> <h1>Sorry!</h1><p>Your email address is required. <a href="index.php">Click here to go back</a></p><?php
}?>
                                </div>
                        </div>
                    <!--right part end -->
                	<br class="spacer" />
                </div>
            <!--opacity part end -->
        </div>
    <!--main div end -->
</body>
</html>


<?php 

/*function fputcsv($fp, $arr, $del=",", $enc="\"") {
    fwrite($fp, (count($arr)) ? $enc . implode("{$enc}{$del}{$enc}", str_replace("\"", "\"\"", $arr)) . $enc . "\n" : "\n");
} */
?>