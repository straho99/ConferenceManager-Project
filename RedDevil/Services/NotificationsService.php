<?php

namespace RedDevil\Services;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Models\Notification;
use RedDevil\ViewModels\NotificationViewModel;

class NotificationsService extends BaseService {

    /**
     * @param $userId
     * @param $content
     * @return ServiceResponse
     */
    public function sendNotification($userId, $content)
    {
        $user = $this->dbContext->getUsersRepository()
            ->filterById(" = $userId")
            ->findOne();

        if ($user->getId() == null) {
            return new ServiceResponse(404, "User not found.");
        }

        $notification = new Notification($content, false, $userId, new \DateTime('now'));
        $this->dbContext->getNotificationsRepository()
            ->add($notification);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Notification sent.");
    }

    /**
     * @param $userId
     * @return ServiceResponse
     */
    public function getAllNotifications($userId)
    {
        $notificationModels = [];
        $user = $this->dbContext->getUsersRepository()
            ->filterById(" = $userId")
            ->findOne();

        if ($user->getId() == null) {
            return new ServiceResponse(404, "User not found.");
        }

        $notifications = $this->dbContext->getNotificationsRepository()
            ->filterByRecipientId(" = $userId")
            ->orderByDescending("CreatedOn")
            ->findAll();

        foreach ($notifications->getNotifications() as $notification) {
            $model = new NotificationViewModel($notification);
            $notificationModels[] = $model;
        }

        return new ServiceResponse(null, null, $notificationModels);
    }

    /**
     * @param $userId
     * @return mixed
     * @throws \Exception
     */
    public static function getUnreadCount($userId)
    {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare(self::$GET_UNREAD_COUNT);
        $statement->execute([$userId]);
        $count = $statement->fetch()['count'];

        return $count;
    }

    /**
     * @param $recipientId
     * @param $notificationId
     * @return ServiceResponse
     */
    public function markAsRead($recipientId, $notificationId)
    {
        $recipient = $this->dbContext->getUsersRepository()
            ->filterById(" = $recipientId")
            ->findOne();

        if ($recipient->getId() == null) {
            return new ServiceResponse(404, "Recipient not found.");
        }

        $notification = $this->dbContext->getNotificationsRepository()
            ->filterById(" = $notificationId")
            ->findOne();
        $notification->setIsRead(1);
        $this->dbContext->saveChanges();
        return new ServiceResponse();
    }

    public function markAllAsRead($recipientId)
    {
        $recipient = $this->dbContext->getUsersRepository()
            ->filterById(" = $recipientId")
            ->findOne();

        if ($recipient->getId() == null) {
            return new ServiceResponse(404, "Recipient not found.");
        }

        $notifications = $this->dbContext->getNotificationsRepository()
            ->filterByRecipientId(" = $recipientId")
            ->findAll();

        $notifications->each(function ($notification) {
            $notification->setIsRead(1);
        });
        $this->dbContext->saveChanges();
        return new ServiceResponse();

    }

    static $GET_UNREAD_COUNT = <<<TAG
select count(id) as 'count'
from notifications
where RecipientId = 1 and IsRead = 0
TAG;
}