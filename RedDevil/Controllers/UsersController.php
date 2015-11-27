<?php

namespace RedDevil\Controllers;

use RedDevil\Services\LecturesService;
use RedDevil\Services\UsersServices;
use RedDevil\View;
use RedDevil\ViewModels\UserInfoModel;

class UsersController extends BaseController {

    /**
     * @param $username
     * @Method('GET')
     * @Route('users/{string $username}/info')
     * @return View
     * @throws \Exception
     */
    public function users($username)
    {
        $user = $this->dbContext->getUsersRepository()
            ->filterByUsername(" = '$username'")
            ->findOne();
        if ($user->getUsername() == null) {
            throw new \Exception('Not found', 404);
        }

        $userInfoModel = new UserInfoModel($user);

        return new View('Users', 'users', $userInfoModel);
    }

    /**
     * @return View
     * @Route('users/invitations')
     */
    public function invitations()
    {
        $service = new UsersServices($this->dbContext);
        $response = $service->getSpeakerInvitationsForUser();
        $this->processResponse($response);
        return new View("Users", "invitations", $response->getModel());
    }

    /**
     * @Method('GET')
     * @Route('users/approveinvitation/{integer $invitationId}')
     * @param $invitationId
     * @throws \Exception
     */
    public function approveInvitation($invitationId)
    {
        $service = new UsersServices($this->dbContext);
        $response = $service->replyToSpeakerInvitation(true, $invitationId);
        $this->processResponse($response);
        $this->redirect("Home", "Index");
    }

    /**
     * @Method('GET')
     * @Route('users/rejectinvitation/{integer $invitationId}')
     * @param $invitationId
     * @throws \Exception
     */
    public function rejectInvitation($invitationId)
    {
        $service = new UsersServices($this->dbContext);
        $response = $service->replyToSpeakerInvitation(false, $invitationId);
        $this->processResponse($response);
        $this->redirect("Home", "Index");
    }
}