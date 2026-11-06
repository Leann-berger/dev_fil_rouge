<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\Tools;

class UserService 
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }


    public function insertUser():string
    {
        //Tester si les champs obligatoire sont vides
        if (
            empty($_POST['firstname']) ||
            empty($_POST['lastname']) ||
            empty($_POST['pseudo']) ||
            empty($_POST['email']) ||
            empty($_POST['password']) ||
            empty($_POST['comfirm-password'])
        ) {
            return "Veuillez remplir tout les champs obligatoir du formulaire.";
        }

        //Nettoyer les données
        Tools::sanitizeArray($_POST);

        //Tests Si email est non valide
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                return "Email non valide.";
            }

        //Tests si les 2 mot de sont différents
        if ($_POST['password'] != $_POST['comfirm-password'])
            {
                return "Les mots de passe ne sont pas identique.";
            }

        //Test si le mot de passe est plus petit que 8 caractères
        if(strlen($_POST['password'])<8)
            {
                return 'Mot de passe trop court. Il doit contenir au minimum 8 charactère.';
            }
        
        //récupérer le compte
        $user = $this->userRepository->findByEmail($_POST["email"]);

        //Tester si le compte existe
        if($user)
            {
                return "Ce compte existe déjà";
            }
        
        //Tester si le pseudo existe 
        if($this->userRepository->findByPseudo($_POST["pseudo"]))
            {
                return "Ce Pseudo est déjà pris";
            }

        //Hasher le mot de passe
        //hydrater l'objet User
        //Setter le mot de passe hashé
        //importer l'image
        //Ajouter en BDD le compte
    }
}