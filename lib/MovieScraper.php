<?php
class MovieScraper{
    private $postal, $tld, $data;
    public function __construct($postal, $tld, $q){
        $this->postal = $postal;
        $this->tld = $tld;
        $this->q = $q;
        $this->data = [];
    }
    public function sendQuery(){
        $html = file_get_html('http://www.google.' . $this->tld . '/movies?hl=en&near=' . $this->postal . "&q=" . $this->q);
        foreach($html->find('.theater') as $div) {
            $i = count($this->data);
            preg_match_all("~([0-1]?\d|2[0-3]):([0-5]?\d)~", $div->find('.times',0)->innertext, $matches);
            $this->data[$i] = ["name" => $div->find('.name a',0)->innertext, "address" => str_replace('<a href="" class=fl target=_top></a>', "", $div->find('.address',0)->innertext), "times" => $matches[0]];
        }
    }
    public function getData(){
        return [[$this->data]]; //For output parsing
    }
}