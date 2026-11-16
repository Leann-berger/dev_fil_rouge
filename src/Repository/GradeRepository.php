<?php
namespace App\Repository;

use App\Entity\Grade;
use App\Database\Mysql;
use \PDOException;


class GradeRepository
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }


    public function create(Grade $grade): void
    {
        
        $sql = "INSERT INTO grade (value_grade, id_user, id_grade_category, id_brand, id_source) VALUE(?,?,?,?,?)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(1,$grade->getValueGrade(),\PDO::PARAM_INT);
        $stmt->bindValue(2, $grade->getUser()->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(3, $grade->getCategoryGrade()->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(4, $grade->getBrand()->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(5, $grade->getSource()->getId(), \PDO::PARAM_INT);
        $stmt->execute();
        $id = $this->connect->lastInsertId();
        $grade->setId($id);
        
    }
}