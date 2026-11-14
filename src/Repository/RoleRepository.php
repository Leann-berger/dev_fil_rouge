<?php

namespace App\Repository;


use App\Entity\Role;
use App\Database\Mysql;
use PDOException;

class RoleRepository 
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }


    public function findByName(string $nameRole): ?Role
    {   
        try{
            $sql = "SELECT r.id_role, r.`role` FROM `role` AS r 
            WHERE r.`role` = $nameRole";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $role = Role::hydrate($data);
            }
        } catch(\PDOException $e){
            echo "Erreur " . $e->getMessage();
        }
        return $role ?? null;
    }
}