<?php

namespace App\NotificationPublisher\Infrastructure\Persistence\Entity;

use Doctrine\ORM\Mapping\MappedSuperclass as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name=notification)
 **/
class Notification
{
    /**
     * @ORM\Id
     *
     **/
}