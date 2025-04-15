<?php
namespace Controllers;

class ControllerHome{
    public function index (){
        $template = 'home';
        require './views/src/layout.phtml';
    }
}