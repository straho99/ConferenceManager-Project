<?php

namespace RedDevil\EntityManager;

class DatabaseContext
{
    private $conferencesParticipantsRepository;
	private $conferencesRepository;
	private $hallsRepository;
	private $lectureBreaksRepository;
	private $lecturesParticipantsRepository;
	private $lecturesRepository;
	private $messagesRepository;
	private $notificationsRepository;
	private $rolesRepository;
	private $speakerInvitationsRepository;
	private $usersRepository;
	private $usersRolesRepository;
	private $venueReservationRequestsRepository;
	private $venuesRepository;

    private $repositories = [];

    /**
     * DatabaseContext constructor.
     
     */
    public function __construct()
    {
        $this->conferencesParticipantsRepository = \RedDevil\Repositories\ConferencesParticipantsRepository::create();
		$this->conferencesRepository = \RedDevil\Repositories\ConferencesRepository::create();
		$this->hallsRepository = \RedDevil\Repositories\HallsRepository::create();
		$this->lectureBreaksRepository = \RedDevil\Repositories\LectureBreaksRepository::create();
		$this->lecturesParticipantsRepository = \RedDevil\Repositories\LecturesParticipantsRepository::create();
		$this->lecturesRepository = \RedDevil\Repositories\LecturesRepository::create();
		$this->messagesRepository = \RedDevil\Repositories\MessagesRepository::create();
		$this->notificationsRepository = \RedDevil\Repositories\NotificationsRepository::create();
		$this->rolesRepository = \RedDevil\Repositories\RolesRepository::create();
		$this->speakerInvitationsRepository = \RedDevil\Repositories\SpeakerInvitationsRepository::create();
		$this->usersRepository = \RedDevil\Repositories\UsersRepository::create();
		$this->usersRolesRepository = \RedDevil\Repositories\UsersRolesRepository::create();
		$this->venueReservationRequestsRepository = \RedDevil\Repositories\VenueReservationRequestsRepository::create();
		$this->venuesRepository = \RedDevil\Repositories\VenuesRepository::create();

        $this->repositories[] = $this->conferencesParticipantsRepository;
		$this->repositories[] = $this->conferencesRepository;
		$this->repositories[] = $this->hallsRepository;
		$this->repositories[] = $this->lectureBreaksRepository;
		$this->repositories[] = $this->lecturesParticipantsRepository;
		$this->repositories[] = $this->lecturesRepository;
		$this->repositories[] = $this->messagesRepository;
		$this->repositories[] = $this->notificationsRepository;
		$this->repositories[] = $this->rolesRepository;
		$this->repositories[] = $this->speakerInvitationsRepository;
		$this->repositories[] = $this->usersRepository;
		$this->repositories[] = $this->usersRolesRepository;
		$this->repositories[] = $this->venueReservationRequestsRepository;
		$this->repositories[] = $this->venuesRepository;
    }

    /**
     * @return \RedDevil\Repositories\ConferencesParticipantsRepository
     */
    public function getConferencesParticipantsRepository()
    {
        return $this->conferencesParticipantsRepository;
    }

    /**
     * @return \RedDevil\Repositories\ConferencesRepository
     */
    public function getConferencesRepository()
    {
        return $this->conferencesRepository;
    }

    /**
     * @return \RedDevil\Repositories\HallsRepository
     */
    public function getHallsRepository()
    {
        return $this->hallsRepository;
    }

    /**
     * @return \RedDevil\Repositories\LectureBreaksRepository
     */
    public function getLectureBreaksRepository()
    {
        return $this->lectureBreaksRepository;
    }

    /**
     * @return \RedDevil\Repositories\LecturesParticipantsRepository
     */
    public function getLecturesParticipantsRepository()
    {
        return $this->lecturesParticipantsRepository;
    }

    /**
     * @return \RedDevil\Repositories\LecturesRepository
     */
    public function getLecturesRepository()
    {
        return $this->lecturesRepository;
    }

    /**
     * @return \RedDevil\Repositories\MessagesRepository
     */
    public function getMessagesRepository()
    {
        return $this->messagesRepository;
    }

    /**
     * @return \RedDevil\Repositories\NotificationsRepository
     */
    public function getNotificationsRepository()
    {
        return $this->notificationsRepository;
    }

