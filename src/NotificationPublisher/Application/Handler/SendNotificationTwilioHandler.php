<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Infrastructure\Client\AwsSesClient;
use App\NotificationPublisher\Infrastructure\Client\TwilioClient;
use Twilio\Exceptions\TwilioException;

class SendNotificationTwilioHandler
{
    private TwilioClient $twilioClient;

    public function __construct(TwilioClient $twilioClient)
    {
        $this->twilioClient = $twilioClient;
    }

    /**
     * @throws TwilioException
     */
    public function handle(SendNotificationCommand $command): void
    {
        $notification = $command->getData();
        $this->twilioClient->send($notification);
    }
}