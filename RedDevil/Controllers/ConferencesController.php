<?php

namespace RedDevil\Controllers;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Conference\ConferenceInputModel;
use RedDevil\Services\ConferencesService;
use RedDevil\View;

class ConferencesController extends BaseController {
    
    public function all()
    {
        $service = new ConferencesService($this->dbContext);
        $allConferences =$service->getAllConferences();

        return new View('Conferences', 'all', $allConferences);
    }

    /**
     * @param ConferenceInputModel $model
     * @Method('GET', 'POST')
     * @return View
     */
    public function add(ConferenceInputModel $model)
    {
        if (!$model->isValid()) {
            return new View('conferences', 'add', $model);
        }

        $service = new ConferencesService($this->dbContext);

        if (HttpContext::getInstance()->isPost()) {
            $result = $service->addConference($model);
            if (!$result->hasError()) {
                $this->addInfoMessage($result->getMessage());
                $this->redirect('conferences', 'own');
            } else {
                $this->addErrorMessage($result->getMessage());
                $this->redirect('conferences', 'own');
            }
        } else {
            return new View('conferences', 'add', new ConferenceInputModel());
        }
    }
}