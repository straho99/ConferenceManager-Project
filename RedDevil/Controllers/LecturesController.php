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
    public function add(LectureInputModel $model, $conferenceId)
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
    public function delete($lectureId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->deleteLecture($lectureId);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
    }

    /**
     * @Method('GET')
     * @Route('conferences/{integer $conferenceId}/lectures/{integer $lectureId}/invite')
     * @param $conferenceId
     * @param $lectureId
     * @return View
     * @throws \Exception
     */
    public function invite($conferenceId, $lectureId)
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
    public function cancelInvitation($lectureId, $speakerId)
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
    public function halls($lectureId)
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
     * @Method('GET', 'POST')
     * @Route('lectures/{integer $lectureId}/addbreak')
     */
    public function addBreak(BreakInputModel $model, $lectureId)
    {
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
            $breakModel = new BreakInputModel();
            $breakModel->setLectureId($lectureId);
            $breakModel->setConferenceId($conferenceId);

            return new View('Lectures', 'addbreak', $breakModel);
        }
    }

    /**
     * @param $lectureId
     * @param $participantId
     * @Method('POST', 'GET')
     * @Route('lectures/{integer $lectureId}/addparticipant/{integer $participantId}')
     * @throws \Exception
     */
    public function addParticipant($lectureId, $participantId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->addParticipant($lectureId, $participantId);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
    }

    /**
     * @param $lectureId
     * @param $participantId
     * @Method('POST', 'GET')
     * @Route('lectures/{integer $lectureId}/deleteparticipant/{integer $participantId}')
     * @throws \Exception
     */
    public function deleteParticipant($lectureId, $participantId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->deleteParticipant($lectureId, $participantId);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
    }
}