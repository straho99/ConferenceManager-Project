<?php

namespace RedDevil\Services;

use RedDevil\ViewModels\ConferenceSearchResultModel;
use RedDevil\ViewModels\SearchResultViewModel;
use RedDevil\ViewModels\UserSearchResultModel;
use RedDevil\ViewModels\VenueSearchResultModel;

class SearchServices extends BaseService {
	
	public function search(string $keyword)  : ServiceResponse {

        if ($keyword == '') {
            return new ServiceResponse(1, "Search keyword cannot be empty.");
        }

		$searchResults = new SearchResultViewModel();
        $searchExpression = "%" . $keyword . "%";

		$users = $this->dbContext->getUsersRepository()
			->filterByUsername(" like '$searchExpression'")
			->findAll();
		foreach($users->getUsers() as $user) {
			$model = new UserSearchResultModel($user);
			$searchResults->addResult($model);
		}

		$venues = $this->dbContext->getVenuesRepository()
			->filterByTitle(" like '$searchExpression'")
			->findAll();
		foreach($venues->getVenues() as $venue) {
			$model = new VenueSearchResultModel($venue);
			$searchResults->addResult($model);
		}

		$conferences = $this->dbContext->getConferencesRepository()
			->filterByTitle(" like '$searchExpression'")
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
