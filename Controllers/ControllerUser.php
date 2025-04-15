<?php
namespace Controllers;
use Models\User;

class ControllerUser{

    public function index(){
        $user = new User;
        $nameFile = 'user';
        $template = 'log';
        $msg =''; 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(empty($_POST['value']) ||  empty($_POST['password'])){
                $msg = "Veuillez saisir tous les champs";
            }else{
                $username = $_POST['value'];
                $password = $_POST['password'];

                $msg =  $user->Loggin($username, $password);
            }

        }

        require './views/src/layout.phtml';
    }

    public function register(){
        $user = new User;
        $nameFile = 'user';
        $template = 'register';
        $msg =''; 

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST)){
                if(empty($_POST['pseudo']) || empty($_POST['email']) ||  empty($_POST['password'])){
                    $msg = "Veuillez saisir tous les champs";
                }else{
                        $pseudo = $_POST['pseudo'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $roles = "ROLES_USER";
                        $msg =  $user->Register($pseudo, $email, $password, $roles);
                    
                }
            }
        }
        require './views/src/layout.phtml';
       
    }
   public function logout(){
    $template = "logout";

    if($_SESSION){
        $_SESSION['user_id']= '';
        $_SESSION['user_name'] = '';
        setcookie(session_name(), '', time() - 3600, '/');
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
    }
    require './views/src/layout.phtml';
   }
}