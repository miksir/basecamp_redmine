<?php
namespace basecamp2redmine\basecamp;

use basecamp2redmine\abstracts\AbstractProjects;

/**
 * Class Projects
 * @package basecamp2redmine\basecamp
 * @property string $id
 * @property string $name
 * @property string $description
 */
class Projects extends AbstractProjects {

    /**
     * @return Projects[]
     */
    public function getall()
    {
        $result = array();
        $all = $this->_connector->request('/projects.json');
        if (is_array($all)) {
            foreach($all as $array) {
                $project = new Projects($this->_connector, $array['id']);
                $project->_data = $array;
                $result[] = $project;
            }
        }
        return $result;
    }



    public function fetch()
    {
        $this->_data = $this->_connector->request('/projects/'.$this->_data['id'].'.json');
        return $this;
    }

    /**
     * @return $this
     */
    public function create()
    {
        throw new ApiException('Not supported yey');
    }

}