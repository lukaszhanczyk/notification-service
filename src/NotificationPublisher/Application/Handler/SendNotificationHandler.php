<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Infrastructure\Client\AwsSesClient;

class SendNotificationHandler
{
    private SendNotificationTwilioHandler $sendNotificationTwilioHandler;
    private SendNotificationAwsSesHandler $sendNotificationAwsSesHandler;

    public function __construct(
        SendNotificationTwilioHandler $sendNotificationTwilioHandler,
        SendNotificationAwsSesHandler $sendNotificationAwsSesHandler,
    )
    {
        $this->sendNotificationTwilioHandler = $sendNotificationTwilioHandler;
        $this->sendNotificationAwsSesHandler = $sendNotificationAwsSesHandler;
    }

    public function handle(SendNotificationCommand $command): void
    {
        $this->sendNotificationTwilioHandler->handle($command);
        $this->sendNotificationAwsSesHandler->handle($command);
    }
}