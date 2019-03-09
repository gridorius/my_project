<?php

namespace Helpers;

class Path{
    public static function root($path){
        return $_SERVER['DOCUMENT_ROOT'] . "/{$path}";
    }
}
