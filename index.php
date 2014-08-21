<?php
require 'lib/simple_html_dom.php';
require_once 'lib/NearbyScraper.php';
require_once 'lib/MovieScraper.php';
require_once 'lib/ConfigParser.php';
require_once 'lib/OutputParser.php';
require_once 'lib/Colors.php';
if(!file_exists("data/local.dat")){
    print "In order to configure MovieShowtimes you must enter some info.\n";
    print "Please enter your country code (TLD):";
    $c = fgets(STDIN);
    while(strlen($c) !== 2 && strlen($c) !== 3){
        print "Please enter a valid country code (eg: COM):\n";
        $c = fgets(STDIN);
    }
    print "Please enter your ZIP/Postal code:\n";
    $p = fgets(STDIN);
    file_put_contents("data/local.dat", "$c//$p");
    print "Your locale is now set, you can now use MovieShowtimes.\n";
}
else{
    if(isset($argv[1])){
        $local = new ConfigParser("data/local.dat");
        $local->nameValue(0, "tld");
        $local->nameValue(1, "zip");
        switch($argv[1]){
            case 'nearby':
            case 'near':
                $n = new NearbyScraper($local->getValue("zip"), strtolower($local->getValue("tld")));
                $n->sendQuery();
                if(isset($argv[2]) && $argv[2] == "full") new OutputParser($n->getData());
                else{
                    $data = $n->getData();
                    print "Movies found for the following theatres:\n";
                    foreach($data as $i){
                        print "-" .  $i["name"] . "\n";
                    }
                    print PHP_EOL;
                    $search = "";
                    while($search !== "exit\n"){
                        print "Which theatre would you like to display movies for? (type exit to leave): ";
                        $search = fgets(STDIN);
                        if($search !== "exit\n"){
                            new OutputParser(getSimilar($search, $data));
                        }

                    }
                }
                break;
            case 'find':
                if(isset($argv[2])){
                    $movies = explode(",", implode("+", array_slice($argv, 2)));
                    for($i = 0; $i < count($movies); $i++){
                        $movies[$i] = new MovieScraper($local->getValue("zip"), strtolower($local->getValue("tld")), $movies[$i]);
                        $movies[$i]->sendQuery();
                        new OutputParser($movies[$i]->getData());
                        $movies[$i] = $movies[$i]->getData();

                    }
                    //TODO check movies are playing together
                }
                else{
                    print "You must a query.";
                }
                break;
        }
    }
}
function getSimilar($search, array $data){
    $out = -1;
    $name = "";
    foreach($data as $i){
        if(($s = similar_text($search, $i["name"])) > $out){
            $out = $s;
            $name = $i;
        }
    }
    return $name;
}
