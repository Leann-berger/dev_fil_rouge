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


    public function findByName(string $name): ?Role
    {   
        try{
            $sql = "SELECT r.id_role, r.`role` FROM `role` AS r 
            WHERE r.`role` = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1,$name, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $role = Role::hydrate($data);
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        return $role ?? null;
    }
}