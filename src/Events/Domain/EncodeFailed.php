<?php

namespace App\Events\Domain;

use Exception;
use Throwable;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EncodeFailed extends Exception
{
    public function __construct(
        string $message = 'Error occurred during encoding',
        int $statusCode = 500,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $previous);
        $this->sendEmail($message);
    }

    private function sendEmail(string $errorMessage): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp-mail.outlook.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tini.ramonda@gmail.com';
            $mail->Password = '';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tini.ramonda@gmail.com');
            $mail->addAddress('tini.ramonda@gmail.com');

            $mail->isHTML();
            $mail->Subject = 'Error de codificación en la aplicación';
            $mail->Body = 'Se ha producido un error durante la codificación: ' . $errorMessage;
            $mail->send();
        } catch (PHPMailerException $e) {
            print_r($e->getMessage());
        }
    }
}
