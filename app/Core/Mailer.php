<?php

declare(strict_types=1);

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

class Mailer
{
    public static function send(string $to, string $name, string $subject, string $body): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $_ENV["MAIL_HOST"];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV["MAIL_USERNAME"];
            $mail->Password = $_ENV["MAIL_PASSWORD"];
            $mail->SMTPSecure = $_ENV["MAIL_ENCRYPTION"] === "tls"
                ? PHPMailer::ENCRYPTION_STARTTLS
                : PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = (int) $_ENV["MAIL_PORT"];

            if (($_ENV["APP_ENV"] ?? "development") === "development") {
                $mail->SMTPOptions = [
                    "ssl" => [
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true,
                    ]
                ];
            }

            $mail->setFrom(
                $_ENV["MAIL_FROM_ADDRESS"],
                $_ENV["MAIL_FROM_NAME"]
            );
            $mail->addAddress($to, $name);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body);
            $mail->CharSet = "UTF-8";
            $mail->send();
        } catch (MailerException $e) {
            error_log("Mailer error:" . $e->getMessage());
            throw new \RuntimeException("Failed to send email. Please try again later");
        }
    }

    public static function render(string $template, array $data = []): string
    {
        $path = ROOT_PATH . "/app/Views/emails/" . $template . ".php";

        if (!file_exists($path)) {
            throw new \RuntimeException("Email template not found: {$template}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $path;
        return ob_get_clean();
    }
}