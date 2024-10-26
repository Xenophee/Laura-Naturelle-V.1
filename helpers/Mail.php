<?php


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


class Mail
{

    private const HOST = 'smtp.gmail.com';
    private const SMTP_AUTH = true;
    private const USERNAME = 'perrine.dassonville@gmail.com';
    private const PASSWORD = 'upol ojty smrk wqbq';
    private const SMTP_SECURE = PHPMailer::ENCRYPTION_SMTPS;
    private const PORT = 465;
    private const CHARSET = 'utf-8';
    private const FROM_EMAIL = 'perrine.dassonville@gmail.com';
    private const FROM_NAME = 'L\'Aura Natur\'elle - Notification';


    public static function send_mail(array $data, bool $contact_form = false)
    {
        $mail = new PHPMailer(true);
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        $mail->isSMTP();
        $mail->Host = self::HOST;
        $mail->SMTPAuth = self::SMTP_AUTH;
        $mail->Username = self::USERNAME;
        $mail->Password = self::PASSWORD;
        $mail->SMTPSecure = self::SMTP_SECURE;
        $mail->Port = self::PORT;
        $mail->CharSet = self::CHARSET;
        $mail->setFrom(self::FROM_EMAIL, self::FROM_NAME);


        if ($contact_form) {
            $mail->addAddress(self::FROM_EMAIL);
            $mail->addReplyTo($data['addReplyTo']);
        } else {
            $mail->addAddress($data['to']);
        }
        
        $mail->isHTML(true); 
        $mail->Subject = $data['object'];
        $mail->Body = $data['content'];

        return (!$mail->send()) ? $mail->ErrorInfo : true;
    }
}
