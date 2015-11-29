<?php

namespace RedDevil\Controllers;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Lecture\AddHallInputModel;
use RedDevil\InputModels\Lecture\BreakInputModel;
use RedDevil\InputModels\Lecture\LectureInputModel;
use RedDevil\InputModels\Lecture\SpeakerInvitationInputModel;
use RedDevil\Models\LectureBreak;
use RedDevil\Models\SpeakerInvitation;
use RedDevil\Services\LecturesService;
use RedDevil\Services\UsersServices;
use RedDevil\View;
use RedDevil\ViewModels\AddBreakViewModel;
use RedDevil\ViewModels\SpeakerInvitationViewModel;

class LecturesController extends BaseController {

    /**
     * @Method('GET', 'POST')
     * @Route('lectures/add/{integer $conferenceId}')
     * @param LectureInputModel $model
     * @param $conferenceId
     * @return View
     */
    public function add(LectureInputModel $model, integer $conferenceId)
    {
        if (!$model->isValid()) {
            return new View('lectures', 'add', $model);
        }

        $service = new LecturesService($this->dbContext);

        if (HttpContext::getInstance()->isPost()) {
            $result = $service->addLecture($model);
            if (!$result->hasError()) {
                $this->addInfoMessage($result->getMessage());
                $this->redirectToUrl('/conferences/details/' . $conferenceId);
            } else {
                $this->addErrorMessage($result->getMessage());
                $this->redirectToUrl('/conferences/details/' . $conferenceId);
            }
        } else {
            $model = new LectureInputModel();
            $model->setConferenceId($conferenceId);
            return new View('lectures', 'add', $model);
        }

        $result = $service->addLecture($model);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
    }

    /**
     * @param $lectureId
     * @Method('POST')
     * @Route('lectures/{integer $lectureId}/delete')
     */
    public function delete(integer $lectureId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->deleteLecture($lectureId);
        $this->processResponse($result);
        $this->redirectToUrl('/conferences/details/' . $result->getModel());
    }

    /**
     * @ValidateToken('token')
     * @Route('lectures/{integer $lectureId}/delete/confirm')
     * @param $lectureId
     * @return View
     */
    public function confirmDeleteLecture(integer $lectureId) : View
    {
        $conferenceId = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne()
            ->getConferenceId();

        return new View('Lectures', 'confirmDeleteLecture', ['lectureId' => $lectureId, 'conferenceId' => $conferenceId]);
    }

    /**
     * @Method('GET')
     * @Route('conferences/{integer $conferenceId}/lectures/{integer $lectureId}/invite')
     * @param $conferenceId
     * @param $lectureId
     * @return View
     * @throws \Exception
     */
    public function invite(integer $conferenceId, integer $lectureId) : View
    {
        $service = new LecturesService($this->dbContext);

        $users = $this->dbContext->getUsersRepository()
            ->orderBy('username')
            ->findAll()
            ->getUsers();
        $invitationModels = [];
        foreach ($users as $user) {
            $model = new SpeakerInvitation(
                $lectureId,
                $user->getId(),
                0
            );
            $viewModel = new SpeakerInvitationViewModel($model);
            $viewModel->setConferenceId($conferenceId);
            $viewModel->setSpeakerUsername($user->getUsername());

            $invitationModels[] = $viewModel;
        }

        return new View('lectures', 'invite', $invitationModels);
    }

    /**
     * Method('POST')
     * @Validatetoken('token')
     * @Route('lectures/sendinvitation')
     * @param SpeakerInvitationInputModel $model
     */
    public function sendInvitation(SpeakerInvitationInputModel $model)
    {
        if (!$model->isValid()) {
            $this->redirect('Conferences', 'all');
        }

        $service = new LecturesService($this->dbContext);
        $result = $service->inviteSpeaker($model);
        $this->processResponse($result);
        $this->redirectToUrl('/conferences/details/' . $model->getConferenceId());
    }

    /**
     * @param $lectureId
     * @Method('POST')
     * @Route('lectures/{integer $lectureId}/cancelinvitation/{integer $speakerId}')
     * @param $speakerId
     */
    public function cancelInvitation(integer $lectureId, integer $speakerId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->removeSpeaker($lectureId, $speakerId);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
    }

