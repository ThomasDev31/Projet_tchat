<?php
namespace Models; 

use services\database\Bdd;


class Data extends Bdd{
    public function createTable(){
        try{
            $sql = $this->getConnection();
            $checktable = $sql->prepare("SHOW TABLES LIKE 'category' ");
            $checktable->execute();
            if(!$checktable->fetch()){
                $sqlCreateTables = $sql->prepare('
                CREATE TABLE IF NOT EXISTS category(
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR (255) NOT NULL UNIQUE);

                CREATE TABLE IF NOT EXISTS salons(
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR (255) NOT NULL UNIQUE,
                id_category INT,
                FOREIGN KEY (id_category) REFERENCES category(id)  ON DELETE CASCADE ON UPDATE CASCADE); 

                CREATE TABLE IF NOT EXISTS users(
                id INT AUTO_INCREMENT PRIMARY KEY,
                pseudo VARCHAR (50) NOT NULL UNIQUE,
                email VARCHAR (255) NOT NULL UNIQUE,
                password TEXT NOT NULL ,
                id_salons INT,
                FOREIGN KEY (id_salons) REFERENCES salons(id) ON DELETE CASCADE ON UPDATE CASCADE);

                CREATE TABLE IF NOT EXISTS message(
                id INT AUTO_INCREMENT PRIMARY KEY,
                content TEXT NOT NULL,
                id_salons INT,
                id_users INT,
                FOREIGN KEY (id_salons) REFERENCES salons(id) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (id_users) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE); ');
                $sqlCreateTables->execute();
                var_dump('Les tables sont bien créées');
            }
        }catch(\PDOException $e){
            return $e->getMessage();
        }
    }

}