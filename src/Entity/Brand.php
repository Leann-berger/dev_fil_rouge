<?php

namespace App\Entity;

class Brand
{
    private ?int $id =null;
    private string $descriptionBrand;
    private string $nameBrand;
    private CategoryBrand $categoryBrand;

    //construct
    public function __construct(
        string $descriptionBrand,
        string $nameBrand,
        CategoryBrand $categoryBrand
    ){

        $this->descriptionBrand = $descriptionBrand;
        $this->nameBrand = $nameBrand;
        $this->categoryBrand = $categoryBrand;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

      public function getCategoryBrand(): CategoryBrand
    {
        return $this->categoryBrand;
    }

    public function setCategoryBrand(CategoryBrand $categoryBrand): void
    {
        $this->categoryBrand = $categoryBrand;
    }


    //function pour hydrater

    public static function hydrate(array $brand, CategoryBrand $categoryBrand, ?User $user = null): Brand
    {
        //creation de l'objet user
        $newBrand = new Brand(
            $brand["description_brand"],
            $brand["name_brand"],
            $categoryBrand
        );

        //set des attribut restant
        $newBrand->setId($brand["id_brand"] ?? null);

        //retourne l'objet brand
        return $newBrand;

    }
}