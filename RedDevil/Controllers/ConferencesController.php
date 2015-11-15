<?php

namespace RedDevil\Controllers;

use RedDevil\Services\ConferencesService;
use RedDevil\View;

class ConferencesController extends BaseController {
    
    public function all()
    {
        $service = new ConferencesService($this->dbContext);
        $allConferences =$service->getAllConferences();

        return new View('Conferences', 'all', $allConferences);
    }
}