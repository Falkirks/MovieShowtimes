<?php

class Colors {
    private $foreground_colors = [];
    private $background_colors = [];

    public function __construct() {
        $this->foreground_colors[] = '0;30';
        $this->foreground_colors[] = '1;30';
        $this->foreground_colors[] = '0;34';
        $this->foreground_colors[] = '1;34';
        $this->foreground_colors[] = '0;32';
        $this->foreground_colors[] = '1;32';
        $this->foreground_colors[] = '0;36';
        $this->foreground_colors[] = '1;36';
        $this->foreground_colors[] = '0;31';
        $this->foreground_colors[] = '1;31';
        $this->foreground_colors[] = '0;35';
        $this->foreground_colors[] = '1;35';
        $this->foreground_colors[] = '0;37';
        $this->foreground_colors[] = '1;37';

    }

    // Returns colored string
    public function getColoredString($string, $foreground_color = null) {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color-1])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color-1] . "m";
        }
        $colored_string .=  $string . "\033[0m";

        return $colored_string;
    }
}