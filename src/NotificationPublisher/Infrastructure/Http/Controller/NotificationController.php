<?php

namespace App\NotificationPublisher\Infrastructure\Http\Controller;

use App\NotificationPublisher\Application\Command\CreateNotificationCommand;
use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Application\Handler\CreateNotificationHandler;
use App\NotificationPublisher\Application\Handler\GetAllNotificationHandler;
use App\NotificationPublisher\Application\Handler\SendNotificationHandler;
use App\NotificationPublisher\Application\Query\GetAllNotificationQuery;
use App\NotificationPublisher\Infrastructure\Http\Request\GetAllNotificationRequest;
use App\NotificationPublisher\Infrastructure\Http\Request\SendNotificationRequest;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    private SendNotificationHandler $sendNotificationHandler;
    private CreateNotificationHandler $createNotificationHandler;
    private GetAllNotificationHandler $getAllNotificationHandler;

    public function __construct(
        SendNotificationHandler $sendNotificationHandler,
        CreateNotificationHandler $createNotificationHandler,
        GetAllNotificationHandler $getAllNotificationHandler
    )
    {
        $this->sendNotificationHandler = $sendNotificationHandler;
        $this->createNotificationHandler = $createNotificationHandler;
        $this->getAllNotificationHandler = $getAllNotificationHandler;
    }

    #[Route('/history', name: 'api_notification_history', methods: ['GET'])]
    public function history(GetAllNotificationRequest $request): Response
    {
        if ($request->validate()){
            return $this->json(['errors' => $request->validate()],500);
        }

        $params = [
            'page' => $request->getRequest()->query->get('page') ?? '1',
            'limit' => $request->getRequest()->query->get('limit') ?? '20'
        ];

        $getAllNotificationQuery = new GetAllNotificationQuery($params);
        $notifications = $this->getAllNotificationHandler->handle($getAllNotificationQuery);


        return $this->json([
            'data' => $notifications,
            'pagination' => $params
        ]);
    }

    #[Route('/send', name: 'api_notification_send', methods: ['POST'])]
    public function send(SendNotificationRequest $request, RateLimiterFactory $anonymousApiLimiter): Response
    {

        if ($request->validate()){
            return $this->json(['errors' => $request->validate()],500);
        }

        $data = json_decode($request->getRequest()->getContent(), true);

        $limiter = $anonymousApiLimiter->create($data['userId']);
        if (false === $limiter->consume()->isAccepted()) {
            return $this->json([
                'errors' => [[
                    'message' => "To many request per user with id: " . $data['userId']
                ]]
            ],429);
        }

        $sendNotificationCommand = new SendNotificationCommand($data);
        $response = $this->sendNotificationHandler->handle($sendNotificationCommand);
        $createNotificationCommand = new CreateNotificationCommand($data, $response['data']['status']);
        $this->createNotificationHandler->handle($createNotificationCommand);

        return $this->json($response['data'], $response['code']);
    }
}