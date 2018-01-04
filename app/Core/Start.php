<?php

Class Console {

    protected $CORE_COMMANDS = array();

    public function __construct()
    {
        $path = 'app/Commands/';
        $files = scandir($path);
        foreach ($files as $file) {
            if(file_exists($path.$file) && $file !== '.' && $file !== '..') {
                include_once $path.$file;
                $this->registerCommand($file);
            }
        }
    }

    private function registerCommand($file) {
        $className = str_replace('Command.php','',$file);
        try {
            $object = new $className();
            $this->CORE_COMMANDS[
                strtolower($className)
            ] = $object;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callCommand($argv = array()) {
        if(isset($argv[1])){
            $keys = explode(":",$argv[1]);
            if(isset($this->CORE_COMMANDS[$keys[0]])) {
                var_dump($keys);
                $method = $keys[1].'Action';
                $this->CORE_COMMANDS[$keys[0]]->$method();
            }
        }
    }
}