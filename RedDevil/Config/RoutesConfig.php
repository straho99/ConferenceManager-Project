<?php 
namespace RedDevil\Config; 
class RoutesConfig { 
	 public static $dateOfLastCheck = '2015-11-17 21:56:56';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'users',
			 'route' => 'users/{string $username}',
			 'annotations' => [
				'method' => 'get',
				'route' => 'users/{string $username}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'details',
			 'route' => 'venues/details/{integer $venueId}',
			 'annotations' => [
				'route' => 'venues/details/{integer $venueid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'addHall',
			 'route' => 'venues/{integer $venueId}/addhall',
			 'annotations' => [
				'route' => 'venues/{integer $venueid}/addhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'createHall',
			 'route' => 'venues/createhall',
			 'annotations' => [
				'method' => 'post',
				'route' => 'venues/createhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'deleteHall',
			 'route' => 'venues/{integer $venueId}/deletehall/{integer $hallId}',
			 'annotations' => [
				'method' => 'get',
				'route' => 'venues/{integer $venueid}/deletehall/{integer $hallid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AccountController',
			 'action' => 'register',
			 'route' => 'account/register',
			 'annotations' => [
				'method' => ['get', 'post'],
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AccountController',
			 'action' => 'login',
			 'route' => 'account/login',
			 'annotations' => [
				'method' => ['get', 'post'],
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AccountController',
			 'action' => 'logout',
			 'route' => 'account/logout',
			 'annotations' => [
				'method' => 'get',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AccountController',
			 'action' => 'changePassword',
			 'route' => 'account/changePassword',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'all',
			 'route' => 'conferences/all',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'add',
			 'route' => 'conferences/add',
			 'annotations' => [
				'method' => ['get', 'post'],
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\HomeController',
			 'action' => 'index',
			 'route' => 'home/index',
			 'annotations' => [
				'method' => 'get',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'users',
			 'route' => 'users/users',
			 'annotations' => [
				'method' => 'get',
				'route' => 'users/{string $username}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'all',
			 'route' => 'venues/all',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'details',
			 'route' => 'venues/details',
			 'annotations' => [
				'route' => 'venues/details/{integer $venueid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'add',
			 'route' => 'venues/add',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'addHall',
			 'route' => 'venues/addHall',
			 'annotations' => [
				'route' => 'venues/{integer $venueid}/addhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'createHall',
			 'route' => 'venues/createHall',
			 'annotations' => [
				'method' => 'post',
				'route' => 'venues/createhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'deleteHall',
			 'route' => 'venues/deleteHall',
			 'annotations' => [
				'method' => 'get',
				'route' => 'venues/{integer $venueid}/deletehall/{integer $hallid}',
			 ]
		 ], 
	 ]; 
}
?>