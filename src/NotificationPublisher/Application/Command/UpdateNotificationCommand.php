<?php

namespace App\NotificationPublisher\Application\Command;

use App\NotificationPublisher\Domain\Entity\Notification;

class UpdateNotificationCommand
{
    private Notification $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }
}