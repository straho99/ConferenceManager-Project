<?php

namespace RedDevil\InputModels\Message;

use RedDevil\InputModels\BaseInputModel;

class MessageInputModel extends BaseInputModel {
    private $recipientId;
    private $content;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getRecipientId()
    {
        return $this->recipientId;
    }

    /**
     * @param mixed $recipientId
     */
    public function setRecipientId($recipientId)
    {
        $this->recipientId = $recipientId;
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

    public function validate()
    {
        $this->validator->setRule('required', $this->content, null,
            'content | Content is required.');

        $this->validator->setRule('required', $this->recipientId, null,
            'recipientId | RecipientId is required.');

        $this->validator->setRule('minlength', $this->content, 3,
            'content | Content must be at least 3 characters long.');

        parent::validate();
    }
}