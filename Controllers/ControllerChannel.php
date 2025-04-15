<?php

namespace Controllers;

class ControllerChannel{

    public function index (){
        $template = 'channel';
        require './views/src/layout.phtml';
    }
}