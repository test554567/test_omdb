<?php

class TestControllerAbstract
{
    protected $_request;

    public function __construct()
    {
        $this->_request = $_REQUEST;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function getRequestParam($paramName, $default = null)
    {
        if (!isset($this->_request[$paramName])) {
            return $default;
        }
        return $this->_request[$paramName];
    }

    public function redirect($url)
    {
        $url = urldecode($url);
        header('Location:' . $url);
    }
}