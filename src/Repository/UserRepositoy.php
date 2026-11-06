<?php

namespace App\Repository;


use App\Entity\User;
use App\Database\Mysql;


class UserRepository 
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }

    public function findByEmail(string $email): ?User
    {   
        try{
            $sql = 'SELECT u.pseudo_user, u.first_name_user, u.name_user, u.email_user, u.date_birth_user FROM `user` AS u 
            WHERE u.email_user = $email';
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $user = User::hydrate($data);
            }
        } catch(\PDOException $e){
            echo "Erreur " . $e->getMessage();
        }
        return $user ?? null;
    }

    public function findByPseudo(string $pseudo): ?User
    {
        try{
            $sql = 'SELECT u.pseudo_user, u.first_name_user, u.name_user, u.email_user, u.date_birth_user FROM `user` AS u
            WHERE u.pseudo = $pseudo';
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $user = User::hydrate($data);
            }
        } catch(\PDOException $e){
            echo "Erreur " . $e->getMessage();
        }
        return $user ?? null;
    }
}