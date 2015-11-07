<?php

namespace RedDevil\Models;

class UserModel extends BaseModel {

    public function register($username, $password)
    {
        if (!isset($username) || empty($username)) {
            throw new \Exception('Username is missing or empty.');
        }

        if (!isset($password) || empty($password)) {
            throw new \Exception('Password is missing or empty.');
        }

        if ($this->exists($username)) {
            throw new \Exception('Username is taken.');
        }

        $result = $this->db->prepare("insert into users (username, password) values(?, ?)");

        $result->execute([
            $username,
            password_hash($password, PASSWORD_DEFAULT)
        ]);

        if ($result->rowCount() > 0) {
            return true;
        }

        throw new \Exception("Registration failed.");
    }

    public function login($username, $password)
    {
        $result = $this->db->prepare("select * from users where username = ?");
        $result->execute([$username]);

        if ($result->rowCount() == 0) {
            throw new \Exception("Wrong username.");
        }

        $userRow = $result->fetch();

        if (password_verify($password, $userRow['password'])) {
            return [
                'userId' => $userRow['id'],
                'username' => $userRow['username'],
            ];
        }

        throw new \Exception("Wrong password.");
    }

    public function logout()
    {
        session_start();
        session_destroy();
    }

    public function exists($username)
    {
        $result = $this->db->prepare("select id from users where username = ?");
        $result->execute([$username]);

        return $result->rowCount() > 0;
    }

    public function getRoleIdForUser($userId)
    {
        $result = $this->db->prepare("select role_id from users where id = ?");
        $result->execute([$userId]);

        if ($result->rowCount() > 0) {
            return $result->fetch();
        }

        return false;
    }
    
    public function getRoleIdForTitle($roleTitle)
    {
        $result = $this->db->prepare("select id from roles where title = ?");
        $result->execute([$roleTitle]);

        if ($result->rowCount() > 0) {
            return $result->fetch();
        }

        return false;
    }
}