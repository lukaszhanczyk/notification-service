<?php

namespace App\NotificationPublisher\Application\Query;

use App\NotificationPublisher\Domain\Entity\Notification;

class GetAllByStatusNotificationQuery
{
    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }


}