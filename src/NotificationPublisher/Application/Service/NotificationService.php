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

    public function findAll(int $page, int $limit): array
    {
        return $this->notificationRepository->findAll($page, $limit);
    }

    public function findAllByStatus(string $status): array
    {
        return $this->notificationRepository->findAllByStatus($status);
    }

    public function create(Notification $notification): void
    {
        $this->notificationRepository->create($notification);
    }

    public function update(Notification $notification): void
    {
        $this->notificationRepository->update($notification);
    }
}