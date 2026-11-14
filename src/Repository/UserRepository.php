<?php

namespace App\Repository;


use App\Entity\User;
use App\Database\Mysql;
use App\Entity\Role;
use App\Entity\Reputation;
use PDOException;

class UserRepository 
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }


    public function create(User $user): void
    {
        try{
            $sql = "INSERT INTO `user`(firstname, lastname, email, `password`, img_profil, id_role, id_reputation) VALUE(?,?,?,?,?,?,?)";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1, $user->getFirstname(), \PDO::PARAM_STR);
            $stmt->bindValue(2, $user->getLastname(), \PDO::PARAM_STR);
            $stmt->bindValue(3, $user->getEmail(), \PDO::PARAM_STR);
            $stmt->bindValue(4, $user->getPsw(), \PDO::PARAM_STR);
            $stmt->bindValue(5, $user->getImgProfil(), \PDO::PARAM_STR);
            $stmt->bindValue(6, $user->getRole()->getId(), \PDO::PARAM_STR);
            $stmt->bindValue(7, $user->getReputation()->getId(), \PDO::PARAM_STR);
            $stmt->execute();
            $id = $this->connect->lastInsertId();
            $user->setId($id);
        } catch(PDOException $e){
            echo "Erreur " . $e->getMessage();
        }
    }


    public function findByEmail(string $email): ?User
    {   
        try{
            $sql = "SELECT u.pseudo_user, u.first_name_user, u.name_user, u.email_user, u.date_birth_user, re.reputation, re.id_reputation, ro.`role`, ro.id_role FROM `user` AS u
            INNER JOIN reputation AS re ON re.id_reputation = u.id_reputation
            INNER JOIN `role` AS ro ON ro.id_role = u.id_role
            WHERE u.email_user = :email";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($data){
                $role = Role::hydrate($data);
                $reputation = Reputation::hydrate($data);
                $user = User::hydrate($data, $role, $reputation);
            }
        } catch(\PDOException $e){
            echo "Erreur " . $e->getMessage();
        }
        return $user ?? null;
    }

    public function findByPseudo(string $pseudo): ?User
    {
        try{
            $sql = "SELECT u.pseudo_user, u.first_name_user, u.name_user, u.email_user, u.date_birth_user, re.reputation, re.id_reputation, ro.id_role, ro.`role` FROM `user` AS u
            INNER JOIN reputation AS re ON re.id_reputation = u.id_reputation
            INNER JOIN `role` AS ro ON ro.id_role = u.id_role
            WHERE u.pseudo_user = :pseudo";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $role = Role::hydrate($data);
                $reputation = Reputation::hydrate($data);
                $user = User::hydrate($data, $role, $reputation);
            }
        } catch(\PDOException $e){
            echo "Erreur " . $e->getMessage();
        }
        return $user ?? null;
    }
}