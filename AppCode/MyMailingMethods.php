<?php
require_once 'ApplicationSettings.php';
require_once 'HelpingDBMethods.php'; 
include "lib/swift_required.php";
include 'SmtpApiHeader.php';
//require_once "Mail.php";
class MyMailingMethods
{
	function GeneralMailSMTP($to, $body, $headers, &$response)
	{		
		$host = "ssl://smtp.gmail.com";
		$port = "465";
		$username = "knightofagez@gmail.com";
		$password = "password";
		
		$smtp = Mail::factory('smtp',
				array ('host' => $host,
					'port' => $port,
					'auth' => true,
					'username' => $username,
					'password' => $password));
		
		$mail = $smtp->send($to, $headers, $body);
		
		if (PEAR::isError($mail)) 
		{
			$response = $mail->getMessage();
			return false;
		} 
		else 
		{
			$response = "Message successfully sent!";
			return true;
		}
	}
	
	function GeneralMail($to, $subject, $message, $headers, &$response)
	{
		$IsMailSent = mail($to, $subject, $message, $headers);
		if ($IsMailSent == true)
		{
             $response = "Your message was successfully delivered. The website administrator will contact you within 24 hours.";
		}
		else
		{
		    $response = "Your message was not delivered because of some technical issue. Please try again later.";
		}
		
		return $response;
	}
	
