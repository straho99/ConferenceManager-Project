<?php 
namespace RedDevil\Config; 
class RoutesConfig { 
	 public static $dateOfLastCheck = '2015-11-14 17:27:43';

	 public static $ROUTES = [ 
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