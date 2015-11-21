<?php 
namespace RedDevil\Config; 
class RoutesConfig { 
	 public static $dateOfLastCheck = '2015-11-21 17:36:42';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'edit',
			 'route' => 'conferences/{integer $conferenceId}/edit',
			 'annotations' => [
				'method' => 'get',
				'route' => 'conferences/{integer $conferenceid}/edit',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'change',
			 'route' => 'conferences/{integer $conferenceId}/change',
			 'annotations' => [
				'method' => 'post',
				'route' => 'conferences/{integer $conferenceid}/change',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'details',
			 'route' => 'conferences/details/{integer $conferenceId}',
			 'annotations' => [
				'method' => 'get',
				'route' => 'conferences/details/{integer $conferenceid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'delete',
			 'route' => 'lectures/{integer $lectureId}/delete',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/delete',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'invite',
			 'route' => 'lectures/{integer $lectureId}/invite/{integer $speakerId}',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/invite/{integer $speakerid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'cancelInvitation',
			 'route' => 'lectures/{integer $lectureId}/cancelinvitation/{integer $speakerId}',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/cancelinvitation/{integer $speakerid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addHall',
			 'route' => 'lectures/{integer $lectureId}/addhall/{integer $hallId}',
			 'annotations' => [
				'method' => ['post', 'get'],
				'route' => 'lectures/{integer $lectureid}/addhall/{integer $hallid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'deleteHall',
			 'route' => 'lectures/{integer $lectureId}/deletehall/{integer $hallId}',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/deletehall/{integer $hallid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addBreak',
			 'route' => 'lectures/{integer $lectureId}/addbreak',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/addbreak',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addParticipant',
			 'route' => 'lectures/{integer $lectureId}/addparticipant/{integer $participantId}',
			 'annotations' => [
				'method' => ['post', 'get'],
				'route' => 'lectures/{integer $lectureid}/addparticipant/{integer $participantid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'deleteParticipant',
			 'route' => 'lectures/{integer $lectureId}/deleteparticipant/{integer $participantId}',
			 'annotations' => [
				'method' => ['post', 'get'],
				'route' => 'lectures/{integer $lectureid}/deleteparticipant/{integer $participantid}',
			 ]
		 ], 
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
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'edit',
			 'route' => 'conferences/edit',
			 'annotations' => [
				'method' => 'get',
				'route' => 'conferences/{integer $conferenceid}/edit',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'change',
			 'route' => 'conferences/change',
			 'annotations' => [
				'method' => 'post',
				'route' => 'conferences/{integer $conferenceid}/change',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'details',
			 'route' => 'conferences/details',
			 'annotations' => [
				'method' => 'get',
				'route' => 'conferences/details/{integer $conferenceid}',
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
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'add',
			 'route' => 'lectures/add',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'delete',
			 'route' => 'lectures/delete',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/delete',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'invite',
			 'route' => 'lectures/invite',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/invite/{integer $speakerid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'cancelInvitation',
			 'route' => 'lectures/cancelInvitation',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/cancelinvitation/{integer $speakerid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addHall',
			 'route' => 'lectures/addHall',
			 'annotations' => [
				'method' => ['post', 'get'],
				'route' => 'lectures/{integer $lectureid}/addhall/{integer $hallid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'deleteHall',
			 'route' => 'lectures/deleteHall',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/deletehall/{integer $hallid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addBreak',
			 'route' => 'lectures/addBreak',
			 'annotations' => [
				'method' => 'post',
				'route' => 'lectures/{integer $lectureid}/addbreak',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addParticipant',
			 'route' => 'lectures/addParticipant',
			 'annotations' => [
				'method' => ['post', 'get'],
				'route' => 'lectures/{integer $lectureid}/addparticipant/{integer $participantid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'deleteParticipant',
			 'route' => 'lectures/deleteParticipant',
			 'annotations' => [
				'method' => ['post', 'get'],
				'route' => 'lectures/{integer $lectureid}/deleteparticipant/{integer $participantid}',
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