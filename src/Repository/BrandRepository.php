<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Database\Mysql;

class UserRepository
{
    private \PDO $connexion;

    public function __construct()
    {
        $this->connexion = Mysql::connectBdd();
    }


    public function create(Brand $brand): Brand
    {
        try{
            $sql = "INSERT INT brand (description_brand, name_brand, alternative_brand) VALUE (?,?,?)";
            $stmt = $this->connexion->prepare($sql);
            $stmt->bindValue(1, $brand->getDescriptionBrand(), \PDO::PARAM_STR);
            $stmt->bindValue(2, $brand->getNameBrand(), \PDO::PARAM_STR);
            $stmt->bindValue(3, $brand->getAlternativeBrand(), \PDO::PARAM_STR);
            $stmt->execute();
            $id = $this->connexion->lastInsertId();
            $brand->setId($id);
        } catch(\PDOException $e){
            echo "Erreur " . $e->getMessage();
        }
        return $brand;  
    }
    public function findByName(string $name): ?Brand
    {

    }
}