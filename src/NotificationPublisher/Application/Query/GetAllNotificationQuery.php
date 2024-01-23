<?php

namespace App\NotificationPublisher\Application\Query;

use App\NotificationPublisher\Domain\Entity\Notification;

class GetAllNotificationQuery
{
    private int $page;
    private int $limit;

    public function __construct(array $params)
    {
        $this->page = $params['page'];
        $this->limit = $params['limit'];
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

}