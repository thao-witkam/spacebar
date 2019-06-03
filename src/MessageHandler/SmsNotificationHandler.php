<?php

namespace App\MessageHandler;


use App\Message\SmsNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SmsNotificationHandler implements MessageHandlerInterface
{
    public function __invoke(SmsNotification $message)
    {
        dump(date('H:i:s').' - ' .$message->getContent());
        dump('Send email to: ', $message->getParams());

    }
}