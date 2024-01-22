<?php

namespace App\NotificationPublisher\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;


class NotificationRequest extends BaseRequest
{

    /**
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Length(
     *       min = 1,
     *       max = 255,
     *  )
     **/
    protected $userId;

    /**
     * @Assert\NotNull
     * @Assert\Email(
     *       message = "The email '{{ value }}' is not a valid email."
     *   )
     * @Assert\Length(
     *        min = 1,
     *        max = 255,
     *   )
     **/
    protected $email;

    /**
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Length(
     *        min = 1,
     *        max = 255,
     *   )
     **/
    protected $subject;

    /**
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Length(
     *        min = 1,
     *        max = 255,
     *   )
     **/
    protected $content;
}