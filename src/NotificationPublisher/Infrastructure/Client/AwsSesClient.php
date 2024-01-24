<?php

namespace App\NotificationPublisher\Infrastructure\Client;

use App\NotificationPublisher\Domain\Entity\Notification;
use Aws\Exception\AwsException;
use Aws\Ses\SesClient;

class AwsSesClient
{
    private SesClient $sesClient;
    private string $awsSesApiEmail;

    public function __construct(string $awsSesApiKey, string $awsSesApiSecret, string $awsSesApiEmail)
    {
        $this->awsSesApiEmail = $awsSesApiEmail;
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
        $char_set = 'UTF-8';

        $this->sesClient->sendEmail([
            'Destination' => [
                'ToAddresses' => [$notification->getEmail()],
            ],
            'ReplyToAddresses' => [$this->awsSesApiEmail],
            'Source' => $this->awsSesApiEmail,
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