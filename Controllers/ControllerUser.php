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
                        $token = bin2hex(random_bytes(16));


                        $verification_link = "http://localhost/index.php?page=login&action=verify&email=" . urlencode($email) . "&token=$token";
                        $to = $email;
                        $subject = "Vérifie ton adresse e-mail";
                        $message = "
                        <html>
                        <head>
                            <title>Vérification de votre email</title>
                        </head>
                        <body>
                            <p>Bonjour,</p>
                            <p>Cliquez sur le lien ci-dessous pour activer votre compte :</p>
                            <a href='$verification_link'>$verification_link</a>
                        </body>
                        </html>
                        ";
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= "From: tissierthomas42@gmail.com" . "\r\n";
                        // if (mail($to, $subject, $message, $headers)) {
                            $msg =  $user->Register($pseudo, $email, $password, $roles, $token);
                            header('Location: index.php?page=login&action=checking');
                        //     exit();
                        // } else {
                        //     $msg =  "Erreur lors de l'envoi de l'email.";
                        // }
                    
                }
            }
        }
        require './views/src/layout.phtml';
       
    }
    public function checking(){
        $template = 'verifyemail';
        $nameFile = 'user';
        require './views/src/layout.phtml';
    }

    public function verify(){
        $email = $_GET['email'];
        $token = $_GET['token'];
        $userVerify = new User;
        $msg = "";
        $userVerify->verifyEmail($email, $token);
        if($userVerify){
            $msg = $userVerify->updateEmail($email);
        }else{
            $msg = "Lien de vérification invalide ou expiré.";
        }
    }

   public function logout(){
    $template = "logout";

    if($_SESSION){
        $_SESSION['user_id']= '';
        $_SESSION['user_name'] = '';
        $_SESSION['verify'] = '';
        setcookie(session_name(), '', time() - 3600, '/');
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
    }
    require './views/src/layout.phtml';
   }
}