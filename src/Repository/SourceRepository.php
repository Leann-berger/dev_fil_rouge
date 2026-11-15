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

    public function findByUrl(String $url): Source
    {
        try{
            $sql = "SELECT s.id_souce, s.description_source, s.url_source, s.nbr_like_source, s.date_source FROM `source` AS s
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
        try{
            $sql = "INSERT INTO `source`(description_source, url_source, date_source) VALUE(?,?,?)";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1,$source->getDescription(),\PDO::PARAM_STR);
            $stmt->bindValue(2, $source->getUrl(), \PDO::PARAM_STR);
            $stmt->bindValue(3, $source->getCreateAt()->format("Y-m-d"), \PDO::PARAM_STR);
            $stmt->execute();
            $id = $this->connect->lastInsertId();
            $source->setId($id);
        } catch(PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
    }
}