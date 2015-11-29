<?php

namespace RedDevil\Controllers;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Conference\BatchBookLectures;
use RedDevil\InputModels\Conference\ConferenceInputModel;
use RedDevil\InputModels\Venue\VenueRequestInputModel;
use RedDevil\Services\ConferencesService;
use RedDevil\View;
use RedDevil\ViewModels\VenueRequestViewModel;
use RedDevil\ViewModels\VenueSummaryViewModel;

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
     * @Validatetoken('token')
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

    /**
     * @Method('GET')
     * @Route('conferences/details/{integer $conferenceId}')
     * @return View
     */
    public function details($conferenceId)
    {
        $service = new ConferencesService($this->dbContext);
        $conference =$service->getConferenceDetails($conferenceId);

        return new View('Conferences', 'details', $conference);
    }

    /**
     * @Method('GET')
     * @Route('conferences/{integer $conferenceId}/requestvenue')
     * @param $conferenceId
     * @return View
     */
    public function requestVenue($conferenceId)
    {
        $service = new ConferencesService($this->dbContext);

        $venues = $this->dbContext->getVenuesRepository()
            ->orderBy('Title')
            ->findAll()
            ->getVenues();
        $venueModels = [];
        foreach ($venues as $venue) {
            $model = new VenueRequestViewModel(
                $venue->getId(),
                $conferenceId,
                $venue->getTitle()
            );
            $venueModels[] = $model;
        }

        return new View('conferences', 'requestVenue', $venueModels);
    }

    /**
     * Method('POST')
     * @Validatetoken('token')
     * @param VenueRequestInputModel $model
     * @Route('conferences/addvenuerequest')
     */
    public function addVenueRequest(VenueRequestInputModel $model)
    {
        if (!$model->isValid()) {
            $this->redirect('Conferences', 'all');
        }

        $service = new ConferencesService($this->dbContext);
        $result = $service->sendVenueRequest($model);
        $this->processResponse($result);
        $this->redirectToUrl('/conferences/details/' . $model->getConferenceId());
    }

    /**
     * Authorize()
     * @return View
     * @throws \Exception
     */
    public function own()
    {
        $service = new ConferencesService($this->dbContext);
        $response = $service->getUserConferences();
        $this->processResponse($response);

        return new View('Conferences', 'own', $response->getModel());
    }

    /**
     * @ValidateToken('token')
     * @Route('conferences/{integer $conferenceId}/delete/confirm')
     * @return View
     */
    public function confirmDeleteConference($conferenceId)
    {
        return new View('Conferences', 'confirmDeleteConference', $conferenceId);
    }

    /**
     * @param $conferenceId
     * @Method('POST')
     * @Route('conferences/{integer $$conferenceId}/delete')
     */
    public function delete($conferenceId)
    {
        $service = new ConferencesService($this->dbContext);
        $result = $service->deleteConference($conferenceId);
        $this->processResponse($result);
        $this->redirectToUrl('conferences/own');
    }

    /**
     * @Route('conferences/autoSchedule/{integer $conferenceId}')
     * @param $conferenceId
     * @return View
     */
    public function autoSchedule($conferenceId)
    {
        $service = new ConferencesService($this->dbContext);

        $response = $service->autoSchedule($conferenceId);
        return new View('Conferences', 'autoSchedule', $response->getModel());
    }

    /**
     * @param BatchBookLectures $lectures
     * @ Method('POST')
     * @Route('conferences/batchBook')
     */
    public function batchBook(BatchBookLectures $lectures)
    {
        $service = new ConferencesService($this->dbContext);
        $response = $service->batchBook($lectures);
    }
}