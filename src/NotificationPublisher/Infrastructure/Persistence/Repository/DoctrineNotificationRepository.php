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

    public function findAll(int $page, int $limit): array
    {
        $doctrineNotifications = $this->entityManager->createQueryBuilder()
            ->select(array('n'))
            ->from(DoctrineNotification::class, 'n')
            ->orderBy('n.id', 'DESC')
            ->setFirstResult($page === 1 ? $page - 1 : $page * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $notifications = [];
        foreach ($doctrineNotifications as $doctrineNotification){
            $notificationDto = $doctrineNotification->toDto();
            $notification = new Notification();
            $notification->setId($notificationDto->getId());
            $notification->setContent($notificationDto->getContent());
            $notification->setSubject($notificationDto->getSubject());
            $notification->setUserId($notificationDto->getUserId());
            $notification->setEmail($notificationDto->getEmail());
            $notification->setSendingDate($notificationDto->getSendingDate());
            $notifications[] = $notification;
        }

        return $notifications;
    }

    public function create(Notification $notification): void
    {
        $notificationDto = $notification->toDto();
        $doctrineNotification = new DoctrineNotification();
        $doctrineNotification->setContent($notificationDto->getContent());
        $doctrineNotification->setSubject($notificationDto->getSubject());
        $doctrineNotification->setUserId($notificationDto->getUserId());
        $doctrineNotification->setEmail($notificationDto->getEmail());
        $doctrineNotification->setPhone($notificationDto->getPhone());
        $doctrineNotification->setSendingDate((new DateTime('now')));

        $this->entityManager->persist($doctrineNotification);
        $this->entityManager->flush();
    }
}
