<?php

namespace RedDevil\Services;

use ConferenceSearchResultModel;
use RedDevil\ViewModels\SearchResultViewModel;
use UserSearchResultModel;
use VenueSearchResultModel;

class SearchServices extends BaseService {
	
	public function search($keyword) {
		$searchResults = new SearchResultViewModel();

		$users = $this->dbContext->getUsersRepository()
			->filterByUsername(" like '$keyword'")
			->findAll();
		foreach($users->getUsers() as $user) {
			$model = new UserSearchResultModel($user);
			$searchResults->addResult($model);
		}

		$venues = $this->dbContext->getVenuesRepository()
			->filterByTitle(" like '$keyword'")
			->findAll();
		foreach($venues->getVenues() as $venue) {
			$model = new VenueSearchResultModel($venue);
			$searchResults->addResult($model);
		}

		$conferences = $this->dbContext->getConferencesRepository()
			->filterByTitle(" like '$keyword'")
			->findAll();
		foreach($conferences->getConferences() as $conference) {
			$model = new ConferenceSearchResultModel($conference);
            $userId = $conference->getOwnerId();
            $ownerUserName = $this->dbContext->getUsersRepository()
                ->filterById(" = $userId")
                ->findOne()
                ->getUsername();
            $model->setOwnerUsername($ownerUserName);

			$searchResults->addResult($model);
		}
		
		return new ServiceResponse(null, null, $searchResults);
	}
}
?>
