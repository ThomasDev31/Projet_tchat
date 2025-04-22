<?php 


namespace Models;

use services\database\Bdd;

class User extends Bdd{

    private function addUser (string $pseudo, string $email, string $password, string $roles, string $token): string{
        try{
        $sql = $this->getConnection();
        $req = $sql->prepare("INSERT INTO users (pseudo, email, password, roles, verification_token) values (:pseudo, :email, :password, :roles, :verification_token)");
        $req->execute([
            'pseudo' => $pseudo, 
            'email' => $email, 
            'password' => $password,
            'roles' => $roles,
            'verification_token' => $token]);
            return "true";
        }catch(\PDOException $e){
            return $e->getMessage();
        }
    }

    private function checkUser($user): mixed{
        try{
            $sql = $this->getConnection();
            $req = $sql->prepare("SELECT * FROM users WHERE email = :email OR pseudo = :pseudo ");
            $req->execute(['email' => $user, 'pseudo' => $user]);
            $data = $req->fetch(\PDO::FETCH_ASSOC);

            return $data ?: false; 

            }catch(\PDOException $e){
                return $e->getMessage();
            }
    }

    public function Register(string $pseudo,string $email,string $password,string $roles,string $token): string{

        $existUser = $this->checkUser( $email,  $pseudo);

        if($existUser){
           return "Cet personne existe déjà";
        }else{
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->addUser($pseudo, $email, $hashedPassword, $roles, $token);

            return "Vous êtes bien inscrit";
        }

    }

    public function Loggin  (string $username, string $password): string{
        $existUser = $this->checkUser($username);
        
        if($existUser){
            if(password_verify($password, $existUser['password'])) {
               
                $_SESSION['user_id']= $existUser['id'];
                $_SESSION['user_name'] = $existUser['pseudo'];
                $_SESSION['roles'] = $existUser['roles'];
                $_SESSION['verify'] = $existUser['is_verified'];
                
                header('Location: ?page=home');
                exit();
            }else{
                return 'Mot de passe incorrect';
            }
        }else{
            return 'Veuillez saisir un nom valide';
        }
    }

    public function verifyEmail(string $email, string $token): mixed{
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare("SELECT * FROM users WHERE email = :email AND verification_token = :verification_token");
            $req->execute(['email' => $email, 'verification_token' => $token]);
            $data = $req->fetch();
            return $data;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
       
    }

    public function updateEmail(string $email): mixed{
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare("UPDATE users SET verification_token = NULL, is_verified = 1, WHERE email = :email");
            $req->execute(['email' => $email]);
            return false; 
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
        
    }
}