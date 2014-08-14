<?php
namespace basecamp2redmine\redmine;

use basecamp2redmine\abstracts\AbstractUser;

/**
 * Class User
 * @package basecamp2redmine\redmine
 * @property string $login
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string $mail
 */
class User extends AbstractUser {
    protected $_data = array(
        'id' => null,
        'login' => '',
        'firstname' => '',
        'lastname' => '',
        'mail' => '',
    );

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
        $this->_connector->post('/users.json', array('user' => array_filter($this->_data)));
        return $this;
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
                $obj->fetch();
                $result[] = $obj;
            }
        }
        return $result;
    }
}