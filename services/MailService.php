<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    protected $setting;

    public function __construct()
    {
        $this->setting =
            (new Setting())->get();
    }

    public function send(
        string $to,
        string $subject,
        string $html
    )
    {
        try {

            $mail = new PHPMailer(true);

            $mail->isSMTP();

            $mail->Host =
                $this->setting->smtp_host;

            $mail->SMTPAuth = true;

            $mail->Username =
                $this->setting->smtp_username;

            $mail->Password =
                $this->setting->smtp_password;

            $mail->SMTPSecure =
                $this->setting->smtp_encryption;

            $mail->Port =
                $this->setting->smtp_port;

            $mail->setFrom(
                $this->setting->smtp_email,
                $this->setting->site_name
            );

            $mail->addAddress($to);

            $mail->isHTML(true);

            $mail->Subject = $subject;

            $mail->Body = $html;

            $mail->send();

            return true;

        } catch (Throwable $e) {

            ErrorHandler::log(
                'MAIL_ERROR',
                $e->getMessage()
            );

            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Email
    |--------------------------------------------------------------------------
    */

    public function sendBulk(
        array $emails,
        string $subject,
        string $html
    )
    {
        foreach ($emails as $email) {

            $this->send(
                $email,
                $subject,
                $html
            );
        }

        return true;
    }
}