<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendMail($email, $name){
    /*try {*/
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        //$mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'https://webserver2.pebblehost.com/';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'info@astridnetwork.net';                 // SMTP username
        $mail->Password = 'InsAi$d%shsx546';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 2096;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('info@astridnetwork.net', 'Astrid Network');
        $mail->addAddress($email, $name);     // Add a recipient


        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //echo 'Message has been sent';
    //}
}
