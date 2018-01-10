<?php

namespace Console\Library;

use Exception;

/**
 * Pattern SingleTon
 *
 * Class Registry
 * @package Console\Library
 */
Class Registry
{
    /**
     * Array with objects
     *
     * @var array
     */
    private $obgects = array();

    /**
     * Get object
     *
     * @param $key
     *
     * @return mixed
     * @throws Exception
     */
    public function get($key)
    {
        if(isset($this->obgects[$key])) {
            return $this->obgects[$key];
        } else {
            throw new Exception('Error: Item <'.$key.'> not in Registry ');
        }
    }

    /**
     * Set object
     *
     * @param object $object
     * @param string $key
     */
    public function set($object, $key)
    {
        $this->obgects[$key] = $object;
    }
}