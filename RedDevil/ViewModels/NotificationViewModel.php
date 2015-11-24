<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Notification;

class NotificationViewModel {
    private $id;
    private $content;
    private $isRead;
    private $createdOn;

    function __construct(Notification $notification)
    {
        $this->id = $notification->getId();
        $this->content = $notification->getContent();
        $this->isRead = $notification->getIsRead();
        $this->createdOn = $notification->getCreatedOn();
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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * @param mixed $isRead
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        $date = new \DateTime($this->createdOn);
        return $date->format('d F Y h:i:s A');
    }

    /**
     * @param mixed $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }
}