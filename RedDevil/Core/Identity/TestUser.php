<?php

namespace RedDevil\Core\Identity;

class TestUser extends IdentityUser {
    protected $telephone;

    /**
     * @type varchar(100)
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }


}