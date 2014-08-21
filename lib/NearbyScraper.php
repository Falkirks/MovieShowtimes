<?php
class NearbyScraper{
    private $postal, $tld, $data;
    public function __construct($postal, $tld){
        $this->postal = $postal;
        $this->tld = $tld;
        $this->data = [];
    }
    public function sendQuery(){
        $html = file_get_html('http://www.google.' . $this->tld . '/movies?hl=en&near=' . $this->postal);
        foreach($html->find('#movie_results .theater') as $div) {
            $i = count($this->data);
            $this->data[$i] = ["name" => $div->find('h2 a',0)->innertext, "address" => str_replace('<a href="" class=fl target=_top></a>', "", $div->find('.info',0)->innertext), "movie" => []];
            foreach($div->find('.movie') as $movie) {
                preg_match_all("~([0-1]?\d|2[0-3]):([0-5]?\d)~", $movie->find('.times',0)->innertext, $matches);
                $this->data[$i]["movie"][] = ["name" => $movie->find('.name a',0)->innertext, "time" => $matches[0]];
            }
        }
    }
    public function getData(){
        return $this->data;
    }
}