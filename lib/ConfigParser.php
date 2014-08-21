<?php
class ConfigParser{
    public $data;
    public function __construct($file){
        $this->data = explode("//", str_replace(PHP_EOL, "", file_get_contents($file)));
    }
    public function nameValue($i, $name){
        $this->data[$name] = $this->data[$i];
        unset($this->data[$i]);
    }
    public function getValue($name){
        return $this->data[$name];
    }
}