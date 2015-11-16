<?php

namespace RedDevil\Controllers;

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
}