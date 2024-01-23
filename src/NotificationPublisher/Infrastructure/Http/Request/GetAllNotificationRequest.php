<?php

namespace App\NotificationPublisher\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;


class GetAllNotificationRequest extends BaseRequest
{

    /**
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @Assert\Range(
     *       min = 1,
     *  )
     **/
    protected $page;

    /**
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @Assert\Range(
     *        min = 1,
     *        max = 100,
     *   )
     **/
    protected $limit;
}