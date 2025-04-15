<?php 


namespace Models;

use services\database\Bdd;

class User extends Bdd{

    private function addUser ($pseudo, $email, $password){
        try{
        $sql = $this->getConnection();
        $req = $sql->prepare("INSERT INTO users (pseudo, email, password) values (:pseudo, :email, :password)  ");
        $req->execute([
            'pseudo' => $pseudo, 
            'email' => $email, 
            'password' => $password]);
        }catch(\PDOException $e){
            return $e->getMessage();
        }
    }

    private function checkUser($user){
        try{
            $sql = $this->getConnection();
            $req = $sql->prepare("SELECT * FROM users WHERE email = :email OR pseudo = :pseudo ");
            $req->execute(['email' => $user, 'pseudo' => $user]);
            $data = $req->fetch(\PDO::FETCH_ASSOC);

            return $data ? $data : false; 

            }catch(\PDOException $e){
                return $e->getMessage();
            }
    }

    public function Register($pseudo, $email, $password){

        $existUser = $this->checkUser($email, $pseudo);

        if($existUser){
           return "Cet personne existe déjà";
        }else{
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->addUser($pseudo, $email, $hashedPassword);

            return "Vous êtes bien inscrit";
        }

    }

    public function Loggin  ($username, $password){
        $existUser = $this->checkUser($username);
        
        if($existUser){
            if(password_verify($password, $existUser['password'])) {
               
                $_SESSION['user_id']= $existUser['id'];
                $_SESSION['user_name'] = $existUser['pseudo'];

                header('Location: ?page=home');
                exit();
            }else{
                return 'Mot de passe incorrect';
            }
        }else{
            return 'Veuillez saisir un nom valide';
        }
    }
}