    /**
     * @param $lectureId
     * @Method('GET')
     * @Route('lectures/{integer $lectureId}/halls')
     * @return View
     * @throws \Exception
     */
    public function halls(integer $lectureId) : View
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->getHallsForLecture($lectureId);
        if ($result->hasError()) {
            if ($result->getErrorCode() > 1) {
                throw new \Exception($result->getMessage(), $result->getErrorCode());
            } else {
                $this->addErrorMessage($result->getMessage());
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            return new View('Lectures', 'selecthall', $result->getModel());
        }
    }

    /**
     * @param AddHallInputModel $model
     * @Validatetoken('token')
     * @Method('POST')
     * @Route('lectures/addhall')
     * @throws \Exception
     */
    public function addHall(AddHallInputModel $model)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->addHall($model);
        if ($result->hasError()) {
            if ($result->getErrorCode() > 1) {
                throw new \Exception($result->getMessage(), $result->getErrorCode());
            } else {
                $this->addErrorMessage($result->getMessage());
                $this->redirectToUrl('/conferences/details/' . $result->getModel());
            }
        } else {
            $this->addInfoMessage($result->getMessage());
            $this->redirectToUrl('/conferences/details/' . $result->getModel());
        }
    }

    /**
     * @param $lectureId
     * @param BreakInputModel $model
     * @return View
     * @throws \Exception
     * @Validatetoken('token')
     * @Method('GET', 'POST')
     * @Route('lectures/{integer $lectureId}/addbreak')
     */
    public function addBreak(BreakInputModel $model, integer $lectureId)
    {
        if (!$model->isValid()) {
            return new View('Lectures', 'addbreak', $model);
        }

        $service = new LecturesService($this->dbContext);
        if (HttpContext::getInstance()->isPost()) {
            $response = $service->addBreak($model);
            if ($response->hasError()) {
                if ($response->getErrorCode() > 1) {
                    throw new \Exception($response->getMessage(), $response->getErrorCode());
                } else {
                    $this->addErrorMessage($response->getMessage());
                    $this->redirectToUrl('/conferences/details/' . $response->getModel());
                }
            } else {
                $this->addInfoMessage($response->getMessage());
                $this->redirectToUrl('/conferences/details/' . $response->getModel());
            }
        } else {
            $conferenceId = $this->dbContext->getLecturesRepository()
                ->filterById(" = $lectureId")
                ->findOne()
                ->getConferenceId();
            $lecture = $this->dbContext->getLecturesRepository()
                ->filterById(" = $lectureId")
                ->findOne();

            $breakModel = new BreakInputModel();
            $breakModel->setLectureId($lectureId);
            $breakModel->setStartDate($lecture->getStartDate());
            $breakModel->setEndDate($lecture->getEndDate());
            $breakModel->setConferenceId($conferenceId);

            return new View('Lectures', 'addbreak', $breakModel);
        }
    }

    /**
     * @param $lectureId
     * @throws \Exception
     * @Method('POST', 'GET')
     * @Route('lectures/{integer $lectureId}/participate')
     */
    public function participate(integer $lectureId)
    {
        $userId = HttpContext::getInstance()->getIdentity()->getUserId();
        $service = new LecturesService($this->dbContext);
        $result = $service->addParticipant($lectureId, $userId);
        $this->processResponse($result);
        $this->redirectToUrl('/conferences/details/' . $result->getModel());
    }

    /**
     * @param $lectureId
     * @param $participantId
     * @Method('POST', 'GET')
     * @Route('lectures/{integer $lectureId}/deleteparticipant/{integer $participantId}')
     * @throws \Exception
     */
    public function deleteParticipant(integer $lectureId, integer $participantId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->deleteParticipant($lectureId, $participantId);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
    }

    /**
     * Authorize()
     * @return View
     * @throws \Exception
     */
    public function joined() : View
    {
        $service = new UsersServices($this->dbContext);
        $response = $service->getUsersSchedule();
        $this->processResponse($response);

        return new View('Lectures', 'joined', $response->getModel());
    }

    /**
     * Authorize()
     * @return View
     * @throws \Exception
     */
    public function own() : View
    {
        $service = new UsersServices($this->dbContext);
        $response = $service->getSpeakerSchedule();
        $this->processResponse($response);

        return new View('Lectures', 'own', $response->getModel());
    }
}