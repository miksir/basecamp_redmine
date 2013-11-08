<?php

namespace basecamp2redmine\abstracts;


abstract class AbstractProjects extends AbstractModel {
    protected $_data = array(
        'id' => null,
        'name' => '',
        'description' => '',
    );

    public static function createProject()
    {

    }
}
