<?php


use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Application\Handler\GetAllNotificationHandler;
use App\NotificationPublisher\Application\Handler\SendNotificationAwsSesHandler;
use App\NotificationPublisher\Application\Handler\SendNotificationHandler;
use App\NotificationPublisher\Application\Handler\SendNotificationTwilioHandler;
use App\NotificationPublisher\Application\Query\GetAllNotificationQuery;
use App\NotificationPublisher\Application\Service\NotificationService;
use App\NotificationPublisher\Infrastructure\Configurator\SendNotificationConfigurator;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class GetAllNotificationHandlerTest extends TestCase
{
    public function testGetAllNotificationHandlerTest()
    {
        $NotificationServiceMock = $this->createMock(NotificationService::class);
        $getAllNotificationQueryMock = $this->createMock(GetAllNotificationQuery::class);

        $getAllNotificationQueryMock->expects($this->once())
            ->method('getPage')
            ->willReturn(1);

        $getAllNotificationQueryMock->expects($this->once())
            ->method('getLimit')
            ->willReturn(1);

        $getAllNotificationHandler = new GetAllNotificationHandler($NotificationServiceMock);

        $response = $getAllNotificationHandler->handle($getAllNotificationQueryMock);

        $this->assertIsArray($response);

    }

}