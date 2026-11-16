<?php
namespace App\Repository;

use App\Entity\Source;
use App\Database\Mysql;
use \PDOException;


class SourceRepository
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }

    public function findByUrl(String $url): ?Source
    {
        try{
            $sql = "SELECT s.id_source, s.description_source AS description, s.url_source AS url, s.nbr_like_source AS `like`, s.date_source AS created_at 
            FROM `source` AS s
            WHERE s.url_source = ? ";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1, $url, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $source = Source::hydrate($data);
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        return $source ?? null;
    }


    public function create(Source $source): void
    {
        
        $sql = "INSERT INTO `source`(description_source, url_source, date_source) VALUE(?,?,?)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(1,$source->getDescription(),\PDO::PARAM_STR);
        $stmt->bindValue(2, $source->getUrl(), \PDO::PARAM_STR);
        $stmt->bindValue(3, $source->getCreateAt()->format("Y-m-d H:i:s"), \PDO::PARAM_STR);
        $stmt->execute();
        $id = $this->connect->lastInsertId();
        $source->setId($id);
        
    }
}