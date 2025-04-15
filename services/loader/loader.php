<?php

//autoloade appel des fichiers la création d'une classe

class AutoLoader{
    public static function inclusionAuto($className){
        $path = dirname(__DIR__, 2);
        require_once $path .'/' . str_replace('\\', '/', $className) . '.php';
    }
}
spl_autoload_register(array('AutoLoader', 'inclusionAuto'));