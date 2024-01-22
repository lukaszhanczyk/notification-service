<?php

namespace App\NotificationPublisher\Infrastructure\Http\Controller;

use App\NotificationPublisher\Application\Command\CreateNotificationCommand;
use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Application\Handler\CreateNotificationHandler;
use App\NotificationPublisher\Application\Handler\SendNotificationHandler;
use App\NotificationPublisher\Infrastructure\Http\Request\NotificationRequest;
use Aws\Exception\AwsException;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    private SendNotificationHandler $sendNotificationHandler;
    private CreateNotificationHandler $createNotificationHandler;

    public function __construct(
        SendNotificationHandler $sendNotificationHandler,
        CreateNotificationHandler $createNotificationHandler
    )
    {
        $this->sendNotificationHandler = $sendNotificationHandler;
        $this->createNotificationHandler = $createNotificationHandler;
    }

    #[Route('/notification', name: 'api_notification', methods: ['POST'])]
    public function notification(NotificationRequest $request): Response
    {
        if ($request->validate()){
            return $this->json([
                    'errors' => $request->validate()
                ],500);
        }

        $data = json_decode($request->getRequest()->getContent(), true);

        try {
            $sendNotificationCommand = new SendNotificationCommand($data);
            $this->sendNotificationHandler->handle($sendNotificationCommand);
        } catch (AwsException $e){
            return $this->json([
                'errors' => [[
                    'message' => $e->getMessage()
                ]]
            ],500);
        }

        try {
            $createNotificationCommand = new CreateNotificationCommand($data);
            $this->createNotificationHandler->handle($createNotificationCommand);
        } catch (Exception $e){
            return $this->json([
                'errors' => [[
                    'message' => $e->getMessage()
                ]]
            ],500);
        }

        return $this->json([
            'success' => 'Notification sent correctly'
        ], 200);
    }
}