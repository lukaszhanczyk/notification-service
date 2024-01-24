<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\CreateNotificationCommand;
use App\NotificationPublisher\Application\Command\UpdateNotificationCommand;
use App\NotificationPublisher\Application\Service\NotificationService;

class UpdateNotificationHandler
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(UpdateNotificationCommand $command): void
    {
        $notification = $command->getNotification();
        $this->notificationService->update($notification);
    }
}