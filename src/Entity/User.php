<?php

namespace App\Entity;

class User
{
    private ?int $id = null;
    private string $pseudo;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $psw;
    private \DateTimeImmutable $createAt;
    private ?string $imgProfil;

    //function construct
    public function __construct(
        string $pseudo,
        string $firstname,
        string $lastname,
        string $email,
        string $psw,
    ){
        $this->pseudo = $pseudo;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->psw = $psw;
        $this->createAt = new \DateTimeImmutable();
    }

    //getter et setter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPsw(): string
    {
        return $this->psw;
    }

    public function setPsw(string $psw): void
    {
        $this->psw = $psw;
    }

    public function getCreateAt(): \DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): void
    {
        $this->createAt = $createAt;
    }

    public function getImgProfil(): ?string
    {
        return $this->imgProfil;
    }

    public function setImgProfil(?string $imgProfil): void
    {
        $this->imgProfil = $imgProfil;
    }


    //function pour hydrater

    public static function hydrate(array $user): User
    {
        //creation de l'objet user
        $newUser = new User(
            $user["pseudo"],
            $user["firstname"],
            $user["lastname"],
            $user["email"],
            $user["psw"]
        );

        //set des attribut restant
        $newUser->setId($user["id_user"] ?? null);
        $newUser->setCreateAt(new \DateTimeImmutable($user["created_at"] ?? "") ?? null);
        $newUser->setImgProfil($user["img_profil"] ?? null);

        //retourne l'objet User
        return $newUser;

    }
}