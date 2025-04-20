<?php

namespace Models;

use services\database\Bdd;

class Channel extends Bdd
{
    public function getAllChannels(){
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT * FROM category ORDER BY name ASC');
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getAllChannelsWithSalon()
    {
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT 
            category.name AS category_name,
            salons.name AS salon_name,
            salons.id AS salons_id
            FROM category
            LEFT JOIN salons
            ON category.id = salons.id_category
            ');
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getAllSalon()
    {
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT * FROM salon ORDER BY id ASC ');
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getSalonByName($name)
    {
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT * FROM salons WHERE name = :name');
            $req->execute(['name' => $name]);
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function createMessage($content, $salonId, $usersId){
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('INSERT INTO message (content, id_salons, id_users) values (:content, :id_salons, :id_users)');
            $req->execute(['content' => $content, 'id_salons' => $salonId, 'id_users' => $usersId]);
        }  catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getAllMessageBySalons($salonId){
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT 
            salons.name AS salon_name,
            users.pseudo AS user_name,
            message.content, 
            DATE_FORMAT(message.created_at, "%H:%i") AS created_at_time
            FROM message
            LEFT JOIN users ON message.id_users = users.id
            LEFT JOIN salons ON message.id_salons = salons.id
            WHERE salons.id = :salonsId
            ORDER BY salons.name, message.created_at ASC');
            $req->execute(['salonsId' => $salonId]);
            return $req->fetchAll(\PDO::FETCH_ASSOC);
        }  catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
