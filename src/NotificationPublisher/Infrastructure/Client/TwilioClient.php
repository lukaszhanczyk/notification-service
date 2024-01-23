<?php

namespace App\NotificationPublisher\Infrastructure\Client;

use App\NotificationPublisher\Domain\Entity\Notification;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioClient
{
    private Client $client;
    private string $number;

    /**
     * @throws ConfigurationException
     */
    public function __construct($twilioApiSid, $twilioApiToken, $twilioApiNumber)
    {
        $this->number = $twilioApiNumber;
        $this->client = new Client($twilioApiSid, $twilioApiToken);
    }

    /**
     * @throws TwilioException
     */
    public function send(Notification $notification): void
    {
        $this->client->messages->create(
            $notification->getPhone(),
            array(
                'from' => $this->number,
                'body' => $notification->getSubject()."\r\n\r\n".$notification->getContent()
            )
        );
    }
}