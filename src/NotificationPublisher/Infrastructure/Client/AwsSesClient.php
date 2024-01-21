<?php

namespace App\NotificationPublisher\Infrastructure\Client;

use Aws\Exception\AwsException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Service;
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

    public function send()
    {
        $sender_email = 'lukasz0hanczyk@gmail.com';

        $recipient_emails = ['lukasz0hanczyk@gmail.com'];

        $configuration_set = 'ConfigSet';

        $subject = 'Notification';
        $plaintext_body = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
        $html_body =  '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
            '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
            'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
            'AWS SDK for PHP</a>.</p>';
        $char_set = 'UTF-8';

        try {
            $result = $this->sesClient->sendEmail([
                'Destination' => [
                    'ToAddresses' => $recipient_emails,
                ],
                'ReplyToAddresses' => [$sender_email],
                'Source' => $sender_email,
                'Message' => [
                    'Body' => [
                        'Html' => [
                            'Charset' => $char_set,
                            'Data' => $html_body,
                        ],
                        'Text' => [
                            'Charset' => $char_set,
                            'Data' => $plaintext_body,
                        ],
                    ],
                    'Subject' => [
                        'Charset' => $char_set,
                        'Data' => $subject,
                    ],
                ],
                // If you aren't using a configuration set, comment or delete the
                // following line
                'ConfigurationSetName' => $configuration_set,
            ]);
            $messageId = $result['MessageId'];
            echo("Email sent! Message ID: $messageId"."\n");
        } catch (AwsException $e) {
            // output error message if fails
            echo $e->getMessage();
            echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
            echo "\n";
        }
    }
}