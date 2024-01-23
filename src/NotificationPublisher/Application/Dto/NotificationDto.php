<?php

namespace App\NotificationPublisher\Application\Dto;

class NotificationDto
{
    private ?int $id;
    private string $userId;
    private string $email;
    private string $phone;
    private ?string $sendingDate;
    private string $subject;
    private string $content;

    /**
     * @param int|null $id
     * @param string $userId
     * @param string $email
     * @param string $phone
     * @param string|null $sendingDate
     * @param string $subject
     * @param string $content
     */
    public function __construct(?int $id, string $userId, string $email, string $phone, ?string $sendingDate, string $subject, string $content)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->email = $email;
        $this->phone = $phone;
        $this->sendingDate = $sendingDate;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getSendingDate()
    {
        return $this->sendingDate;
    }

    /**
     * @param mixed $sendingDate
     */
    public function setSendingDate($sendingDate): void
    {
        $this->sendingDate = $sendingDate;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }
}