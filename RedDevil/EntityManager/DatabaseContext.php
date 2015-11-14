<?php

namespace RedDevil\EntityManager;

class DatabaseContext
{
    private $rolesRepository;
	private $todosRepository;
	private $usersRepository;
	private $usersRolesRepository;

    private $repositories = [];

    /**
     * DatabaseContext constructor.
     
     */
    public function __construct()
    {
        $this->rolesRepository = \RedDevil\Repositories\RolesRepository::create();
		$this->todosRepository = \RedDevil\Repositories\TodosRepository::create();
		$this->usersRepository = \RedDevil\Repositories\UsersRepository::create();
		$this->usersRolesRepository = \RedDevil\Repositories\UsersRolesRepository::create();

        $this->repositories[] = $this->rolesRepository;
		$this->repositories[] = $this->todosRepository;
		$this->repositories[] = $this->usersRepository;
		$this->repositories[] = $this->usersRolesRepository;
    }

    /**
     * @return \RedDevil\Repositories\RolesRepository
     */
    public function getRolesRepository()
    {
        return $this->rolesRepository;
    }

    /**
     * @return \RedDevil\Repositories\TodosRepository
     */
    public function getTodosRepository()
    {
        return $this->todosRepository;
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
     * @param mixed $rolesRepository
     * @return $this
     */
    public function setRolesRepository($rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
        return $this;
    }

    /**
     * @param mixed $todosRepository
     * @return $this
     */
    public function setTodosRepository($todosRepository)
    {
        $this->todosRepository = $todosRepository;
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

    public function saveChanges()
    {
        foreach ($this->repositories as $repository) {
            $repositoryName = get_class($repository);
            $repositoryName::save();
        }
    }
}