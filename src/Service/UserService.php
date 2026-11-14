<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\Tools;
use App\Service\UploadService;
use App\Repository\RoleRepository;
use App\Repository\ReputationRepository;

class UserService 
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;
    private ReputationRepository $reputationRepository;
    private UploadService $upload;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->roleRepository = new RoleRepository();
        $this->reputationRepository = new ReputationRepository();
        $this->upload = new UploadService();
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
            empty($_POST['confirm-password'])
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
        $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        //récupération du rôle
        $role = $this->roleRepository->findByName('utilisateur');

        if ($role === null) {
            return "Le rôle utilisateur est introuvable.";
        }


        //récupération de la réputaion
        $reputation = $this->reputationRepository->findByName('novice');

        if ($reputation === null) {
            return "La réputation novice est introuvable.";
        }


        //hydrater l'objet User
        $newUser = User::hydrate($_POST, 
        $role,
        $reputation);

        //Setter le mot de passe hashé
        $newUser->setPsw($hash);

        //importer l'image
        $newUser->setImgProfil($this->upload->uploadFile($_FILES["img_profil"], 'assets/img/profil/'));

        //Ajouter en BDD le compte
        $this->userRepository->create($newUser);

        return "Le compte " . $_POST["email"] . " a été ajouté en BDD";
    }

    public function connectUser(): array
    {
    }
}