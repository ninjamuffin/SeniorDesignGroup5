<?php 
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                          // Enable verbose debug output

$mail->isSMTP();                                        // Set mailer to use SMTP 
$mail->Host = 'smtp.sendgrid.net';             // Specify main/backup SMTP servers 
$mail->SMTPAuth = true;                           // Enable SMTP authentication 
$mail->Username = 'azure_5bd642a0489f3afd016635593cc81f09@azure.com';    // SMTP username 
$mail->Password = '!1Elcwebappemail';    // SMTP password 
$mail->SMTPSecure = 'tls';                        // Enable TLS/SSL encryption 
$mail->Port = 587;                                      // TCP port to connect to

$mail->From = 'azure_5bd642a0489f3afd016635593cc81f09@azure.com'; 
$mail->FromName = 'Smalltalk Automatic Email'; 

$mail->WordWrap = 50;                              // Set word wrap to 50 characters 
$mail->isHTML(true);                                  // Set email format to HTML

?>
<!--  Required Lines for sending Email
$mail->addAddress('support@contoso.com', 'Support');     // Add a recipient
$mail->Subject = 'Here is the subject'; 
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';

if(!$mail->send()) { 
    echo 'Message could not be sent.'; 
    echo 'Mailer Error: ' . $mail->ErrorInfo; 
} else { 
    echo 'Message has been sent'; 
}
-->


<!-- Command Reference
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'user@example.com';                 // SMTP username
$mail->Password = 'secret';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('from@example.com', 'Mailer');
$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');

$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
-->