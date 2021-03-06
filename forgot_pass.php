<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../CODE/Tools/PHP_mailer/src/Exception.php';
require '../CODE/Tools/PHP_mailer/src/PHPMailer.php';
require '../CODE/Tools/PHP_mailer/src/SMTP.php';
// require 'config/db_config_reset_passwords.php';

// Instantiation and passing `true` enables exceptions
class Pass_recovery{
    public function send_pass_to_fpass_email($fpass_email){
        $code = uniqid(true);
        $sql = "INSERT INTO reset_passwords (code, email) VALUES ('$code','$fpass_email')";
        DB::run($sql);
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'MY_EMAIL@gmail.com';                     // SMTP username
            $mail->Password   = 'MY_PASSWORD';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('MY_EMAIL@gmail.com', 'Password Reset!');
            $mail->addAddress($fpass_email);     // Add a recipient
            $mail->addReplyTo('no-reply@MY_EMAIL.com', 'No Reply');


            // Attachments

            // Contentmvc
            $url =  $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . "/forgot_pass_view.php?code=$code";
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Password Reset Link!';
            $mail->Body    = "
            <h1>Hi!<br> If you would like to reset your password, please follow <a href='$url'> this link </a> to complete this process!</h1><br>This email was created by one of our robot space monkeys, please do not reply. Thank you!
            ";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Password recovery link has been sent to your provided email address!';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
