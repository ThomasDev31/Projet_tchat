<?php

namespace Models;

use services\database\Bdd;

class Admin extends Bdd{

    public function createChannel($name): string{
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('INSERT INTO category (name) VALUES (:name)');
            $req->execute(['name' => $name]);
            return "L'ajout du Channel à bien était éffectué";
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getAllChannels(): array|string{
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT * FROM category ORDER BY id ASC ');
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            return $data ;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function createSalon($categoryId, $name): string{
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('INSERT INTO salons (name, id_category) values (:name, :id_category)');
            $req->execute(['name' => $name, 'id_category' => $categoryId]);
            return "L'ajout du salon à bien était éffectué";
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getSalon($name){
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT * FROM salons where name = :name');
            $req->execute(['name' => $name]);
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
        
    }

    public function modifySalon($name){
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('UPDATE salons set  name = :name');
            $req->execute(['name' => $name]);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getUsers():array|string {
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT pseudo, roles, created_at, is_verified FROM users ORDER BY roles ASC' );
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            return $data; 
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getUser($pseudo): array|string{
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT pseudo, roles, created_at, is_verified FROM users WHERE pseudo = :pseudo');
            $req->execute(['pseudo' => $pseudo]);
            $data = $req->fetch();
            return $data;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
    
    public function updateRoleUser($pseudo, $role){
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('UPDATE users SET roles = :roles  WHERE pseudo = :pseudo');
            $req->execute(['pseudo' => $pseudo, 'roles' => $role]);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}