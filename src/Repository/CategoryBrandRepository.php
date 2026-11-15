<?php

namespace App\Repository;


use App\Entity\CategoryBrand;
use App\Database\Mysql;
use PDOException;

class CategoryBrandRepository 
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }


    public function findByName(string $name): ?CategoryBrand
    {   
        try{
            $sql = "SELECT d.id_brand_category, d.category_brand FROM brand_category AS d
            WHERE r.category_brand = ? ";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1, $name, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $categoryBrand = CategoryBrand::hydrate($data);
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        return $categoryBrand ?? null;
    }
}