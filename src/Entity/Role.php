<?php

namespace App\Entity;

class Role
{
    private ?int $id = null;
    private string $role;

    //construct
    public function __construct(
        int $id,
        string $role
    ){
        $this->id = $id;
        $this->role = $role;
        
    }

    //getter et setter
    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    //hydrate
    public static function hydrate(array $role): Role
    {
        $newRole = new Role(
            $role["id_role"],
            $role["role"]
        );

        return $newRole;
    }

}