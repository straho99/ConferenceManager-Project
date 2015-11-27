<?php

namespace RedDevil\Services;

public class SearchServices extends BaseService {
	
	public function search($keyword) {
		$searchResults = new SearchResultsModel();

		$users = $this->dbContext->getUsersRepository()
			->filterByUsername(" like '$keyword'")
			->findAll();
		foreach($users->getUsers() as $user) {
			$model = new UserSearchResult($user);
			$searchResults->addresult($model);
		}

		$venues = $this->dbContext->getVenuesRepository()
			->filterByTitle(" like '$keyword'")
			->findAll();
		foreach($venues->getVenues() as $venue) {
			$model = new VenueSearchResult($model);
			$searchResults->addresult($model);
		}

		$conferences = $this->dbContext->getConferencesRepository()
			->filterByTitle(" like '$keyword'")
			->findAll();
		foreach($conferences->getConferences() as $conference) {
			$model = new ConferenceSearchResult($model);
			$searchResults->addresult($model);
		}
		
		return new ServiceRessponse(null, null, $searchResults);
	}
}
?>
