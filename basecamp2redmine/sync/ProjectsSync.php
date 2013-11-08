<?php


namespace basecamp2redmine\sync;


use basecamp2redmine\abstracts\AbstractConnector;
use basecamp2redmine\basecamp\Projects as BasecampProjects;
use basecamp2redmine\redmine\ProjectMembership;
use basecamp2redmine\redmine\Projects as RedmineProjects;

class ProjectsSync {
    protected $_bs_connector;
    protected $_rm_connector;

    function __construct(AbstractConnector $basecamp, AbstractConnector $redmine)
    {
        $this->_bs_connector = $basecamp;
        $this->_rm_connector = $redmine;
    }

    /**
     * Create new projects in Redmine
     */
    public function basecamp_to_redmine($new_projects_membership=array())
    {
        $bs_projects = (new BasecampProjects($this->_bs_connector))->getall();
        $rm_projects = $this->_indexby((new RedmineProjects($this->_rm_connector))->getall(), 'identifier');

        foreach($bs_projects as $project) {
            $id = $project->id;
            if (!array_key_exists('bs'.$id, $rm_projects)) {
                $rm = new RedmineProjects($this->_rm_connector);
                $rm->identifier = 'bs'.$id;
                $rm->name = $project->name;
                $rm->description = $project->description;
                $rm->create();
                foreach($new_projects_membership as $member_id=>$role_id)
                {
                    (new ProjectMembership($this->_rm_connector, $rm->identifier))->add($member_id, $role_id);
                }
            }
        }
    }


    private function _indexby($arr, $field = 'id') {
        $newarr = array();
        foreach($arr as $item) {
            $newarr[$item->$field] = $item;
        }
        return $newarr;
    }
} 