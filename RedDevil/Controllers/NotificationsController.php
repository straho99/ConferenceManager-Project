<?php

namespace RedDevil\Controllers;

use RedDevil\Core\HttpContext;
use RedDevil\Services\NotificationsService;
use RedDevil\View;

class NotificationsController extends BaseController {

    public function send()
    {

    }

    /**
     * Method('GET')
     * Authorize
     */
    public function all()
    {
        $userId = HttpContext::getInstance()->getIdentity()->getUserId();

        $service = new NotificationsService($this->dbContext);
        $result = $service->getAllNotifications($userId);
        $this->processResponse($result);
        return new View('Notifications', 'all', $result->getModel());
    }
}