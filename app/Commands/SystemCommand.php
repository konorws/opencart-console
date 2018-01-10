<?php

namespace Console\Commands;

/**
 * Class SystemCommand
 * @package Console\Commands
 */
Class SystemCommand extends AbstractCommand
{
    /**
     * Command created new Custom Command
     */
    public function generateAction()
    {
        $commandName = $this->getCommandName();
        $commandName = $commandName.'Command';
        $text = "<?php

namespace Console\CustomCommands;

use Console\Commands\AbstractCommand;

/**
 * Class ".$commandName.";
 * @package CustomCommand
 */
Class ".$commandName." extends AbstractCommand
{    
    public function indexAction()
    {
        //Code command
    }
}";

        $file = __DIR__.'../../CustomCommands/'.$commandName.'.php';
        $created = file_put_contents($file,$text);

        $this->message->addMessage('Start created '.$file);

        if($created) {
            $this->message->addMessage(
                'Success created Command: '.$commandName,
                'light_green'
            );
        } else {
            $this->message->addMessage(
              'Error created Command: '.$commandName,
              'light_red'
            );
        }
    }

    /**
     * Function get name new command
     *
     * @return string
     */
    private function getCommandName()
    {
        if (isset($this->arguments[2])) {
            $name = trim($this->arguments[2]);
        } else {
            $this->message->addMessage('Enter the command name:', 'light_green', false);
            $name = $this->message->getEnterData();
        }

        if (!empty($name)) {
            return ucfirst($name);
        } else {
            $this->message->addMessage('You enter empty name.', 'light_red');
            exit;
        }
    }
}