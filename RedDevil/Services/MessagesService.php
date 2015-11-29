<?php

namespace RedDevil\Services;

use RedDevil\InputModels\Message\MessageInputModel;
use RedDevil\Models\Message;
use RedDevil\ViewModels\MessageViewModel;

class MessagesService extends BaseService {
    /**
     * @param MessageInputModel $model
     * @param $senderId
     * @return ServiceResponse
     * @throws \Exception
     * @internal param $recipientId
     * @internal param $content
     */
    public function sendMessage(MessageInputModel $model, integer $senderId) : ServiceResponse
    {
        $sender = $this->dbContext->getUsersRepository()
            ->filterById(" = $senderId")
            ->findOne();

        if ($sender->getId() == null) {
            return new ServiceResponse(404, "Sender not found.");
        }

        $recipientId = $model->getRecipientId();
        $recipient = $this->dbContext->getUsersRepository()
            ->filterById(" = $recipientId")
            ->findOne();
        if ($recipient->getId() == null) {
            return new ServiceResponse(404, "Recipient not found.");
        }

        $message = new Message($senderId, $recipientId, $model->getContent(), new \DateTime('now'));
        $this->dbContext->getMessagesRepository()
            ->add($message);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Message sent.");
    }

    public function getAllMessages(integer $userId) : ServiceResponse
    {
        $messageModels = [];
        $user = $this->dbContext->getUsersRepository()
            ->filterById(" = $userId")
            ->findOne();

        if ($user->getId() == null) {
            return new ServiceResponse(404, "User not found.");
        }

        $messages = $this->dbContext->getMessagesRepository()
            ->filterByRecipientId(" = $userId")
            ->orderByDescending("CreatedOn")
            ->findAll();

        foreach ($messages->getMessages() as $message) {
            $model = new MessageViewModel($message);
            $senderId = $message->getSenderId();
            $sender = $this->dbContext->getUsersRepository()
                ->filterById(" = $senderId")
                ->findOne()
                ->getUsername();
            $model->setSender($sender);
            $messageModels[] = $model;
        }

        return $messageModels;
    }
}