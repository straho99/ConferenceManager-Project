<?php 
namespace RedDevil\Config; 
class RoutesConfig { 
	 public static $dateOfLastCheck = '2015-11-29 02:58:14';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'RedDevil\Controllers\AdminController',
			 'action' => 'manageRoles',
			 'route' => 'admin/manageroles',
			 'annotations' => [
				'role' => 'admin',
				'route' => 'admin/manageroles',
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
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'requestVenue',
			 'route' => 'conferences/{integer $conferenceId}/requestvenue',
			 'annotations' => [
				'method' => 'get',
				'route' => 'conferences/{integer $conferenceid}/requestvenue',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'addVenueRequest',
			 'route' => 'conferences/addvenuerequest',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'conferences/addvenuerequest',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'confirmDeleteConference',
			 'route' => 'conferences/{integer $conferenceId}/delete/confirm',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'conferences/{integer $conferenceid}/delete/confirm',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'delete',
			 'route' => 'conferences/{integer $$conferenceId}/delete',
			 'annotations' => [
				'method' => 'post',
				'route' => 'conferences/{integer $$conferenceid}/delete',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'autoSchedule',
			 'route' => 'conferences/autoSchedule/{integer $conferenceId}',
			 'annotations' => [
				'route' => 'conferences/autoschedule/{integer $conferenceid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'batchBook',
			 'route' => 'conferences/batchBook',
			 'annotations' => [
				'route' => 'conferences/batchbook',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'add',
			 'route' => 'lectures/add/{integer $conferenceId}',
			 'annotations' => [
				'method' => ['get', 'post'],
				'route' => 'lectures/add/{integer $conferenceid}',
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
			 'action' => 'confirmDeleteLecture',
			 'route' => 'lectures/{integer $lectureId}/delete/confirm',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'lectures/{integer $lectureid}/delete/confirm',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'invite',
			 'route' => 'conferences/{integer $conferenceId}/lectures/{integer $lectureId}/invite',
			 'annotations' => [
				'method' => 'get',
				'route' => 'conferences/{integer $conferenceid}/lectures/{integer $lectureid}/invite',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'sendInvitation',
			 'route' => 'lectures/sendinvitation',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'lectures/sendinvitation',
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
			 'action' => 'halls',
			 'route' => 'lectures/{integer $lectureId}/halls',
			 'annotations' => [
				'method' => 'get',
				'route' => 'lectures/{integer $lectureid}/halls',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addHall',
			 'route' => 'lectures/addhall',
			 'annotations' => [
				'validatetoken' => 'token',
				'method' => 'post',
				'route' => 'lectures/addhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addBreak',
			 'route' => 'lectures/{integer $lectureId}/addbreak',
			 'annotations' => [
				'validatetoken' => 'token',
				'method' => ['get', 'post'],
				'route' => 'lectures/{integer $lectureid}/addbreak',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'participate',
			 'route' => 'lectures/{integer $lectureId}/participate',
			 'annotations' => [
				'method' => ['post', 'get'],
				'route' => 'lectures/{integer $lectureid}/participate',
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
			 'route' => 'users/{string $username}/info',
			 'annotations' => [
				'method' => 'get',
				'route' => 'users/{string $username}/info',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'invitations',
			 'route' => 'users/invitations',
			 'annotations' => [
				'route' => 'users/invitations',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'approveInvitation',
			 'route' => 'users/approveinvitation/{integer $invitationId}',
			 'annotations' => [
				'method' => 'get',
				'route' => 'users/approveinvitation/{integer $invitationid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'rejectInvitation',
			 'route' => 'users/rejectinvitation/{integer $invitationId}',
			 'annotations' => [
				'method' => 'get',
				'route' => 'users/rejectinvitation/{integer $invitationid}',
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
				'validatetoken' => 'token',
				'route' => 'venues/{integer $venueid}/addhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'createHall',
			 'route' => 'venues/createhall',
			 'annotations' => [
				'validatetoken' => 'token',
				'method' => 'post',
				'route' => 'venues/createhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'approveRequest',
			 'route' => 'venues/approverequest/{integer $requestId}',
			 'annotations' => [
				'method' => 'get',
				'route' => 'venues/approverequest/{integer $requestid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'rejectRequest',
			 'route' => 'venues/rejectrequest/{integer $requestId}',
			 'annotations' => [
				'method' => 'get',
				'route' => 'venues/rejectrequest/{integer $requestid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'deleteHall',
			 'route' => 'venues/{integer $venueId}/deletehall/{integer $hallId}',
			 'annotations' => [
				'route' => 'venues/{integer $venueid}/deletehall/{integer $hallid}',
				'method' => 'post',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'confirmDeleteHall',
			 'route' => 'venues/{integer $venueId}/deletehall/{integer $hallId}/confirm',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'venues/{integer $venueid}/deletehall/{integer $hallid}/confirm',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'confirmDeleteVenue',
			 'route' => 'venues/{integer $venueId}/delete/confirm',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'venues/{integer $venueid}/delete/confirm',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'delete',
			 'route' => 'venues/{integer $venueId}/delete',
			 'annotations' => [
				'route' => 'venues/{integer $venueid}/delete',
				'method' => 'post',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AccountController',
			 'action' => 'register',
			 'route' => 'account/register',
			 'annotations' => [
				'validatetoken' => 'token',
				'method' => ['get', 'post'],
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AccountController',
			 'action' => 'login',
			 'route' => 'account/login',
			 'annotations' => [
				'method' => ['get', 'post'],
				'validatetoken' => 'token',
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
				'validatetoken' => 'token',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AdminController',
			 'action' => 'manageRoles',
			 'route' => 'admin/manageRoles',
			 'annotations' => [
				'role' => 'admin',
				'route' => 'admin/manageroles',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\AdminController',
			 'action' => 'addRole',
			 'route' => 'admin/addRole',
			 'annotations' => [
				'method' => 'post',
				'role' => 'admin',
				'validatetoken' => 'token',
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
				'validatetoken' => 'token',
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
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'requestVenue',
			 'route' => 'conferences/requestVenue',
			 'annotations' => [
				'method' => 'get',
				'route' => 'conferences/{integer $conferenceid}/requestvenue',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'addVenueRequest',
			 'route' => 'conferences/addVenueRequest',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'conferences/addvenuerequest',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'own',
			 'route' => 'conferences/own',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'confirmDeleteConference',
			 'route' => 'conferences/confirmDeleteConference',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'conferences/{integer $conferenceid}/delete/confirm',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'delete',
			 'route' => 'conferences/delete',
			 'annotations' => [
				'method' => 'post',
				'route' => 'conferences/{integer $$conferenceid}/delete',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'autoSchedule',
			 'route' => 'conferences/autoSchedule',
			 'annotations' => [
				'route' => 'conferences/autoschedule/{integer $conferenceid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\ConferencesController',
			 'action' => 'batchBook',
			 'route' => 'conferences/batchBook',
			 'annotations' => [
				'route' => 'conferences/batchbook',
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
				'method' => ['get', 'post'],
				'route' => 'lectures/add/{integer $conferenceid}',
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
			 'action' => 'confirmDeleteLecture',
			 'route' => 'lectures/confirmDeleteLecture',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'lectures/{integer $lectureid}/delete/confirm',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'invite',
			 'route' => 'lectures/invite',
			 'annotations' => [
				'method' => 'get',
				'route' => 'conferences/{integer $conferenceid}/lectures/{integer $lectureid}/invite',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'sendInvitation',
			 'route' => 'lectures/sendInvitation',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'lectures/sendinvitation',
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
			 'action' => 'halls',
			 'route' => 'lectures/halls',
			 'annotations' => [
				'method' => 'get',
				'route' => 'lectures/{integer $lectureid}/halls',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addHall',
			 'route' => 'lectures/addHall',
			 'annotations' => [
				'validatetoken' => 'token',
				'method' => 'post',
				'route' => 'lectures/addhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'addBreak',
			 'route' => 'lectures/addBreak',
			 'annotations' => [
				'validatetoken' => 'token',
				'method' => ['get', 'post'],
				'route' => 'lectures/{integer $lectureid}/addbreak',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'participate',
			 'route' => 'lectures/participate',
			 'annotations' => [
				'method' => ['post', 'get'],
				'route' => 'lectures/{integer $lectureid}/participate',
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
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'joined',
			 'route' => 'lectures/joined',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\LecturesController',
			 'action' => 'own',
			 'route' => 'lectures/own',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\NotificationsController',
			 'action' => 'markAllAsRead',
			 'route' => 'notifications/markAllAsRead',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\NotificationsController',
			 'action' => 'all',
			 'route' => 'notifications/all',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\SearchController',
			 'action' => 'find',
			 'route' => 'search/find',
			 'annotations' => [
				'validatetoken' => 'token',
				'method' => 'post',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'users',
			 'route' => 'users/users',
			 'annotations' => [
				'method' => 'get',
				'route' => 'users/{string $username}/info',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'invitations',
			 'route' => 'users/invitations',
			 'annotations' => [
				'route' => 'users/invitations',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'approveInvitation',
			 'route' => 'users/approveInvitation',
			 'annotations' => [
				'method' => 'get',
				'route' => 'users/approveinvitation/{integer $invitationid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\UsersController',
			 'action' => 'rejectInvitation',
			 'route' => 'users/rejectInvitation',
			 'annotations' => [
				'method' => 'get',
				'route' => 'users/rejectinvitation/{integer $invitationid}',
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
				'validatetoken' => 'token',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'addHall',
			 'route' => 'venues/addHall',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'venues/{integer $venueid}/addhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'createHall',
			 'route' => 'venues/createHall',
			 'annotations' => [
				'validatetoken' => 'token',
				'method' => 'post',
				'route' => 'venues/createhall',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'requests',
			 'route' => 'venues/requests',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'approveRequest',
			 'route' => 'venues/approveRequest',
			 'annotations' => [
				'method' => 'get',
				'route' => 'venues/approverequest/{integer $requestid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'rejectRequest',
			 'route' => 'venues/rejectRequest',
			 'annotations' => [
				'method' => 'get',
				'route' => 'venues/rejectrequest/{integer $requestid}',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'own',
			 'route' => 'venues/own',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'deleteHall',
			 'route' => 'venues/deleteHall',
			 'annotations' => [
				'route' => 'venues/{integer $venueid}/deletehall/{integer $hallid}',
				'method' => 'post',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'confirmDeleteHall',
			 'route' => 'venues/confirmDeleteHall',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'venues/{integer $venueid}/deletehall/{integer $hallid}/confirm',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'confirmDeleteVenue',
			 'route' => 'venues/confirmDeleteVenue',
			 'annotations' => [
				'validatetoken' => 'token',
				'route' => 'venues/{integer $venueid}/delete/confirm',
			 ]
		 ], 
		 [ 
			 'controller' => 'RedDevil\Controllers\VenuesController',
			 'action' => 'delete',
			 'route' => 'venues/delete',
			 'annotations' => [
				'route' => 'venues/{integer $venueid}/delete',
				'method' => 'post',
			 ]
		 ], 
	 ]; 
}
?>