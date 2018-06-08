<?php
/**
 * Created by PhpStorm.
 * User: steko
 * Date: 06.06.2018
 * Time: 8:44
 */
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
set_time_limit(0);

ini_set('error_reporting', E_ALL);
ini_set('display_errors',true);
ini_set('post_max_size','1024M');
ini_set('upload_max_filesize','1024M');

require "vendor/autoload.php";
use PHPHtmlParser\Dom;

class Parser {

    public $sportType = null;
    public $baseUrl = 'https://1xbetua.com/line/';
    public $allSports = [
        'Football',
        'Ice-Hockey',
        'Basketball',
        'Tennis',
        'Volleyball',
        'Baseball',
        'Table-Tennis',
        'Tennis',
        'Australian-Rules',
        'Motorsport',
        'American-Football',
        'Athletics',
        'Baseball',
        'Biathlon',
        'Boxing',
        'Bicycle-Racing',
        'Water-Polo',
        'Handball',
        'Golf',
        'Gaelic-Football',
        'Martial-Arts',
        'Cricket',
        'Crossfit',
        'Lottery',
        'Skiing',
        'Motorbikes',
        'Netball',
        'Pespallo',
        'Swimming',
        'Poker',
        'Ski-Jumping',
        'Rugby',
        'Horse-Racing',
        'Horse-Racing-AntePost',
        'Squash',
        'Greyhound-Racing',
        'Greyhound-AntePost',
        'Softball',
        'Special-bets',
        'Speedway',
        'Surfing',
        'TV-Games',
        'Trotting',
        'Trotting-AntePost',
        'Formula-1',
        'Futsal',
        'Hurling',
        'Field-Hockey'
    ];

    function __construct()
    {
        $this->sportType = $_GET['sportType'] ?? null;

        if(!$this->sportType){
            $this->loadAndSaveContent();
        } else {
            if(is_int(array_search($this->sportType, $this->allSports)) == false) {
                echo json_encode(['error' => 'There is no such category'], JSON_UNESCAPED_UNICODE);
            } else {
                echo $this->getContent('./' . $this->sportType . '.txt');
            }
        }
    }

    public function loadAndSaveContent()
    {
//        echo "loadAndSaveContent<br>";
//        if (!file_exists('./data/')) {
//            mkdir('./data/', 7777, true);
//        }
        for($i = 0; $i < count($this->allSports); $i++){
            $data = $this->loadData($this->allSports[$i]);
            $this->putContent('./' . $this->allSports[$i] . '.txt', $data);
        }
    }

    public function loadData($sportTitle)
    {
        $html = file_get_contents($this->baseUrl . $sportTitle . '/');
        $dom = new Dom;
        $dom->load($html);
        $contents = $dom->find('#games_content .c-events__subitem');
        $dataArr = array();
        foreach ($contents as $content)
        {
            $team = $content->find('.c-events__teams .n')[0];
            $team = rtrim($team->getAttribute('title'));
            $time = $content->find('.c-events__time span')[0];
            $time = $time->text;
            array_push($dataArr, [
                'time' => $time,
                'title' => $team
            ]);
        }
        return json_encode($dataArr, JSON_UNESCAPED_UNICODE);
    }

    public function putContent($file, $content)
    {
        file_put_contents($file, $content);
    }
    public function getContent($file)
    {
        return file_get_contents($file);
    }

}

new Parser();
