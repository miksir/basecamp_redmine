<?php

namespace basecamp2redmine\sync;

use basecamp2redmine\abstracts\AbstractConnector;
use basecamp2redmine\basecamp\User as BasecampUser;
use basecamp2redmine\helpers\Arrays;
use basecamp2redmine\redmine\User as RedmineUser;

class UsersSync {

    protected $_bs_connector;
    protected $_rm_connector;

    function __construct(AbstractConnector $basecamp, AbstractConnector $redmine)
    {
        $this->_bs_connector = $basecamp;
        $this->_rm_connector = $redmine;
    }

    public function basecamp_to_redmine()
    {
        $bs_users = (new BasecampUser($this->_bs_connector))->getall();
        $rm_users = Arrays::indexby((new RedmineUser($this->_rm_connector))->getall(), 'mail');

        foreach ($bs_users as $user) {
            if (!isset($rm_users[$user->email_address])) {
                $rm_user = new RedmineUser($this->_rm_connector);
                $rm_user->mail = $user->email_address;
                if (strpos($user->name, ' ') === false) {
                    $user->name = $user->name . ' ' . $user->name;
                }
                list($rm_user->firstname, $rm_user->lastname) = explode(' ', $user->name, 2);
                $rm_user->login = $user->email_address;
                $rm_user->create();
            }
        }
    }

} 