<?php

namespace App\NotificationPublisher\Infrastructure\Configurator;

class SendNotificationConfigurator
{
    private bool $isAwsSesOpen;
    private bool $isTwilioOpen;

    public function __construct(bool $isAwsSesOpen, bool $isTwilioOpen)
    {
        $this->isAwsSesOpen = $isAwsSesOpen;
        $this->isTwilioOpen = $isTwilioOpen;
    }

    public function isAwsSesOpen(): bool
    {
        return $this->isAwsSesOpen;
    }

    public function isTwilioOpen(): bool
    {
        return $this->isTwilioOpen;
    }


}