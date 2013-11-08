<?php
namespace basecamp2redmine\redmine;

use basecamp2redmine\abstracts\AbstractConnector;

class ProjectMembership {
    /**
     * @var AbstractConnector
     */
    protected $_connector;
    protected $_id;


    /**
     * @param AbstractConnector $connector
     * @param string $id ID or Identificator of project
     */
    function __construct(AbstractConnector $connector, $id)
    {
        $this->_id = $id;
        $this->_connector = $connector;
    }

    public function add($member_id, $role_id)
    {
        $data = array(
            'membership' => array(
                'user_id' => $member_id,
                'role_ids' => is_array($role_id) ? $role_id : array($role_id),
            )
        );
        $this->_connector->post('/projects/'.$this->_id.'/memberships.json', $data);
    }
} 