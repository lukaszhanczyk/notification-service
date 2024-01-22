<?php

namespace App\NotificationPublisher\Infrastructure\Client;

use App\NotificationPublisher\Domain\Entity\Notification;
use Aws\Exception\AwsException;
use Aws\Ses\SesClient;

class AwsSesClient
{
    private SesClient $sesClient;

    public function __construct(string $awsSesApiKey, string $awsSesApiSecret)
    {
        $this->sesClient = new SesClient([
            'version' => 'latest',
            'region'  => 'eu-central-1',
            'credentials' => array(
                'key' => $awsSesApiKey,
                'secret'  => $awsSesApiSecret,
            )
        ]);
    }

    public function send(Notification $notification): void
    {
        $sender_email = 'lukasz0hanczyk@gmail.com';
        $char_set = 'UTF-8';

        $this->sesClient->sendEmail([
            'Destination' => [
                'ToAddresses' => [$notification->getEmail()],
            ],
            'ReplyToAddresses' => [$sender_email],
            'Source' => $sender_email,
            'Message' => [
                'Body' => [
                    'Text' => [
                        'Charset' => $char_set,
                        'Data' => $notification->getContent(),
                    ],
                ],
                'Subject' => [
                    'Charset' => $char_set,
                    'Data' => $notification->getSubject(),
                ],
            ],
        ]);
    }
}