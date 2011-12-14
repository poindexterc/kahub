<?php
/*
 * This example is used for Swift Mailer V4
 */
include "lib/swift_required.php";
include 'SmtpApiHeader.php';
 
$hdr = new SmtpApiHeader();
 
// The list of addresses this message will be sent to
// [This list is used for sending multiple emails using just ONE request to SendGrid]
$toList = array('poindexterc@gmail.com');
 
// Specify the names of the recipients
$nameList = array('Colin Poindexter');
 
// Used as an example of variable substitution
 
// Set all of the above variables
$hdr->addTo($toList);
$hdr->addSubVal('-name-', $nameList);
 
// Specify that this is an initial contact message
$hdr->setCategory("initial");
 
// You can optionally setup individual filters here, in this example, we have enabled the footer filter
$hdr->addFilterSetting('footer', 'enable', 1);
$hdr->addFilterSetting('footer', "text/plain", "Thank you for your business");
 
// The subject of your email  
$subject = 'Example SendGrid Email';
 
// Where is this message coming from.  For example, this message can be from support@yourcompany.com, info@yourcompany.com
$from = array('startsharing@kahub.com' => 'kahub');
 
// If you do not specify a sender list above, you can specifiy the user here.  If a sender list IS specified above
// This email address becomes irrelevant.
$to = array('poindexterc@gmail.com'=>'Colin Poindexter');
 
# Create the body of the message (a plain-text and an HTML version).
# text is your plain-text email
# html is your html version of the email
# if the reciever is able to view html emails then only the html
# email will be displayed

/*
 * Note the variable substitution here =)
 */
$text = <<<EOM
Hello -name-,
 
Thank you for your interest in our products. We have set up an appointment
to call you at -time- EST to discuss your needs in more detail.
 
Regards,
Fred
EOM;
 
$html = <<<EOM
<html>
  <head></head>
  <body>
    <p>Hello -name-,<br>
       Thank you for your interest in our products. We have set up an appointment
             to call you at -time- EST to discuss your needs in more detail.
 
                Regards,
 
                FredHow are you?<br>
    </p>
  </body>
</html>
EOM;
 
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
$message->setBody($html, 'text/html');
$message->setTo($to);
$message->addPart($text, 'text/plain');
 
// send message 
if ($recipients = $swift->send($message, $failures))
{
  // This will let us know how many users received this message
  // If we specify the names in the X-SMTPAPI header, then this will always be 1.  
  echo 'Message sent out to '.$recipients.' users';
}
// something went wrong =(
else
{
  echo "Something went wrong - ";
  print_r($failures);
}
?>