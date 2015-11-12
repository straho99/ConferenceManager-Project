<?php

namespace RedDevil\EntityManager;

class DatabaseContext
{
    private $todosRepository;

    private $usersRepository;

    private $repositories = [];

    /**
     * DatabaseContext constructor.
     * @param $buildingsRepository
     * @param $usersRepository
     */
    public function __construct($todosRepository, $usersRepository)
    {
        $this->todosRepository = $todosRepository;
        $this->usersRepository = $usersRepository;

        $this->repositories[] = $this->todosRepository;
        $this->repositories[] = $this->usersRepository;
    }


    /**
     * @return \RedDevil\Repositories\TodosRepository
     */
    public function getTodosRepository()
    {
        return $this->todosRepository;
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
     * @return \RedDevil\Repositories\UsersRepository
     */
    public function getUsersRepository()
    {
        return $this->usersRepository;
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