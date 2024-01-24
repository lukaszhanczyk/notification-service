<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Infrastructure\Client\AwsSesClient;
use App\NotificationPublisher\Infrastructure\Configurator\SendNotificationConfigurator;
use Aws\Exception\AwsException;
use Psr\Log\LoggerInterface;
use Twilio\Exceptions\TwilioException;

class SendNotificationHandler
{
    private SendNotificationTwilioHandler $sendNotificationTwilioHandler;
    private SendNotificationAwsSesHandler $sendNotificationAwsSesHandler;
    private SendNotificationConfigurator $configurator;

    private LoggerInterface $logger;

    public function __construct(
        SendNotificationTwilioHandler $sendNotificationTwilioHandler,
        SendNotificationAwsSesHandler $sendNotificationAwsSesHandler,
        SendNotificationConfigurator $configurator,
        LoggerInterface $logger
    )
    {
        $this->sendNotificationTwilioHandler = $sendNotificationTwilioHandler;
        $this->sendNotificationAwsSesHandler = $sendNotificationAwsSesHandler;
        $this->configurator = $configurator;
        $this->logger = $logger;
    }

    public function handle(SendNotificationCommand $command): array
    {
        $errorTwilioStatus = false;
        $errorAwsSesStatus = false;

        if ($this->configurator->isTwilioOpen()) {
            try {
                $this->sendNotificationTwilioHandler->handle($command);
            } catch (TwilioException $e){
                $this->logger->error($e->getMessage());
                $errorTwilioStatus = true;
            }
        }

        if ($this->configurator->isAwsSesOpen()) {
            try {
                $this->sendNotificationAwsSesHandler->handle($command);
            } catch (AwsException $e) {
                $this->logger->error($e->getMessage());
                $errorAwsSesStatus = true;
            }
        }

        if (!$errorTwilioStatus || !$errorAwsSesStatus){
            $response = [
                'data' => [
                    'status' => 'success',
                    'message' => 'Notification sent correctly!'
                ],
                'code' => 200
            ];
        } else {
            $response = [
                'data' => [
                    'status' => 'error',
                    'message' => 'Unable to send notification!'
                ],
                'code' => 500
            ];
        }

        if (!$this->configurator->isAwsSesOpen() && !$this->configurator->isTwilioOpen()){
            $response = [
                'data' => [
                    'status' => 'terminated',
                    'message' => 'Enable at least one service to send a notification!'
                ],
                'code' => 500
            ];
        }

        return $response;
    }
}