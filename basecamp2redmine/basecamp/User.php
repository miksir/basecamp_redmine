<?php
namespace basecamp2redmine\basecamp;

use basecamp2redmine\abstracts\AbstractUser;

/**
 * Class User
 * @package basecamp2redmine\basecamp
 * @property string $id
 * @property string $name
 * @property string $email_address
 *
 */
class User extends AbstractUser {

    /**
     * @return $this
     */
    public function fetch()
    {
        $this->_data = $this->_connector->request('/people/'.$this->_data['id'].'.json');
        return $this;
    }

    /**
     * @return $this
     */
    public function create()
    {
        $this->_data['created_on'] = date('c');
        $this->_connector->post('/users.json', array('user' => array_filter($this->_data)));
        return $this;
    }

    /**
     * @return $this[]
     */
    public function getall()
    {
        $result = array();
        $ppls = $this->_connector->request('/people.json');
        if (is_array($ppls)) {
            foreach($ppls as $ppl) {
                $obj = new User($this->_connector, $ppl['id']);
                $obj->_data = $ppl;
                $result[] = $obj;
            }
        }
        return $result;
    }
}