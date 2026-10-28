<?php

namespace App\Entity;

class Brand
{
    private ?int $id =null;
    private ?string $alternativeBrand = null;
    private string $descriptionBrand;
    private string $nameBrand;

    //construct
    public function __construct(
        string $descriptionBrand,
        string $nameBrand
    ){

        $this->descriptionBrand = $descriptionBrand;
        $this->nameBrand = $nameBrand;
    }

    //getter et setter

    public function getDescriptionBrand(): string
    {
        return $this->descriptionBrand;
    }

    public function setDescriptionBrand(string $descriptionBrand): void
    {
        $this->descriptionBrand = $descriptionBrand;
    }

    public function getNameBrand(): string
    {
        return $this->nameBrand;
    }

    public function setNameBrand(string $nameBrand): void
    {
        $this->nameBrand = $nameBrand;
    }

    public function getAlternativeBrand(): ?string
    {
        return $this->alternativeBrand;
    }

    public function setAlternativeBrand(?string $alternativeBrand): void
    {
        $this->alternativeBrand = $alternativeBrand;
    }

        public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }


    //function pour hydrater

    public static function hydrate(array $brand): Brand
    {
        //creation de l'objet user
        $newBrand = new Brand(
            $brand["descriptionBrand"],
            $brand["nameBrand"]
        );

        //set des attribut restant
        $newBrand->setId($brand["id_brand"] ?? null);
        $newBrand->setAlternativeBrand($brand["alternativeBrand"] ?? null);

        //retourne l'objet brand
        return $newBrand;

    }
}