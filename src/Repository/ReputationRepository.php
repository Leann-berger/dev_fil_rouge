<?php

namespace App\Repository;


use App\Entity\Reputation;
use App\Database\Mysql;
use PDOException;

class ReputationRepository 
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }


    public function findByName(string $name): ?Reputation
    {   
        try{
            $sql = "SELECT r.id_reputation, r.`reputation` FROM `reputation` AS r 
            WHERE r.`reputation` = ? ";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1, $name, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $reputation = Reputation::hydrate($data);
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        return $reputation ?? null;
    }
}