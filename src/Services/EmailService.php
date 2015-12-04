<?php

namespace SendATruck\Services;

class EmailService
{

    private $mailer;

    public function __construct()
    {
        $transport = \Swift_SmtpTransport::newInstance(SMTP_HOSTNAME, SMTP_PORT)
            ->setUsername(SMTP_USERNAME)
            ->setPassword(SMTP_PASSWORD);
        $this->mailer = \Swift_Mailer::newInstance($transport);
    }

    public function mail($sender, $recipient, $subject, $message)
    {
        $emailMessage = \Swift_Message::newInstance();
        $emailMessage->setFrom($sender)
            ->setTo($recipient)
            ->setSubject($subject)
            ->setBody($message);

        return $this->mailer->send($emailMessage);
    }
}
