<?php

namespace App\NotificationPublisher\Application\Command;

use App\NotificationPublisher\Domain\Entity\Notification;

class SendNotificationCommand
{
    private Notification $data;

    public function __construct(array $data)
    {
        $this->data = new Notification();
        $this->data->setSubject($data['subject']);
        $this->data->setContent($data['content']);
        $this->data->setEmail($data['email']);
        $this->data->setPhone($data['phone']);
    }

    public function getData(): Notification
    {
        return $this->data;
    }
}