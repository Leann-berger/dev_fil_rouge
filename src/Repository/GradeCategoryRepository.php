<?php

namespace App\Repository;

use App\Database\Mysql;
use App\Entity\CategoryGrade;
use PDOException;

class GradeCategoryRepository
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }

    public function findAll(): array 
    {
        try{
            $sql = "SELECT id_grade_category, name_grade_category FROM grade_category ORDER BY id_grade_category";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $datas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if($datas){
                $category = [];
                foreach($datas as $data){
                    $category[] = CategoryGrade::hydrate($data);
                }
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        
        return $category ?? [];
    }
}