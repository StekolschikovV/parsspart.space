<?php
/**
 * Created by PhpStorm.
 * User: steko
 * Date: 08.06.2018
 * Time: 9:19
 */

namespace Controllers;



class LanguagesController extends BaseController
{
    public function dataToArray(string $data)
    {
        return explode (',',$data);
    }
}

new LanguagesController();














