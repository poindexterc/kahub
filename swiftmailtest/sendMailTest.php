<?
require_once 'lib/swift_required.php';

//Create the Transport
$transport = Swift_SmtpTransport::newInstance('imap.gmail.com', 25)
  ->setUsername('colinp')
  ->setPassword('m2917712!dexter')
  ;

/*
You could alternatively use a different transport such as Sendmail or Mail:

//Sendmail
$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

//Mail
$transport = Swift_MailTransport::newInstance();
*/

//Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

//Create a message
$message = Swift_Message::newInstance('Mail Test')
  ->setFrom(array('cpoindex@fandm.edu' => 'Colin Poindexter'))
  ->setTo(array('poindexterc@gmail.com'))
  ->setBody('Here is the message itself')
  ;

//Send the message
$result = $mailer->send($message);
?>