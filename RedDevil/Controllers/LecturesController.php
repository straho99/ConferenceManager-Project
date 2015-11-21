<?php

namespace RedDevil\Controllers;

use RedDevil\InputModels\Lecture\BreakInputModel;
use RedDevil\InputModels\Lecture\LectureInputModel;
use RedDevil\Models\Lecture;
use RedDevil\Models\LectureBreak;
use RedDevil\Services\LecturesService;

class LecturesController extends BaseController {
    
    public function add()
    {
        $lecture = new Lecture(
            "Title",
            "Description",
            "2015-01-01 18:15:02",
            "2015-01-01 20:15:02",
            1,
            null,
            null
        );

        $model = new LectureInputModel($lecture);
        $service = new LecturesService($this->dbContext);

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
     * @param $lectureId
     * @Method('POST')
     * @Route('lectures/{integer $lectureId}/invite/{integer $speakerId}')
     * @param $speakerId
     */
    public function invite($lectureId, $speakerId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->inviteSpeaker($lectureId, $speakerId);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
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
     * @param $hallId
     * @Method('POST', 'GET')
     * @Route('lectures/{integer $lectureId}/addhall/{integer $hallId}')
     * @throws \Exception
     */
    public function addHall($lectureId, $hallId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->addHall($lectureId, $hallId);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
    }

    /**
     * @param $lectureId
     * @param $hallId
     * @Method('POST')
     * @Route('lectures/{integer $lectureId}/deletehall/{integer $hallId}')
     * @throws \Exception
     */
    public function deleteHall($lectureId, $hallId)
    {
        $service = new LecturesService($this->dbContext);
        $result = $service->deleteHall($lectureId, $hallId);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
    }

    /**
     * @throws \Exception
     * @internal param $lectureId
     * @Method('POST')
     * @Route('lectures/{integer $lectureId}/addbreak')
     */
    public function addBreak()
    {
        $break = new LectureBreak(
            "Title",
            "Description",
            1,
            "2015-01-01 18:17:02",
            "2015-01-01 18:25:02"
        );

        $model = new BreakInputModel($break);

        $service = new LecturesService($this->dbContext);
        $result = $service->addBreak(11, $model);
        $this->processResponse($result);
        $this->redirect('conferences', 'own');
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