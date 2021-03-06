<?php

namespace Console;

use Console\Library\Cache;
use Console\Library\Config;
use Console\Library\File;
use Console\Library\Message;
use Console\Library\Registry;

/**
 * Class Console
 * @package Console
 */
Class Console
{

    /**
     * Array namespaces in commands
     *
     * @var array
     */
    private $mapping = array();

    /**
     * List arguments from console
     *
     * @var array
     */
    protected $arguments = array();

    /**
     * @var \Console\Library\Message
     */
    public $message = null;

    /**
     * @var \Console\Library\Config
     */
    protected $config = null;

    /**
     * @var \Console\Library\Cache
     */
    protected $cache = null;

    /**
     * @var \Console\Library\File
     */
    protected $file = null;


    /**
     * Console constructor.
     */
    public function __construct()
    {
        $registry = new Registry;

        $this->cache = new Cache;
        $registry->set($this->cache, 'cache');

        $this->config = new Config;
        $registry->set($this->config, 'config');

        $this->message = new Message($registry);
        $registry->set($this->message, 'message');

        $this->file = new File($registry);
        $registry->set($this->file, 'file');
    }

    /**
     * Initialize action
     *
     * @param array $argv
     */
    public function initApp(array $argv = array())
    {
        $this->arguments = $argv;

        //Load abstact command class
        require_once __DIR__ . '/Commands/AbstractCommandClass.php';
        //Load Commands Classes
        $commands = glob(__DIR__ . "/Commands/*Command.php");
        foreach ($commands as $command) {
            $this->addInMap($command, '\Console\Commands\ ');
            require_once $command;
        }
        //Load Custom Commands Classes
        $commands = glob(__DIR__ . "/CustomCommands/*Command.php");
        foreach ($commands as $command) {
            $this->addInMap($command, '\Console\CustomCommands\ ');
            require_once $command;
        }
    }

    /**
     * Called command
     */
    public function callCommand()
    {
        if (isset($this->arguments[1])) {
            $command = $this->arguments[1];
            $params = explode(':', $command);
            if (count($params) == 2) {
                $this->initializeCommand($params[0], $params[1]);
            }
        } else {
            $this->initializeCommand('info', 'welcom');
        }
    }

    /**
     * Add in map Class
     *
     * @param $path
     * @param $namespace
     */
    private function addInMap($path, $namespace)
    {
        $file = explode('/', $path);
        $class = str_replace('.php', '', end($file));
        $this->mapping[$class] = trim($namespace);
    }

    /**
     * Called selected Command
     *
     * @param $class
     * @param $method
     */
    private function initializeCommand($class, $method)
    {
        $class = ucfirst($class) . 'Command';
        $method = $method . 'Action';

        try {
            $namespace = $this->getNameSpace($class);
            $class = $namespace . $class;

            $obj = new $class;

            $this->hasMethod($obj, $method);

            $obj->$method();

        } catch (\Exception $e) {
            $this->message->addMessage(
                $e->getMessage(), 'red'
            );
        }
    }

    /**
     * Tested has Class in mapping
     *
     * @param $command
     * @return mixed
     * @throws \Exception
     */
    private function getNameSpace($command)
    {
        if (isset($this->mapping[$command])) {
            return $this->mapping[$command];
        } else {
            throw new \Exception('Error! initialize command Class');
        }
    }

    /**
     * Tested has Method
     *
     * @param $class
     * @param $method
     * @throws \Exception
     */
    private function hasMethod($class, $method)
    {
        if (!method_exists($class, $method)) {
            throw new \Exception('Error! Not method <' . $method . '>');
        }
    }
}