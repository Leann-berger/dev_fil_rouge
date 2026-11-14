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


    public function findByName(string $nameReputation): ?Reputation
    {   
        try{
            $sql = "SELECT r.id_reputation, r.`reputation` FROM `reputation` AS r 
            WHERE r.`reputation` = $nameReputation";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $reputation = reputation::hydrate($data);
            }
        } catch(\PDOException $e){
            echo "Erreur " . $e->getMessage();
        }
        return $reputation ?? null;
    }
}