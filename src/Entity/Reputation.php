<?php

namespace App\Entity;

class Reputation
{
    private ?int $id = null;
    private string $reputation;

    //construct
    public function __construct(
        int $id,
        string $reputation
    ){
        $this->id = $id;
        $this->reputation = $reputation;
    }

    //getter et setter
    public function getReputation(): string
    {
        return $this->reputation;
    }

    public function setReputation(string $reputation): void
    {
        $this->reputation = $reputation;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }


    public static function hydrate(array $reputation): Reputation
    {
        $newReputation = new Reputation(
            $reputation["id_reputation"],
            $reputation["reputation"]
        );

        return $newReputation;
    }

}