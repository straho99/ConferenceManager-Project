<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Message;

class MessageViewModel {
    private $id;
    private $content;
    private $sender;
    private $createdOn;

    function __construct(Message $message)
    {
        $this->id = $message->getId();
        $this->content = $message->getContent();
        $this->createdOn = $message->getCreatedOn();
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
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
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