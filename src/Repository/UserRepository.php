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
            $sql = "INSERT INTO `user`(pseudo_user, first_name_user, name_user, email_user, date_birth_user, psw_user, profile_picture_user, id_role, id_reputation) VALUE(?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1,$user->getPseudo(),\PDO::PARAM_STR);
            $stmt->bindValue(2, $user->getFirstname(), \PDO::PARAM_STR);
            $stmt->bindValue(3, $user->getLastname(), \PDO::PARAM_STR);
            $stmt->bindValue(4, $user->getEmail(), \PDO::PARAM_STR);
            $stmt->bindValue(5, $user->getAge()->format("Y-m-d"), \PDO::PARAM_STR);
            $stmt->bindValue(6, $user->getPsw(), \PDO::PARAM_STR);
            $stmt->bindValue(7, $user->getImgProfil(), \PDO::PARAM_STR);
            $stmt->bindValue(8, $user->getRole()->getId(), \PDO::PARAM_STR);
            $stmt->bindValue(9, $user->getReputation()->getId(), \PDO::PARAM_STR);
            $stmt->execute();
            $id = $this->connect->lastInsertId();
            $user->setId($id);
        } catch(PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
    }


    public function findByEmail(string $email): ?User
    {   
        try{
            $sql = "SELECT u.id_user, u.pseudo_user AS pseudo, u.first_name_user AS firstname, u.name_user AS lastname, u.email_user AS email, u.date_birth_user AS age,
            u.psw_user AS psw, u.profile_picture_user AS img_profil, re.id_reputation, re.reputation, ro.id_role, ro.`role` FROM `user` AS u
            INNER JOIN reputation AS re ON re.id_reputation = u.id_reputation
            INNER JOIN `role` AS ro ON ro.id_role = u.id_role
            WHERE u.email_user = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1,$email, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($data){
                $role = Role::hydrate($data);
                $reputation = Reputation::hydrate($data);
                $user = User::hydrate($data, $role, $reputation);
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        return $user ?? null;
    }

    public function findByPseudo(string $pseudo): ?User
    {
        try{
            $sql = "SELECT u.id_user, u.pseudo_user AS pseudo, u.first_name_user AS firstname, u.name_user AS lastname, u.email_user AS email, u.date_birth_user AS age,
            u.psw_user AS psw, u.profile_picture_user AS img_profil, re.id_reputation, re.reputation, ro.id_role, ro.`role` FROM `user` AS u
            INNER JOIN reputation AS re ON re.id_reputation = u.id_reputation
            INNER JOIN `role` AS ro ON ro.id_role = u.id_role
            WHERE u.pseudo_user = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1,$pseudo, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $role = Role::hydrate($data);
                $reputation = Reputation::hydrate($data);
                $user = User::hydrate($data, $role, $reputation);
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        return $user ?? null;
    }


    public function findById(int $id): ?User
    {   
        try{
            $sql = "SELECT u.id_user, u.pseudo_user AS pseudo, u.first_name_user AS firstname, u.name_user AS lastname, u.email_user AS email, u.date_birth_user AS age,
            u.psw_user AS psw, u.profile_picture_user AS img_profil, re.id_reputation, re.reputation, ro.id_role, ro.`role` FROM `user` AS u
            INNER JOIN reputation AS re ON re.id_reputation = u.id_reputation
            INNER JOIN `role` AS ro ON ro.id_role = u.id_role
            WHERE u.id_user = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(1,$id, \PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($data){
                $role = Role::hydrate($data);
                $reputation = Reputation::hydrate($data);
                $user = User::hydrate($data, $role, $reputation);
            }
        } catch(\PDOException $e){
            error_log("Erreur : " . $e->getMessage());
        }
        return $user ?? null;
    }
}