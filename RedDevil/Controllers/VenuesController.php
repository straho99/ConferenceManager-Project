<?php

namespace RedDevil\Controllers;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Venue\HallInputModel;
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
     * @Validatetoken('token')
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

    /**
     * @param $venueId
     * @return View
     * @Validatetoken('token')
     * @Route('venues/{integer $venueId}/addhall')
     */
    public function addHall($venueId)
    {
        return new View('venues', 'addhall', $venueId);
    }

    /**
     * @param HallInputModel $model
     * @return View
     * @Validatetoken('token')
     * @Method('POST')
     * @Route('venues/createhall')
     */
    public function createHall(HallInputModel $model)
    {
        if (!$model->isValid()) {
            return new View('venues', 'addhall', $model->getVenueId());
        }

        $service = new VenuesServices($this->dbContext);
        $result = $service->addHall($model);
        if (!$result->hasError()) {
            $this->addInfoMessage($result->getMessage());
            $this->redirectToUrl('/venues/details/' . $model->getVenueId());
        } else {
            $this->addErrorMessage($result->getMessage());
            $this->redirectToUrl('/venues/details/' . $model->getVenueId());
        }
    }
    
    public function requests()
    {
        $service = new VenuesServices($this->dbContext);
        $response = $service->getVenueRequestsForUser();
        return new View("Venues", "requests", $response->getModel());
    }

    /**
     * @param $requestId
     * @Method('GET')
     * @Route('venues/approverequest/{integer $requestId}')
     */
    public function approveRequest($requestId)
    {
        $service = new VenuesServices($this->dbContext);
        $response = $service->replyToVenueRequest(true, $requestId);
        $this->processResponse($response);
        $this->redirect("Home", "Index");
    }

    /**
     * @param $requestId
     * @Method('GET')
     * @Route('venues/rejectrequest/{integer $requestId}')
     */
    public function rejectRequest($requestId)
    {
        $service = new VenuesServices($this->dbContext);
        $response = $service->replyToVenueRequest(false, $requestId);
        $this->processResponse($response);
        $this->redirect("Home", "Index");
    }

    /**
     * Authorize()
     * @return View
     * @throws \Exception
     */
    public function own()
    {
        $service = new VenuesServices($this->dbContext);
        $response = $service->getUserVenues();
        $this->processResponse($response);

        return new View('Venues', 'own', $response->getModel());
    }

    /**
     * @param $venueId
     * @param $hallId
     * @Route('venues/{integer $venueId}/deletehall/{integer $hallId}')
     * @Method('POST')
     */
    public function deleteHall($venueId, $hallId)
    {
        $service = new VenuesServices($this->dbContext);
        $response = $service->deleteHall($venueId, $hallId);
        $this->processResponse($response);

        $this->redirectToUrl('/venues/details/' . $response->getModel());
    }

    /**
     * @param $venueId
     * @param $hallId
     * @ValidateToken('token')
     * @Route('venues/{integer $venueId}/deletehall/{integer $hallId}/confirm')
     * @return View
     */
    public function confirmDeleteHall($venueId, $hallId)
    {
        if (HttpContext::getInstance()->isPost()) {
            $this->redirectToUrl('/venues/' . $venueId . '/deletehall/' . $hallId);
        } else {
            return new View('Venues', 'confirmDeleteHall', ['venueId' => $venueId, 'hallId' => $hallId]);
        }
    }

    /**
     * @param $venueId
     * @ValidateToken('token')
     * @Route('venues/{integer $venueId}/delete/confirm')
     * @return View
     */
    public function confirmDeleteVenue($venueId)
    {
        if (HttpContext::getInstance()->isPost()) {
            $this->redirectToUrl('/venues/' . $venueId . '/delete');
        } else {
            return new View('Venues', 'confirmDeleteVenue', $venueId);
        }
    }

    /**
     * @param $venueId
     * @Route('venues/{integer $venueId}/delete')
     * @Method('POST')
     */
    public function delete($venueId)
    {
        $service = new VenuesServices($this->dbContext);
        $response = $service->deleteVenue($venueId);
        $this->processResponse($response);

        $this->redirectToUrl('/venues/own');
    }

}