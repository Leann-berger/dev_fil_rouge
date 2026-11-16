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


    public function findById(int $id): ?CategoryGrade
    {   
        try{
            $sql = "SELECT cg.id_grade_category, cg.name_grade_category FROM grade_category AS cg
            WHERE u.id_grade_category = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1,$id, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($data){
                $categoryGrade = CategoryGrade::hydrate($data);
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        return $categoryGrade ?? null;
    }

}