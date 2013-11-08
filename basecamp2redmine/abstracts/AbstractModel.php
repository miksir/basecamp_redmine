<?php


namespace basecamp2redmine\abstracts;


use basecamp2redmine\exceptions\PropertyException;

abstract class AbstractModel {
    /**
     * @var AbstractConnector
     */
    protected $_connector;

    protected $_data = array(
        'id' => null,
    );

    function __construct(AbstractConnector $connector, $id = null)
    {
        $this->_data['id'] = $id;
        $this->_connector = $connector;

        if ($id) {
            $this->fetch();
        }
    }

    /**
     * @return $this
     */
    abstract public function fetch();

    /**
     * @return $this
     */
    abstract public function create();

    /**
     * @return $this[]
     */
    abstract public function getall();


    public function model()
    {

    }

    function __get($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        throw new PropertyException($name . ' not exists');
    }

    function __set($name, $value)
    {
        if (array_key_exists($name, $this->_data)) {
            $this->_data[$name] = $value;
            return;
        }
        throw new PropertyException($name . ' not exists');
    }
} 