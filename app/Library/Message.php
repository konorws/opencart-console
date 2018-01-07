<?php

namespace Console\Library;

/**
 * Class Message
 * @package Console\Core
 */
Class Message
{
    /**
     * @var array
     */
    private $colors = array();

    /**
     * Message constructor.
     */
    public function __construct()
    {
        //Set array colors
        $this->colors['black'] = '0;30';
        $this->colors['dark_gray'] = '1;30';
        $this->colors['blue'] = '0;34';
        $this->colors['light_blue'] = '1;34';
        $this->colors['green'] = '0;32';
        $this->colors['light_green'] = '1;32';
        $this->colors['cyan'] = '0;36';
        $this->colors['light_cyan'] = '1;36';
        $this->colors['red'] = '0;31';
        $this->colors['light_red'] = '1;31';
        $this->colors['purple'] = '0;35';
        $this->colors['light_purple'] = '1;35';
        $this->colors['brown'] = '0;33';
        $this->colors['yellow'] = '1;33';
        $this->colors['light_gray'] = '0;37';
        $this->colors['white'] = '1;37';
    }

    /**
     * Adding message in terminal
     *
     * @param $message
     * @param string $color
     * @param bool $newLine
     */
    public function addMessage($message, $color = '', $newLine = true)
    {
        $string = '';

        if (!empty($color)) {
            $string .= $this->setColor($message, $color);
        } else {
            $string .= $message;
        }

        if($newLine) {
            $string .= PHP_EOL;
        }
        echo $string;
    }

    /**
     * Get array colors
     *
     * @return array
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Get data in enter console
     *
     * @return bool|string
     */
    public function getEnterData()
    {
        return trim(fgets(STDIN));
    }

    /**
     * Adding color in string
     *
     * @param $message
     * @param $color
     *
     * @return string
     */
    private function setColor($message, $color)
    {
        $string = "";

        if (isset($this->colors[$color])) {
            $string .= "\033[" . $this->colors[$color] . "m " . $message . " \033[0m";
        }

        return $string;
    }
}