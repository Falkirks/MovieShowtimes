<?php
class OutputParser{
    private $data, $c;
    public function __construct(array $data){
        $this->data = $data;
        $this->c = new Colors;
        $this->dumpOutput($this->data, 0);

    }
    public function dumpOutput($dump, $indent){
        $indent++;
        foreach($dump as $i){
            if(is_array($i)){
                $this->dumpOutput($i, $indent);
            }
            else{
                print $this->c->getColoredString(str_repeat(" ", $indent) . ($indent == 5 ? "-" : null) . $i . PHP_EOL, $indent);
            }
        }
    }
}