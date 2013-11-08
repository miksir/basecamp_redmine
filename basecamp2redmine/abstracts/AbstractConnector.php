<?php


namespace basecamp2redmine\abstracts;


use basecamp2redmine\exceptions\ApiException;

abstract class AbstractConnector {
    private $_url;
    private $_username;
    private $_password;
    protected $appname = 'basecamp2redmine (miksir@maker.ru)';

    function __construct($url, $username, $password)
    {
        $this->_url = $url;
        $this->_username = $username;
        $this->_password = $password;
    }

    public function request($uri)
    {
        return $this->_do($uri);
    }

    public function post($uri, $data)
    {
        return $this->_do($uri, 'POST', $data);
    }

    private function _do($uri, $type = 'GET', $data = null)
    {
        $ch = curl_init($this->_url.$uri);

        $this->setoptions($ch);

        if ($type == 'POST') {
            $this->preparepost($ch, $data);
        }

        $this->setauthinfo($ch);
        $result = $this->curlexec($ch);
        $this->checkerror($ch);

        curl_close($ch);

        $answer = json_decode($result, true);
        return $answer;
    }

    protected function preparepost(&$ch, $data)
    {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        }
    }

    protected function curlexec(&$ch)
    {
        return curl_exec($ch);
    }

    protected function checkerror(&$ch)
    {
        if (curl_errno($ch)) {
            throw new ApiException(curl_error($ch), curl_errno($ch));
        }
    }

    protected function setoptions(&$ch)
    {
        $op = array();
        $op[CURLOPT_HEADER] = false;
        $op[CURLOPT_RETURNTRANSFER] = true;
        $op[CURLOPT_TIMEOUT] = 10;
        $op[CURLOPT_FAILONERROR] = true;
        $op[CURLOPT_COOKIEFILE] = '';
        $op[CURLOPT_USERAGENT] = $this->appname;
        $op[CURLOPT_HTTPHEADER] = array('Content-Type: application/json; charset=utf-8');
        $op[CURLOPT_HTTP200ALIASES] = array(200, 201);
        $op[CURLOPT_FOLLOWLOCATION] = true;
        //$op[CURLINFO_HEADER_OUT] = true;
        curl_setopt_array($ch, $op);
    }

    protected function setauthinfo(&$ch)
    {
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_username.':'.$this->_password);
    }
} 