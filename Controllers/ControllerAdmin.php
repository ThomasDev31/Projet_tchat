<?php

namespace Controllers;

class ControllerAdmin{
    public function index (){
        $template = 'admin';
        require './views/src/layout.phtml';
    }
}