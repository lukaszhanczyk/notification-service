<?php

namespace App\NotificationPublisher\Infrastructure\Command;

use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Application\Command\UpdateNotificationCommand;
use App\NotificationPublisher\Application\Handler\GetAllByStatusNotificationHandler;
use App\NotificationPublisher\Application\Handler\SendNotificationHandler;
use App\NotificationPublisher\Application\Handler\UpdateNotificationHandler;
use App\NotificationPublisher\Application\Query\GetAllByStatusNotificationQuery;
use App\NotificationPublisher\Infrastructure\Configurator\ResendNotificationsConfigurator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResendNotificationsCommand extends Command
{
    protected static $defaultName = 'app:resend-notifications';
    private ResendNotificationsConfigurator $resendNotificationsConfigurator;
    private GetAllByStatusNotificationHandler $getAllByStatusNotificationHandler;
    private UpdateNotificationHandler $updateNotificationHandler;
    private SendNotificationHandler $sendNotificationHandler;

    public function __construct(
        ResendNotificationsConfigurator $resendNotificationsConfigurator,
        GetAllByStatusNotificationHandler $getAllByStatusNotificationHandler,
        UpdateNotificationHandler $updateNotificationHandler,
        SendNotificationHandler $sendNotificationHandler
    )
    {
        parent::__construct();
        $this->resendNotificationsConfigurator = $resendNotificationsConfigurator;
        $this->getAllByStatusNotificationHandler = $getAllByStatusNotificationHandler;
        $this->updateNotificationHandler = $updateNotificationHandler;
        $this->sendNotificationHandler = $sendNotificationHandler;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $getAllByStatusNotificationQuery = new GetAllByStatusNotificationQuery('error');
        $errorNotifications = $this->getAllByStatusNotificationHandler->handle($getAllByStatusNotificationQuery);

        foreach ($errorNotifications as $errorNotification){

            if ($errorNotification->getAttempts() < $this->resendNotificationsConfigurator->getMaxAttempts()){

                $sendNotificationCommand = new SendNotificationCommand($errorNotification->toArray());
                $response = $this->sendNotificationHandler->handle($sendNotificationCommand);

                $errorNotification->setStatus($response['data']['status']);
                $errorNotification->setAttempts($errorNotification->getAttempts() + 1);

            } else {
                $errorNotification->setStatus('terminated');

            }
            $updateNotificationCommand = new UpdateNotificationCommand($errorNotification);
            $this->updateNotificationHandler->handle($updateNotificationCommand);

        }

        return Command::SUCCESS;
    }
}