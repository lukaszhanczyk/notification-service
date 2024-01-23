<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\CreateNotificationCommand;
use App\NotificationPublisher\Application\Query\GetAllNotificationQuery;
use App\NotificationPublisher\Application\Service\NotificationService;

class GetAllNotificationHandler
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(GetAllNotificationQuery $query): array
    {
        $page = $query->getPage();
        $limit = $query->getLimit();
        return $this->notificationService->findAll($page, $limit);
    }
}