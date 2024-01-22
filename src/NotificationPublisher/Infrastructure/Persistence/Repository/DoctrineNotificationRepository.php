<?php

namespace App\NotificationPublisher\Infrastructure\Persistence\Repository;

use App\NotificationPublisher\Domain\Entity\Notification;
use App\NotificationPublisher\Domain\Repository\NotificationRepository;
use App\NotificationPublisher\Infrastructure\Persistence\Entity\DoctrineNotification;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineNotificationRepository implements NotificationRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Notification $notification): void
    {
        $notificationDto = $notification->toDto();
        $doctrineNotification = new DoctrineNotification();
        $doctrineNotification->setContent($notificationDto->getContent());
        $doctrineNotification->setSubject($notificationDto->getSubject());
        $doctrineNotification->setUserId($notificationDto->getUserId());
        $doctrineNotification->setEmail($notificationDto->getEmail());
        $doctrineNotification->setSendingDate((new DateTime('now')));

        $this->entityManager->persist($doctrineNotification);
        $this->entityManager->flush();
    }
}
