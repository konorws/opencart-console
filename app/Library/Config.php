<?php

namespace Console\Library;

use Exception;

/**
 * Class Config
 * @package Console\Library
 */
Class Config
{
    /**
     * Path to config folder
     */
    const PATH_CONFIG = 'app/Configs/';

    /**
     * Array stack config values
     *
     * @var array
     */
    protected $config = array();

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->loadConfig('default_config');

        // Load overide config
        $this->loadConfig('config');
    }

    /**
     * Get config by Group and Key
     *
     * @param $group
     * @param string $key
     * @return mixed
     */
    public function getConfig($group, $key = '')
    {
        $group = $this->getGroup($group);
        if(!empty($key) && isset($group[$key])) {
            return $group[$key];
        } elseif(empty($key) && $group) {
            return $group;
        }

        return false;
    }

    /**
     * Get config by group
     *
     * @param $group
     * @return array|bool
     */
    public function getGroup($group)
    {
        if(isset($this->config[$group])) {
            return (array) $this->config[$group];
        }

        return false;
    }

    /**
     * Load file config and merge array
     *
     * @param $config
     * @param string $key
     * @throws Exception
     */
    public function loadConfig($config, $key = '')
    {
        $full_path = self::PATH_CONFIG . $config . '.json';
        if (!file_exists($full_path)) {
            throw new Exception('Error: file Config <' . $full_path . '> not.');
        }

        $config = json_decode(
            file_get_contents($full_path),
            true
        );

        $this->mergeConfig($config, $key);
    }

    /**
     * Merge config
     *
     * @param $config
     * @param $key
     */
    private function mergeConfig($config, $key)
    {
        if (!empty($key) && empty($this->config[$key])) {
            $this->config[$key] = $key;
        } elseif (!empty($key) && !empty($this->config[$key])) {
            $this->config[$key] = $this->arrayMergeRecursiveDistinct($this->config[$key], $config);
        } else {
            $this->config = $this->arrayMergeRecursiveDistinct($this->config, $config);
        }
    }

    /**
     * Recursive arrays merged
     *
     * @param array $config
     * @param array $array
     *
     * @return array
     */
    private function arrayMergeRecursiveDistinct(array &$config, array &$array)
    {
        $merged = $config;

        foreach ($array as $key => &$value) {
            if(is_array($value) && isset ($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->arrayMergeRecursiveDistinct($merged[$key], $value);
            } else {
                $merged [$key] = $value;
            }
        }

        return $merged;
    }
}