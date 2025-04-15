<?php
//Connection à la bdd
namespace services\database; 


class Bdd{
    private string $host = 'localhost';
    private string $dbname = 'thomas_tchat';
    private string $root = 'root';
    private string $mdp = '';
    private string $utf = 'utf8';
    private ?\PDO $dbb = null;
    
    public function __construct (){
        $this->dbb = $this->initConnection();
    }

    public function getConnection (): \PDO {
        if($this->dbb === null){
            $this->dbb = $this->initConnection();
        }
        return $this->dbb;
    }

    private function initConnection (): \PDO{
        try{
        $dbb = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=' .$this->utf, 
        $this->root, 
        $this->mdp, [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
        return $dbb;
        }catch(\PDOException $e){
            die('Erreur connexion bdd: ' .$e->getMessage());
        }
    }
}