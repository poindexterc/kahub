<?php
 $to = "mwaboff@gmail.com";
 $subject = "Hi!";
 $body = "Hi,\n\nHow are you?";
 $mail = mail($to, $subject, $body);
 if ($mail) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
 ?>