<?php
namespace Console\Commands;

use Console\Console;
use Console\Library\Cache;
use Console\Library\Message;

/**
 * Class AbstarctCommand
 * @package Console\Commands
 */
abstract class AbstractCommand extends Console
{
    /**
     * List called methods
     *
     * @var array
     */
    protected $list_function = array ();

    /**
     * Initialize action
     *
     * @param array $argv
     */
    public function initApp(array $argv = array())
    {
        $this->argumments = $argv;

        $this->message = new Message;
        $this->cache = new Cache;
    }

    /**
     * Get access called methods
     *
     * @return array
     */

    public function getListMethods()
    {
        return $this->list_function;
    }
}
