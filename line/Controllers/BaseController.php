<?php
/**
 * Created by PhpStorm.
 * User: steko
 * Date: 08.06.2018
 * Time: 9:15
 */

namespace Controllers;


class BaseController
{
    public function loadFromFile(string $path)
    {
        return str_replace("\r\n","",file_get_contents($path));
    }

}

