<?php

namespace App\NotificationPublisher\Domain\Repository;

use App\NotificationPublisher\Domain\Entity\Notification;

interface NotificationRepository
{
    public function findAll(int $page, int $limit);
    public function findAllByStatus(string $status);
    public function create(Notification $notification);
    public function update(Notification $notification);
}