    /**
     * @return \RedDevil\Repositories\RolesRepository
     */
    public function getRolesRepository()
    {
        return $this->rolesRepository;
    }

    /**
     * @return \RedDevil\Repositories\SpeakerInvitationsRepository
     */
    public function getSpeakerInvitationsRepository()
    {
        return $this->speakerInvitationsRepository;
    }

    /**
     * @return \RedDevil\Repositories\UsersRepository
     */
    public function getUsersRepository()
    {
        return $this->usersRepository;
    }

    /**
     * @return \RedDevil\Repositories\UsersRolesRepository
     */
    public function getUsersRolesRepository()
    {
        return $this->usersRolesRepository;
    }

    /**
     * @return \RedDevil\Repositories\VenueReservationRequestsRepository
     */
    public function getVenueReservationRequestsRepository()
    {
        return $this->venueReservationRequestsRepository;
    }

    /**
     * @return \RedDevil\Repositories\VenuesRepository
     */
    public function getVenuesRepository()
    {
        return $this->venuesRepository;
    }

    /**
     * @param mixed $conferencesParticipantsRepository
     * @return $this
     */
    public function setConferencesParticipantsRepository($conferencesParticipantsRepository)
    {
        $this->conferencesParticipantsRepository = $conferencesParticipantsRepository;
        return $this;
    }

    /**
     * @param mixed $conferencesRepository
     * @return $this
     */
    public function setConferencesRepository($conferencesRepository)
    {
        $this->conferencesRepository = $conferencesRepository;
        return $this;
    }

    /**
     * @param mixed $hallsRepository
     * @return $this
     */
    public function setHallsRepository($hallsRepository)
    {
        $this->hallsRepository = $hallsRepository;
        return $this;
    }

    /**
     * @param mixed $lectureBreaksRepository
     * @return $this
     */
    public function setLectureBreaksRepository($lectureBreaksRepository)
    {
        $this->lectureBreaksRepository = $lectureBreaksRepository;
        return $this;
    }

    /**
     * @param mixed $lecturesParticipantsRepository
     * @return $this
     */
    public function setLecturesParticipantsRepository($lecturesParticipantsRepository)
    {
        $this->lecturesParticipantsRepository = $lecturesParticipantsRepository;
        return $this;
    }

    /**
     * @param mixed $lecturesRepository
     * @return $this
     */
    public function setLecturesRepository($lecturesRepository)
    {
        $this->lecturesRepository = $lecturesRepository;
        return $this;
    }

    /**
     * @param mixed $messagesRepository
     * @return $this
     */
    public function setMessagesRepository($messagesRepository)
    {
        $this->messagesRepository = $messagesRepository;
        return $this;
    }

    /**
     * @param mixed $notificationsRepository
     * @return $this
     */
    public function setNotificationsRepository($notificationsRepository)
    {
        $this->notificationsRepository = $notificationsRepository;
        return $this;
    }

    /**
     * @param mixed $rolesRepository
     * @return $this
     */
    public function setRolesRepository($rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
        return $this;
    }

    /**
     * @param mixed $speakerInvitationsRepository
     * @return $this
     */
    public function setSpeakerInvitationsRepository($speakerInvitationsRepository)
    {
        $this->speakerInvitationsRepository = $speakerInvitationsRepository;
        return $this;
    }

    /**
     * @param mixed $usersRepository
     * @return $this
     */
    public function setUsersRepository($usersRepository)
    {
        $this->usersRepository = $usersRepository;
        return $this;
    }

    /**
     * @param mixed $usersRolesRepository
     * @return $this
     */
    public function setUsersRolesRepository($usersRolesRepository)
    {
        $this->usersRolesRepository = $usersRolesRepository;
        return $this;
    }

    /**
     * @param mixed $venueReservationRequestsRepository
     * @return $this
     */
    public function setVenueReservationRequestsRepository($venueReservationRequestsRepository)
    {
        $this->venueReservationRequestsRepository = $venueReservationRequestsRepository;
        return $this;
    }

    /**
     * @param mixed $venuesRepository
     * @return $this
     */
    public function setVenuesRepository($venuesRepository)
    {
        $this->venuesRepository = $venuesRepository;
        return $this;
    }

    public function saveChanges()
    {
        foreach ($this->repositories as $repository) {
            $repositoryName = get_class($repository);
            $repositoryName::save();
        }
    }
}