<?php

namespace App\NotificationPublisher\Domain\Repository;

use App\NotificationPublisher\Domain\Entity\Notification;

interface NotificationRepository
{
    public function create(Notification $notification);
}