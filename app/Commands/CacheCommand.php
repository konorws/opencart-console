<?php

namespace Console\Commands;

use Exception;

/**
 * Class CacheCommand
 * @package Console\Commands
 */
class CacheCommand extends AbstractCommand
{
    /**
     * Clean Image cache
     */
    public function cleanImageAction()
    {
        if(!$this->config->getConfig('CMS','install')){
            $this->message->addError('CMS not installed!!!');
            return false;
        }

        // Loaded config CMS
        $pathToConfig = getcwd().$this->config->getConfig('CMS','install_dir').'config.php';
        if(!file_exists($pathToConfig)) {
            $this->message->addError('Not file config <'.$pathToConfig.'>');
            return false;
        }
        include_once $pathToConfig;

        try {
            $this->file->cleanDir(DIR_IMAGE.'cache');
            $this->message->addMessage('Success! Cleaned Image cache','light_green');
        } catch (Exception $e) {
            $this->message->addError($e->getMessage());
            return false;
        }
    }
}