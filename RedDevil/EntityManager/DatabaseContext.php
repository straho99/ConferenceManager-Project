<?php

namespace RedDevil\EntityManager;

class DatabaseContext
{
    private $rolesRepository;
	private $todosRepository;
	private $usersRepository;

    private $repositories = [];

    /**
     * DatabaseContext constructor.
     * @param $rolesRepository
	* @param $todosRepository
	* @param $usersRepository
     */
    public function __construct($rolesRepository, $todosRepository, $usersRepository)
    {
        $this->rolesRepository = $rolesRepository;
		$this->todosRepository = $todosRepository;
		$this->usersRepository = $usersRepository;

        $this->repositories[] = $this->rolesRepository;
		$this->repositories[] = $this->todosRepository;
		$this->repositories[] = $this->usersRepository;
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

    public function saveChanges()
    {
        foreach ($this->repositories as $repository) {
            $repositoryName = get_class($repository);
            $repositoryName::save();
        }
    }
}