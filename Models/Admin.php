<?php

namespace Models;

use services\database\Bdd;

class Admin extends Bdd{

    public function createChannel($name){
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('INSERT INTO category (name) VALUES (:name)');
            $req->execute(['name' => $name]);
            return "L'ajout du Channel à bien était éffectué";
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getAllChannels(){
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

    public function createSalon($categoryId, $name){
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('INSERT INTO salons (name, id_category) values (:name, :id_category)');
            $req->execute(['name' => $name, 'id_category' => $categoryId]);
            return "L'ajout du salon à bien était éffectué";
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

}