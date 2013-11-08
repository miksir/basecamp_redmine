<?php
namespace basecamp2redmine\redmine;

use basecamp2redmine\abstracts\AbstractUser;

class User extends AbstractUser {

    /**
     * @return $this
     */
    public function fetch()
    {
        $user = $this->_connector->request('/users/'.$this->_data['id'].'.json');
        if (is_array($user['user'])) {
            $this->_data = $user['user'];
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function create()
    {
        throw new ApiException('Not supported yey');
    }

    /**
     * @return $this[]
     */
    public function getall()
    {
        $result = array();
        $ppls = $this->_connector->request('/users.json');
        if (is_array($ppls) && is_array($ppls['users'])) {
            foreach($ppls['users'] as $ppl) {
                $obj = new User($this->_connector, $ppl['id']);
                $obj->_data = $ppl;
                $result[] = $obj;
            }
        }
        return $result;
    }
}