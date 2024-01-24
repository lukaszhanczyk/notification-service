<?php

namespace App\NotificationPublisher\Domain\Entity;

use App\NotificationPublisher\Application\Dto\NotificationDto;

class Notification
{
    private ?int $id;
    private string $userId;
    private string $email;
    private string $phone;
    private string $sendingDate;
    private string $subject;
    private string $content;
    private ?int $attempts;
    private ?string $status;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
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
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
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


    public function toDto(): NotificationDto
    {
        return new NotificationDto(
            $this->id ?? null,
            $this->userId,
            $this->email,
            $this->phone,
            $this->sendingDate ?? null,
            $this->subject,
            $this->content,
            $this->attempts ?? null,
            $this->status ?? null,
        );
    }
}