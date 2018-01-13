<?php

namespace Console\Library;

/**
 * Class File
 * @package Console\Library
 */
Class File {

    /**
     * @var \Console\Library\Message
     */
    protected $message;

    /**
     * File constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->message = $registry->get('message');
    }

    /**
     * Cleaned
     *
     * @param $path
     */
    public function cleanDir($path)
    {
        $files = glob($path.'/*');
        foreach ($files as $file) {
            if(is_dir($file)){
                $this->message->addMessage('Deleted folder: '.$file, 'light_cyan');
                $this->cleanDir($file);
                rmdir($file);
            } else {
                unlink($file);
            }
        }
    }
}