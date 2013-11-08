<?php
namespace basecamp2redmine\redmine;

use basecamp2redmine\abstracts\AbstractProjects;

/**
 * Class Projects
 * @package basecamp2redmine\redmine
 * @property string $id
 * @property string $name
 * @property string $identifier
 * @property string $description
 */
class Projects extends AbstractProjects {
    protected $_data = array(
        'id' => null,
        'name' => '',
        'identifier' => '',
        'description' => '',
    );

    /**
     * @return Projects[]
     */
    public function getall()
    {
        $result = array();
        $all = $this->_connector->request('/projects.json?limit=9999999');
        if (is_array($all) && is_array($all['projects'])) {
            foreach($all['projects'] as $array) {
                $project = new Projects($this->_connector, $array['id']);
                $project->_data = $array;
                $result[] = $project;
            }
        }
        return $result;
    }

    public function fetch()
    {
        $data = $this->_connector->request('/projects/'.$this->_data['id'].'.json');
        if (isset($data['project'])) {
            $this->_data = $data['project'];
        }
        return $this;
    }

    public function create()
    {
        $this->_data['created_on'] = date('c');
        $this->_connector->post('/projects.json', array('project' => array_filter($this->_data)));
        return $this;
    }

}