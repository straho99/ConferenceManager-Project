<?php 
namespace RedDevil\Config; 
class RoutesConfig { 
	 public static $dateOfLastCheck = '2015-11-13 17:57:44';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'RedDevil\Areas\Area1\Controllers\AreaController',
			 'action' => 'doSomething',
			 'route' => 'annotationroute/{string username}/posts/{boolean logged}',
			 'annotations' => [
				'route' => 'annotationroute/{string username}/posts/{boolean logged}',
				'role' => 'venueowner',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Areas\Area1\Controllers\AreaController',
			 'action' => 'doSomething',
			 'route' => 'area1/area/doSomething',
			 'annotations' => [
				'route' => 'annotationroute/{string username}/posts/{boolean logged}',
				'role' => 'venueowner',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Areas\Area1\Controllers\AreaController',
			 'action' => 'doSomethingElse',
			 'route' => 'area1/area/doSomethingElse',
			 'annotations' => [
				'method' => ['get', 'post'],
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Areas\Area2\Controllers\AnotherController',
			 'action' => 'doSomething',
			 'route' => 'area2/another/doSomething',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Areas\Area2\Controllers\AnotherController',
			 'action' => 'doSomethingElse',
			 'route' => 'area2/another/doSomethingElse',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AccountController',
			 'action' => 'register',
			 'route' => 'account/register',
			 'annotations' => [
				'method' => 'get',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AccountController',
			 'action' => 'login',
			 'route' => 'account/login',
			 'annotations' => [
				'method' => 'get',
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
			 'controller' => 'RedDevil\Controllers\ExperimentController',
			 'action' => 'index',
			 'route' => 'experiment/index',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ExperimentController',
			 'action' => 'ajax',
			 'route' => 'experiment/ajax',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ExperimentController',
			 'action' => 'processAjaxRequest',
			 'route' => 'experiment/processAjaxRequest',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ExperimentController',
			 'action' => 'routes',
			 'route' => 'experiment/routes',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ExperimentController',
			 'action' => 'displayalltodos',
			 'route' => 'experiment/displayalltodos',
			 'annotations' => [
				'method' => 'get',
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
			 'controller' => 'RedDevil\Controllers\UserController',
			 'action' => 'register',
			 'route' => 'user/register',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UserController',
			 'action' => 'login',
			 'route' => 'user/login',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UserController',
			 'action' => 'logout',
			 'route' => 'user/logout',
			 'annotations' => [
			 ]
		 ], 
	 ]; 
}
?>