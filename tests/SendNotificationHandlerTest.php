<?php

namespace App\Tests;

use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Application\Handler\SendNotificationAwsSesHandler;
use App\NotificationPublisher\Application\Handler\SendNotificationHandler;
use App\NotificationPublisher\Application\Handler\SendNotificationTwilioHandler;
use App\NotificationPublisher\Domain\Entity\Notification;
use App\NotificationPublisher\Infrastructure\Configurator\SendNotificationConfigurator;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class SendNotificationHandlerTest extends TestCase
{
    public function testSendNotificationHandler()
    {
        $sendNotificationTwilioHandlerMock = $this->createMock(SendNotificationTwilioHandler::class);
        $sendNotificationAwsSesHandlerMock = $this->createMock(SendNotificationAwsSesHandler::class);
        $configuratorMock = $this->createMock(SendNotificationConfigurator::class);
        $loggerMock = $this->createMock(LoggerInterface::class);
        $sendNotificationCommandMock = $this->createMock(SendNotificationCommand::class);
        $notificationMock = $this->createMock(Notification::class);

        $configuratorMock->expects($this->any())
            ->method('isTwilioOpen')
            ->willReturn(true);

        $configuratorMock->expects($this->any())
            ->method('isAwsSesOpen')
            ->willReturn(true);

        $sendNotificationTwilioHandlerMock->expects($this->once())
            ->method('handle');

        $sendNotificationAwsSesHandlerMock->expects($this->once())
            ->method('handle');

        $loggerMock->expects($this->never())
            ->method('error');

        $sendNotificationCommandMock->expects($this->any())
            ->method('getData')
            ->willReturn($notificationMock);

        $sendNotificationHandler = new SendNotificationHandler(
            $sendNotificationTwilioHandlerMock,
            $sendNotificationAwsSesHandlerMock,
            $configuratorMock,
            $loggerMock
        );

        $response = $sendNotificationHandler->handle($sendNotificationCommandMock);

        $this->assertIsArray($response);
    }

}