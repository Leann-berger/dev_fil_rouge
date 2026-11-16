<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Database\Mysql;
use App\Entity\Alternative;
use App\Entity\CategoryBrand;
use PDOException;

class BrandRepository
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }


    public function create(Brand $brand): void
    {
        $sql = "INSERT INTO brand (description_brand, name_brand, id_user, id_brand_category) VALUES (?,?,?,?)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(1, $brand->getDescriptionBrand(), \PDO::PARAM_STR);
        $stmt->bindValue(2, $brand->getNameBrand(), \PDO::PARAM_STR);
        $stmt->bindValue(3, $brand->getUser()?->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(4, $brand->getCategoryBrand()->getId(), \PDO::PARAM_INT);
        $stmt->execute();
        $brand->setId((int) $this->connect->lastInsertId());
    }

    public function findByName(string $name): ?Brand
    {
        try {
            $sql = "SELECT b.id_brand, b.description_brand, b.name_brand, bc.id_brand_category, bc.category_brand
                    FROM brand AS b
                    INNER JOIN brand_category AS bc ON bc.id_brand_category = b.id_brand_category
                    WHERE b.name_brand = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1, $name, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($data) {
                $categoryBrand = CategoryBrand::hydrate($data);
                $brand = Brand::hydrate($data, $categoryBrand);
            }
        } catch (\PDOException $e) {
            error_log("Erreur : " . $e->getMessage());
        }
        return $brand ?? null;
    }

    public function addAlternative(int $idBrand, int $idAlternative): void
    {     
        $sql = "INSERT IGNORE INTO to_change(id_brand_brand, id_brand_alternative_brand) VALUE (?,?)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(1, $idBrand, \PDO::PARAM_INT);
        $stmt->bindValue(2, $idAlternative, \PDO::PARAM_INT);
        $stmt->execute();
  
    }



    public function findAll(): array
    {
        try {
            $sql = "SELECT b.id_brand, b.name_brand, b.description_brand, bc.category_brand,
                        gc.id_grade_category, gc.name_grade_category,
                        ROUND(AVG(g.value_grade), 1) AS avg_grade,
                        COUNT(*) AS nb_grades
                    FROM brand b
                    INNER JOIN brand_category bc ON bc.id_brand_category = b.id_brand_category
                    INNER JOIN grade g           ON g.id_brand = b.id_brand
                    INNER JOIN grade_category gc ON gc.id_grade_category = g.id_grade_category
                    GROUP BY b.id_brand, gc.id_grade_category
                    ORDER BY b.name_brand, gc.id_grade_category";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erreur : " . $e->getMessage());
        }
        return $data ?? [];
    }

    public function findAllAlternatives(): array
    {
        try {
            $sql = "SELECT id_brand_brand AS id_brand, id_brand_alternative_brand AS id_alternative FROM to_change";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erreur : " . $e->getMessage());
        }
        return $data ?? [];
    }
}