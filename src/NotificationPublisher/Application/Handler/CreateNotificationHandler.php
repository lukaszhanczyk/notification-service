<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\CreateNotificationCommand;
use App\NotificationPublisher\Application\Service\NotificationService;

class CreateNotificationHandler
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(CreateNotificationCommand $command): void
    {
        $notification = $command->getData();
        $this->notificationService->createNotification($notification);
    }
}