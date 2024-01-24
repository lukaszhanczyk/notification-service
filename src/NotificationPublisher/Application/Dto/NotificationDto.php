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
    private ?int $attempts;
    private ?string $status;

    /**
     * @param int|null $id
     * @param string $userId
     * @param string $email
     * @param string $phone
     * @param string|null $sendingDate
     * @param string $subject
     * @param string $content
     * @param int|null $attempts
     * @param string|null $status
     */
    public function __construct(
        ?int $id,
        string $userId,
        string $email,
        string $phone,
        ?string $sendingDate,
        string $subject,
        string $content,
        ?int $attempts,
        ?string $status
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->email = $email;
        $this->phone = $phone;
        $this->sendingDate = $sendingDate;
        $this->subject = $subject;
        $this->content = $content;
        $this->attempts = $attempts;
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
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
    public function setEmail(string $email): void
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

    public function getAttempts(): ?int
    {
        return $this->attempts;
    }

    public function setAttempts(?int $attempts): void
    {
        $this->attempts = $attempts;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }


}