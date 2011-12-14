<?
include "lib/swift_required.php";
class reset{
function resetPass($code, $email){
	

			$subject ='Password Reset';
			$body = <<<Body
Hello, <br>
		
Someone, (probably you) requested that thier kahub password be reset. If this was not you, <a href="http://www.kahub.com/l/badpass.php"> click here.</a><br />
		
Otherwise, please <a href="http://www.kahub.com/resetpassVeri.php?p={$code}&e={$email}">click here</a> to create a new password.<br />

Yours, <br />
The kahub Team<br /><br /><br />

If this does not display properly in your browser, please follow this link: http://www.kahub.com/resetpassVeri.php?p={$code}&e={$email} <br /><br />

		
----<br />
This message was intended for {$to}.<br>
You have received this message because you are currently a member of kahub, and someone requested that your password be reset<br /><br />



ipsumedia Limited 333 E. Lancaster Ave. #313, Wynnewood, PA 19096.
Body;
		$hdr = new SmtpApiHeader();

		// The list of addresses this message will be sent to
		// [This list is used for sending multiple emails using just ONE request to SendGrid]

		// Specify the names of the recipients

		// Used as an example of variable substitution

		// Set all of the above variables

		// Specify that this is an initial contact message
		$hdr->setCategory("passReset");

		// You can optionally setup individual filters here, in this example, we have enabled the footer filter
		$hdr->addFilterSetting('footer', 'enable', 1);
		$hdr->addFilterSetting('footer', "text/plain", "Thanks for using kahub!");

		// The subject of your email  

		// Where is this message coming from.  For example, this message can be from support@yourcompany.com, info@yourcompany.com
		$from = array('notifications@kahub.com' => 'kahub');

		// If you do not specify a sender list above, you can specifiy the user here.  If a sender list IS specified above
		// This email address becomes irrelevant.
		$toEmail = array($email=>$email);

		# Create the body of the message (a plain-text and an HTML version).
		# text is your plain-text email
		# html is your html version of the email
		# if the reciever is able to view html emails then only the html
		# email will be displayed

		/*
		 * Note the variable substitution here =)
		 */

		// Your SendGrid account credentials
		$username = 'kahub';
		$password = 'm2917712';

		// Create new swift connection and authenticate
		$transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 25);
		$transport ->setUsername($username);
		$transport ->setPassword($password);
		$swift = Swift_Mailer::newInstance($transport);

		// Create a message (subject)
		$message = new Swift_Message($subject);

		// add SMTPAPI header to the message
		$headers = $message->getHeaders();
		$headers->addTextHeader('X-SMTPAPI', $hdr->asJSON());

		// attach the body of the email
		$message->setFrom($from);
		$message->setBody($body, 'text/html');
		$message->setTo($toEmail);

		// send message 
		if ($recipients = $swift->send($message, $failures))
		{
		  // This will let us know how many users received this message
		  // If we specify the names in the X-SMTPAPI header, then this will always be 1.  
		  //echo 'Message sent out to '.$recipients.' users';
                  echo "A password-reset email has been sent. Automagically redirecting you to the homepage in 3 seconds...<br \><br \>If your webbrowser does not redirect, go to <a href='http://www.kahub.com'>www.kahub.com</a>";
                  echo '<meta http-equiv="refresh" content="3; URL=http://www.kahub.com">' ;
		}
		// something went wrong =(
		else
		{
		  echo "Oh no! Something went wrong :( Please email the contents of this page to bugs at kahub.com - ";
		  print_r($failures);
		}
}
}
