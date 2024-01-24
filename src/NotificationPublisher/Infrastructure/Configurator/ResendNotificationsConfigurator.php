<?php

namespace App\NotificationPublisher\Infrastructure\Configurator;

class ResendNotificationsConfigurator
{
    private int $maxAttempts;

    public function __construct(int $maxAttempts)
    {
        $this->maxAttempts = $maxAttempts;
    }

    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }


}