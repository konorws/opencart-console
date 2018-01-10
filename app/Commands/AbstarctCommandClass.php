<?php
namespace Console\Commands;

use Console\Console;

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
     * Get access called methods
     *
     * @return array
     */

    public function getListMethods()
    {
        return $this->list_function;
    }
}
