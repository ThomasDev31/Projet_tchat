<?php
//Rooter qui gère les pages et les actions (méthodes)
namespace services\rooter;

use Controllers\ControllerHome;
use Controllers\ControllerUser;
use Controllers\ControllerChannel;
use Controllers\ControllerAdmin;

class Routing{
    
    private ?string $page;
    private ?string $action;
    private ?string $controller;

    public function router (){
        require 'services/config/config.php';

        $this->page     = $_GET['page'] ?? DEFAULT_ROUTE;
        $this->action   = $_GET['action'] ?? 'index';

        if(file_exists("Controllers/".AVAILABLES_ROUTES[$this->page].'.php')){
            $this->controller = "Controllers\\".AVAILABLES_ROUTES[$this->page];

            $instanceController = new $this->controller;

            $this->getMethode($instanceController);
        }else{
            die('Erreur: 404 !!!');
        }
    }
    public function getMethode($instanceController){
        if(isset($this->action)){
            if(\method_exists($instanceController, $this->action)){
                $action = $this->action;
                $instanceController->$action();

            }else{
                die('Erreur : 404 !!!');
            }
        }
    }

}