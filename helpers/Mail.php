<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class Mail
{
    private $host;
    private $username;
    private $password;
    private $port;
    private $fromEmail;
    private $fromName;

    private const SMTP_AUTH = true;
    private const SMTP_SECURE = PHPMailer::ENCRYPTION_SMTPS;
    private const CHARSET = 'utf-8';

    public function __construct()
    {
        $this->host = $_ENV['MAIL_SMTP_HOST'] ?? throw new Exception('MAIL_SMTP_HOST manquant');
        $this->username = $_ENV['MAIL_USERNAME'] ?? throw new Exception('MAIL_USERNAME manquant');
        $this->password = $_ENV['MAIL_PASSWORD'] ?? throw new Exception('MAIL_PASSWORD manquant');
        $this->port = $_ENV['MAIL_PORT'] ?? throw new Exception('MAIL_PORT manquant');
        $this->fromEmail = $_ENV['MAIL_FROM_ADDRESS'] ?? throw new Exception('MAIL_FROM_ADDRESS manquant');
        $this->fromName = $_ENV['MAIL_FROM_NAME'] ?? throw new Exception('MAIL_FROM_NAME manquant');
    }

    public function send_mail(array $data, bool $contact_form = false)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = self::SMTP_AUTH;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = self::SMTP_SECURE;
        $mail->Port = $this->port;
        $mail->CharSet = self::CHARSET;
        $mail->setFrom($this->fromEmail, $this->fromName);

        if ($contact_form) {
            $mail->addAddress($this->fromEmail);
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
