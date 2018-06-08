<?php
/**
 * Created by PhpStorm.
 * User: steko
 * Date: 08.06.2018
 * Time: 10:13
 */

include_once ('./Controllers/BaseController.php');
include_once ('./Controllers/LanguagesController.php');

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

class Languages extends \Controllers\LanguagesController
{

    public $pathSportTypesTxt = './Data/sportTypes.txt';
    public $pathSamesTranslationJson = './Data/namesTranslation.json';
    public $sportTypesArray = [];
    public $requestType = null;
    public $isRequestInSportTypesArray = false;

    function __construct()
    {
        $dataType = $_GET['dataType'] ?? null;
        $sportType = $_GET['sportType'] ?? null;
        $selectLanguage = $_GET['selectLanguage'] ?? null;

//        var_dump($_GET['dataType']);

        $requestType = null;

        $this->sportTypesArray = $this->dataToArray($this->loadFromFile($this->pathSportTypesTxt));

        if($dataType == null){
//            echo json_encode(['error' => 'dataType not specified'], JSON_UNESCAPED_UNICODE);
        } elseif ($dataType == 'full' && !empty($sportType)) {
            $this->requestType = 'full';
            $this->isRequestInSportTypesArray = is_int(array_search($sportType,$this->sportTypesArray));
        } elseif ($dataType == 'target' && !empty($sportType)) {
            $this->requestType = 'target';
            $this->isRequestInSportTypesArray = is_int(array_search($sportType,$this->sportTypesArray));
        } else {
//            echo json_encode(['error' => 'dataType or sportType not valid'], JSON_UNESCAPED_UNICODE);
        }

//        var_dump($dataType );

//        if($this->requestType && $this->isRequestInSportTypesArray){
//
//            $arr = json_decode($this->loadFromFile($this->pathSamesTranslationJson), JSON_UNESCAPED_UNICODE);
//            echo json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//
//        }
        if ($dataType) {
            $arr = json_decode($this->loadFromFile($this->pathSamesTranslationJson), JSON_UNESCAPED_UNICODE);
            if($sportType) {
                $arr = $arr[$sportType];
                if($selectLanguage) {
                    $arr = $arr[$selectLanguage];
                }
            }
            echo json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}

new Languages();