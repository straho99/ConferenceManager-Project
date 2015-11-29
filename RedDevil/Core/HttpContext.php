<?php

namespace RedDevil\Core;
use RedDevil\Core\Identity\Identity;

/**
 * @Credits: the basics of this class are developed by Ivan Vankov - a.k.a. 'gatakka'.
 */
class HttpContext {
    private static $_instance = null;
    private $_get = array();
    private $_post = array();
    private $_cookies = array();
    private $_session = array();
    private $method = 'get';
    private $identity;

    private function __construct()
    {
        $this->_cookies = $_COOKIE;
        $this->identity = Identity::getInstance();
    }

    public function setIdentity(integer $identity)
    {
        $this->identity = $identity;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function setPost(array $ar) {
        if (is_array($ar)) {
            $this->_post = $ar;
        }
    }

    public function setGet(array $ar) {
        if (is_array($ar)) {
            $this->_get = $ar;
        }
    }

    public function setCookies(array $ar) {
        if (is_array($ar)) {
            $this->_cookies = $ar;
        }
    }

    public function setSession(array $ar) {
        if (is_array($ar)) {
            $this->_session = $ar;
        }
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    public function hasGet(integer $id) : bool {
        return array_key_exists($id, $this->_get);
    }

    public function hasPost(string $name) : bool {
        return array_key_exists($name, $this->_post);
    }

    public function hasSession(string $name) : bool {
        return array_key_exists($name, $this->_session);
    }

    public function hasCookies(string $name) : bool {
        return array_key_exists($name, $this->_cookies);
    }

    public function get(integer $id, bool $normalize = null, $default = null) {
        if ($this->hasGet($id)) {
            if ($normalize != null) {
                return Common::normalize($this->_get[$id], $normalize);
            }
            return $this->_get[$id];
        }
        return $default;
    }

    public function post(string $name, bool $normalize = null, $default = null) {
        if ($this->hasPost($name)) {
            if ($normalize != null) {
                return Common::normalize($this->_post[$name], $normalize);
            }
            return $this->_post[$name];
        }
        return $default;
    }

    public function cookies(string $name, bool $normalize = null, $default = null) {
        if ($this->hasCookies($name)) {
            if ($normalize != null) {
                return Common::normalize($this->_cookies[$name], $normalize);
            }
            return $this->_cookies[$name];
        }
        return $default;
    }

    public function session(string $name, bool $normalize = null, $default = null) {
        if ($this->hasSession($name)) {
            if ($normalize != null) {
                return Common::normalize($this->_session[$name], $normalize);
            }
            return $this->_session[$name];
        }
        return $default;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     *
     * @return bool
     */
    public function isGet() : bool
    {
        return $this->method == 'get';
    }

    /**
     *
     * @return bool
     */
    public function isPost() : bool
    {
        return $this->method == 'post';
    }

    /**
     *
     * @return \RedDevil\Core\HttpContext
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new HttpContext();
        }
        return self::$_instance;
    }
}