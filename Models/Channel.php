<?php

namespace Models;

use services\database\Bdd;

class Channel extends Bdd
{
    public function getAllChannels()
    {
        try {
            $sql = $this->getConnection();
            $req = $sql->prepare('SELECT 
            category.name AS category_name,
            salons.name AS salon_name
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
}
