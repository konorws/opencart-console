<?php

namespace Console\Commands;

/**
 * Class InfoCommand
 * @package Console\Commands
 */
Class InfoCommand extends AbstractCommand
{

    public function welcomAction()
    {
        $this->message->addMessage('Hello World', 'green');
    }

    public function messageColorAction()
    {
        $colors = $this->message->getColors();
        foreach ($colors as $nameColor => $keys) {
            $this->message->addMessage(
                'This color have key: <' . $nameColor . '>...',
                $nameColor
            );
        }
    }
}