<?php

namespace Helpers;

class Path{
    public static function root($path){
        return $_SERVER['DOCUMENT_ROOT'] . "/{$path}";
    }

    public static function views($path){
        return static::root("Views/$path");
    }

    public static function controllers($path){
        return static::root("Controllers/$path");
    }

    public static function models($path){
        return static::root("Models/$path");
    }

    public static function cache($path){
        return static::root("Cache/$path");
    }
}