	function SendNotificationMail($NType, $data)
	{
		$headers =  'From: FROM' . "\r<br>";
		$status = false;
		if($NType == 1)
		{
			// reply on comment
			$ActionByName = MemberDBMethods::GetUserName($data['ActionBy']);
			$ActionToName = MemberDBMethods::GetUserName($data['AddressedTo']);
			$to = MemberDBMethods::GetUserEmail($data['AddressedTo']);
			$AddressedToName = MemberDBMethods::GetFirstname($data['AddressedTo']);
			$subject = $ActionByName . ' just replied to something you said...';
			$body = <<<Body
Hiya {$AddressedToName}, <br>

We thought you'd like to know that {$ActionByName} just replied to something you said. Nice!<br>
		
Check out what {$ActionByName} said by going to http://www.kahub.com<br><br>
		
Love,<br>
Your buds at kahub!<br><br><br>
		
		
----<br>
This message was intended for {$to}.<br>
You have received this message because you are currently a member of kahub, and have not opted-out of receiving this kind of email notification.<br>
To stop receiving email notifications like this one, visit http://www.kahub.com/settings<br><br><br><br>



ipsumedia Limited 333 E. Lancaster Ave. #313, Wynnewood, PA 19096.
Body;
        if($to!=""){
		    $hdr = new SmtpApiHeader();

		// The list of addresses this message will be sent to
		// [This list is used for sending multiple emails using just ONE request to SendGrid]

		// Specify the names of the recipients

		// Used as an example of variable substitution

		// Set all of the above variables

		// Specify that this is an initial contact message
		    $hdr->setCategory("reply");

		// You can optionally setup individual filters here, in this example, we have enabled the footer filter
		    $hdr->addFilterSetting('footer', 'enable', 1);
		    $hdr->addFilterSetting('footer', "text/plain", "Thanks for using kahub!");

		// The subject of your email  

		// Where is this message coming from.  For example, this message can be from support@yourcompany.com, info@yourcompany.com
		    $from = array('notifications@kahub.com' => 'kahub');

		// If you do not specify a sender list above, you can specifiy the user here.  If a sender list IS specified above
		// This email address becomes irrelevant.
		    $toEmail = array($to=>$ActionToName);

		# Create the body of the message (a plain-text and an HTML version).
		# text is your plain-text email
		# html is your html version of the email
		# if the reciever is able to view html emails then only the html
		# email will be displayed

		/*
		 * Note the variable substitution here =)
		 */

		// Your SendGrid account credentials
		    $username = 'USER';
		    $password = 'PASS';

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
		    }
		// something went wrong =(
		    else
		    {
		        echo "Something went wrong - ";
		        print_r($failures);
		    }
	    }
		}
		elseif($NType == 2)
		{
			// friend request
			$ActionByName = MemberDBMethods::GetUserName($data['ActionBy']);
			$ActionToName = MemberDBMethods::GetUserName($data['AddressedTo']);
			$to = MemberDBMethods::GetUserEmail($data['AddressedTo']);
			$AddressedToName = MemberDBMethods::GetFirstname($data['AddressedTo']);
			
			$subject = $ActionByName . ' has requested to add you as a source...';
			$body = <<<Body
Howdy {$AddressedToName},<br><br>
		
{$ActionByName} has requested to add you as a friend on kahub. Yay! (or Boo!, depending...)<br><br>
		
To accept (or quietly ignore) {$ActionByName}'s request visit: http://www.kahub.com<br><br>
		
Love,<br>
Your boy kahub<br><br><br>
			
	
----<br>
This message was intended for {$to}.<br>
You have received this message because you are currently a member of kahub, and have not opted-out of receiving this kind of email notification.<br>
To stop receiving email notifications like this one, visit http://www.kahub.com/settings<br><br><br><br>



ipsumedia Limited 333 E. Lancaster Ave. #313, Wynnewood, PA 19096.
Body;
		$hdr = new SmtpApiHeader();

		// The list of addresses this message will be sent to
		// [This list is used for sending multiple emails using just ONE request to SendGrid]

		// Specify the names of the recipients

		// Used as an example of variable substitution

		// Set all of the above variables

		// Specify that this is an initial contact message
		$hdr->setCategory("sourceRequest");

		// You can optionally setup individual filters here, in this example, we have enabled the footer filter
		$hdr->addFilterSetting('footer', 'enable', 1);
		$hdr->addFilterSetting('footer', "text/plain", "Thanks for using kahub!");

		// The subject of your email  

		// Where is this message coming from.  For example, this message can be from support@yourcompany.com, info@yourcompany.com
		$from = array('FROM' => 'kahub');

		// If you do not specify a sender list above, you can specifiy the user here.  If a sender list IS specified above
		// This email address becomes irrelevant.
		$toEmail = array($to=>$ActionToName);

		# Create the body of the message (a plain-text and an HTML version).
		# text is your plain-text email
		# html is your html version of the email
		# if the reciever is able to view html emails then only the html
		# email will be displayed

		/*
		 * Note the variable substitution here =)
		 */

		// Your SendGrid account credentials
		$username = 'USER';
		$password = 'PASS';

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
		}
		// something went wrong =(
		else
		{
		  echo "Something went wrong - ";
		  print_r($failures);
		}
		}
		elseif($NType == 3)
		{
			// friend request accepted
			$ActionByName = MemberDBMethods::GetUserName($data['ActionBy']);
			$ActionToName = MemberDBMethods::GetUserName($data['AddressedTo']);
			$to = MemberDBMethods::GetUserEmail($data['AddressedTo']);
			$AddressedToName = MemberDBMethods::GetFirstname($data['AddressedTo']);
			$subject = $ActionByName . ' has confirmed you as a friend...';
			$body = <<<Body
Hola {$AddressedToName}, <br><br>
		
{$ActionByName} has confirmed you as a friend on kahub. Sweet! <br><br>
		
To see what {$ActionByName}'s been up to, go to http://www.kahub.com<br><br>
		
Love,<br>
Your friends at kahub!<br><br><br>
		
		
----<br>
This message was intended for {$to}.<br>
You have received this message because you are currently a member of kahub, and have not opted-out of receiving this kind of email notification.<br>
To stop receiving email notifications like this one, visit http://www.kahub.com/settings<br><br><br><br>



ipsumedia Limited 333 E. Lancaster Ave. #313, Wynnewood, PA 19096.
Body;
		$hdr = new SmtpApiHeader();

		// The list of addresses this message will be sent to
		// [This list is used for sending multiple emails using just ONE request to SendGrid]

		// Specify the names of the recipients

		// Used as an example of variable substitution

		// Set all of the above variables

		// Specify that this is an initial contact message
		$hdr->setCategory("sourceApprove");

		// You can optionally setup individual filters here, in this example, we have enabled the footer filter
		$hdr->addFilterSetting('footer', 'enable', 1);
		$hdr->addFilterSetting('footer', "text/plain", "Thanks for using kahub!");

		// The subject of your email  

		// Where is this message coming from.  For example, this message can be from support@yourcompany.com, info@yourcompany.com
		$from = array('FROM NAME' => 'kahub');

		// If you do not specify a sender list above, you can specifiy the user here.  If a sender list IS specified above
		// This email address becomes irrelevant.
		$toEmail = array($to=>$ActionToName);

		# Create the body of the message (a plain-text and an HTML version).
		# text is your plain-text email
		# html is your html version of the email
		# if the reciever is able to view html emails then only the html
		# email will be displayed

		/*
		 * Note the variable substitution here =)
		 */

		// Your SendGrid account credentials
		$username = 'user';
		$password = 'pass';

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
		}
		// something went wrong =(
		else
		{
		  echo "Something went wrong - ";
		  print_r($failures);
		}
		}
		elseif($NType == 4)
		{
			//badge recieved 
			$AddressedToName = MemberDBMethods::GetFirstname($data['AddressedTo']);
			$BadgeName = HelpingDBMethods::GetBadgeName($data['BadgeID']);
			$BadgeDesc = HelpingDBMethods::GetBadgeDescription($data['BadgeID']);
			
			$to = MemberDBMethods::GetUserEmail($data['AddressedTo']);
			$subject = 'You\'ve just unlocked a new badge on connichiwah...';
			$body = <<<Body
Congrats {$AddressedToName}! 
			
You've just unlocked the {$BadgeName} badge on kahub!

{$BadgeDesc}

Now, give yourself a good pat on the back and check out your new shiny badge at http://www.kahub.com
	
You've earned it! 
			
Love,
Your homies at kahub
			
			
----
This message was intended for {$to}.
You have received this message because you are currently a member of kahub, and have not opted-out of receiving this kind of email notification.
To stop receiving email notifications like this one, visit http://www.kahub.com/settings



ipsumedia Limited 333 E. Lancaster Ave. #313, Wynnewood, PA 19096.
Body;
			MyMailingMethods::GeneralMail($to, $subject, $body, $headers, $status);
		}
		elseif($NType == 5)
		{
			// shared somthing
			$ActionByName = MemberDBMethods::GetUserName($data['ActionBy']);
			$to = MemberDBMethods::GetUserEmail($data['AddressedTo']);
			$AddressedToName = MemberDBMethods::GetFirstname($data['AddressedTo']);
			
			$subject = $ActionByName . ' has shared something with you on kahub. It\'s ultra stealthy...';
			$body = <<<Body
Pssst, {$AddressedToName}, wanna hear a seacret?

{$ActionByName} has	shared something with you, and only you on kahub.

Read what they wanted you to see at http://www.kahub.com

Love,
Your amigos at kahub

			
----
This message was intended for {$to}.
You have received this message because you are currently a member of kahub, and have not opted-out of receiving this kind of email notification.
To stop receiving email notifications like this one, visit http://www.kahub.com/settings



ipsumedia Limited 333 E. Lancaster Ave. #313, Wynnewood, PA 19096.
Body;
			MyMailingMethods::GeneralMail($to, $subject, $body, $headers, $status);
		}
		elseif($NType == 6)
		{
			// badge brag
			$ActionByName = MemberDBMethods::GetUserName($data['ActionBy']);
			$BadgeName = HelpingDBMethods::GetBadgeName($data['BadgeID']);
			$to = MemberDBMethods::GetUserEmail($data['AddressedTo']);
			$AddressedToName = MemberDBMethods::GetFirstname($data['AddressedTo']);
			$subject = $ActionByName . ' has unlocked the ' . $BadgeName . ' badge, and wanted you to know about it...';
			$body = <<<Body
Hey there {$AddressedToName},

{$ActionByName} wanted you to know that they've unlocked the {$BadgeName} badge on kahub.
			
Don't take that lying down, you can get that {$BadgeName} badge too, and show {$ActionByName} who's really boss by commenting on some more stuff, and trusting more people. 
			
See some suggestions of some stuff to comment on at http://www.kahub.com
	
You can find some people trust by adding some more friends. If you're logged into Facebook, we've made it super easy to find your Facebook friends, already on connichiwah: http://www.kahub.com/member/Registration.php?action=0
	
			
Love,
Your pals at kahub!
			
			
----
This message was intended for {$to}.
You have received this message because you are currently a member of kahub, and have not opted-out of receiving this kind of email notification.
To stop receiving email notifications like this one, visit http://www.kahub.com/settings
			


ipsumedia Limited 333 E. Lancaster Ave. #313, Wynnewood, PA 19096.
Body;
			MyMailingMethods::GeneralMail($to, $subject, $body, $headers, $status);
		}
	}
}
?>