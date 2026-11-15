<?php

namespace App\Repository;

use App\Database\Mysql;
use App\Entity\CategoryBrand;
use PDOException;

class BrandCategoryRepository
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }

    public function findAll(): array 
    {
        try{
            $sql = "SELECT id_brand_category, category_brand FROM brand_category ORDER BY id_brand_category";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $datas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if($datas){
                $category = [];
                foreach($datas as $data){
                    $category[] = CategoryBrand::hydrate($data);
                }
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        
        return $category ?? [];
    }
}