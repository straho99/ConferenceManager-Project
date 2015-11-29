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
    public function sendNotification(integer $userId, integer $content) : ServiceResponse
    {
        $user = $this->dbContext->getUsersRepository()
            ->filterById(" = $userId")
            ->findOne();

        if ($user->getId() == null) {
            return new ServiceResponse(404, "User not found.");
        }

        $todayDate = new \DateTime('now');
        $today = $todayDate->format('Y-m-d H:i:s');
        $notification = new Notification($content, $user->getId(), 0, $today);
        $this->dbContext->getNotificationsRepository()
            ->add($notification);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, null);
    }

    /**
     * @param $userId
     * @return ServiceResponse
     */
    public function getAllNotifications(integer $userId) : ServiceResponse
    {
        $notificationModels = [];
        $user = $this->dbContext->getUsersRepository()
            ->filterById(" = $userId")
            ->findOne();

        if ($user->getId() == null) {
            return new ServiceResponse(404, "User not found.");
        }

        $notifications = $this->dbContext->getNotificationsRepository()
            ->filterByUserId(" = $userId")
            ->filterByIsRead(" = 0")
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
    public static function getUnreadCount(integer $userId)  : ServiceResponse
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
    public function markAsRead(integer $recipientId, integer $notificationId)  : ServiceResponse
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

    public function markAllAsRead(integer $recipientId)  : ServiceResponse
    {
        $recipient = $this->dbContext->getUsersRepository()
            ->filterById(" = $recipientId")
            ->findOne();

        if ($recipient->getId() == null) {
            return new ServiceResponse(404, "Recipient not found.");
        }

        $notifications = $this->dbContext->getNotificationsRepository()
            ->filterByUserId(" = $recipientId")
            ->findAll();

        foreach ($notifications->getNotifications() as $notification) {
            $notification->setIsRead(1);
        }
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, null);
    }
    
    public function postToAll(string $message)  : ServiceResponse{
    	$users = $this->dbContext->getUsersRepository()
    			->findAll();

        $todayDate = new \DateTime('now');
        $today = $todayDate->format('Y-m-d H:i:s');

        foreach ($users->getUsers() as $user) {
            $notification = new Notification($message, $user->getId(), 0, $today);
            $this->dbContext->getNotificationsRepository()
                ->add($notification);
            $this->dbContext->saveChanges();
        }

	    return true;
    }

    static $GET_UNREAD_COUNT = <<<TAG
select count(id) as 'count'
from notifications
where UserId = 1 and IsRead = 0
TAG;
}
