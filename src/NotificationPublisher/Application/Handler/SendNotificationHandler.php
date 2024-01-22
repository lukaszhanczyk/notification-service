<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Infrastructure\Client\AwsSesClient;

class SendNotificationHandler
{
    private AwsSesClient $awsSesClient;

    public function __construct(AwsSesClient $awsSesClient)
    {
        $this->awsSesClient = $awsSesClient;
    }

    public function handle(SendNotificationCommand $command): void
    {
        $notification = $command->getData();
        $this->awsSesClient->send($notification);
    }
}