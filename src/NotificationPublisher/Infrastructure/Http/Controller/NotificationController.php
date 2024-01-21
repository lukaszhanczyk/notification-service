<?php

namespace App\NotificationPublisher\Infrastructure\Http\Controller;

use App\NotificationPublisher\Application\Command\SendNotificationCommand;
use App\NotificationPublisher\Application\Handler\SendNotificationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    private SendNotificationHandler $sendNotificationHandler;

    public function __construct(SendNotificationHandler $sendNotificationHandler)
    {
        $this->sendNotificationHandler = $sendNotificationHandler;
    }

    #[Route('/notification', name: 'api_notification')]
    public function index(): Response
    {
        $sendNotificationCommand = new SendNotificationCommand([]);
        $this->sendNotificationHandler->handle($sendNotificationCommand);
        return $this->json(1);
    }
}