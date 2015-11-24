<?php

namespace RedDevil\Services;

use RedDevil\InputModels\Message\MessageInputModel;
use RedDevil\Models\Message;
use RedDevil\ViewModels\MessageViewModel;

class MessagesService extends BaseService {
    /**
     * @param $senderId
     * @param $recipientId
     * @param $content
     * @return ServiceResponse
     */
    public function sendMessage(MessageInputModel $model, $senderId)
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

    public function getAllMessages($userId)
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