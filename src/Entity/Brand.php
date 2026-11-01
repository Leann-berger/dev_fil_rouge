<?php

namespace App\Entity;

class Brand
{
    private ?int $id =null;
    private ?string $alternativeBrand = null;
    private string $descriptionBrand;
    private string $nameBrand;
    private ?int $idUser;
    private int $idBrandCategory;

    //construct
    public function __construct(
        string $descriptionBrand,
        string $nameBrand,
        int $idBrandCategory
    ){

        $this->descriptionBrand = $descriptionBrand;
        $this->nameBrand = $nameBrand;
        $this->idBrandCategory = $idBrandCategory;
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

      public function getIdBrandCategory(): int
    {
        return $this->idBrandCategory;
    }

    public function setIdBrandCategory(?int $idBrandCategory): void
    {
        $this->idBrandCategory = $idBrandCategory;
    }


    //function pour hydrater

    public static function hydrate(array $brand): Brand
    {
        //creation de l'objet user
        $newBrand = new Brand(
            $brand["descriptionBrand"],
            $brand["nameBrand"],
            $brand["idBrandCategory"]
        );

        //set des attribut restant
        $newBrand->setId($brand["id_brand"] ?? null);
        $newBrand->setAlternativeBrand($brand["alternativeBrand"] ?? null);
        $newBrand->setIdBrandCategory($brands["idBrandCategory"] ?? null);

        //retourne l'objet brand
        return $newBrand;

    }
}