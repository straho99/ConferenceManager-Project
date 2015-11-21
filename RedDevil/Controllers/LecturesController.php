<?php

namespace RedDevil\Controllers;

use RedDevil\InputModels\Lecture\LectureInputModel;
use RedDevil\Models\Lecture;
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
        if (!$result->hasError()) {
            $this->addInfoMessage($result->getMessage());
            $this->redirect('conferences', 'own');
        } else {
            $this->addErrorMessage($result->getMessage());
            $this->redirect('conferences', 'own');
        }
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
        if (!$result->hasError()) {
            $this->addInfoMessage($result->getMessage());
            $this->redirect('conferences', 'own');
        } else {
            $this->addErrorMessage($result->getMessage());
            $this->redirect('conferences', 'own');
        }
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
        if (!$result->hasError()) {
            $this->addInfoMessage($result->getMessage());
            $this->redirect('conferences', 'own');
        } else {
            $this->addErrorMessage($result->getMessage());
            $this->redirect('conferences', 'own');
        }
    }
}