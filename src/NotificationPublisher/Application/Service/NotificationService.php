<?php

namespace App\NotificationPublisher\Application\Service;

use App\NotificationPublisher\Domain\Entity\Notification;
use App\NotificationPublisher\Infrastructure\Persistence\Repository\DoctrineNotificationRepository;

class NotificationService
{
    private DoctrineNotificationRepository $notificationRepository;

    public function __construct(DoctrineNotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function createNotification(Notification $notification): void
    {
        $this->notificationRepository->create($notification);
    }
}