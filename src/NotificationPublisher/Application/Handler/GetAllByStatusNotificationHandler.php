<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\CreateNotificationCommand;
use App\NotificationPublisher\Application\Query\GetAllByStatusNotificationQuery;
use App\NotificationPublisher\Application\Query\GetAllNotificationQuery;
use App\NotificationPublisher\Application\Service\NotificationService;

class GetAllByStatusNotificationHandler
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(GetAllByStatusNotificationQuery $query): array
    {
        $status = $query->getStatus();
        return $this->notificationService->findAllByStatus($status);
    }
}