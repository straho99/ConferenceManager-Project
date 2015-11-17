<?php

namespace RedDevil\Controllers;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Venue\VenueInputModel;
use RedDevil\Services\VenuesServices;
use RedDevil\View;

class VenuesController extends BaseController {

    /**
     * @return View
     */
    public function all()
    {
        $service = new VenuesServices($this->dbContext);
        $allVenues =$service->getAllVenues();

        return new View('Venues', 'all', $allVenues);
    }

    /**
     * @param $venueId
     * @return View
     * @Route('venues/details/{integer $venueId}')
     */
    public function details($venueId)
    {
        $service = new VenuesServices($this->dbContext);
        $venueModel =$service->getVenueDetails($venueId);

        return new View('Venues', 'details', $venueModel);
    }

    /**
     * @param VenueInputModel $model
     * @return View
     */
    public function add(VenueInputModel $model)
    {
        if (!$model->isValid()) {
            return new View('venues', 'add', $model);
        }

        $service = new VenuesServices($this->dbContext);

        if (HttpContext::getInstance()->isPost()) {
            $result = $service->addVenue($model);
            if (!$result->hasError()) {
                $this->addInfoMessage($result->getMessage());
                $this->redirect('venues', 'own');
            } else {
                $this->addErrorMessage($result->getMessage());
                $this->redirect('venues', 'own');
            }
        } else {
            return new View('venues', 'add', new VenueInputModel());
        }
    }
}