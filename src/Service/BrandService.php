<?php

namespace App\Service;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Utils\Tools;


class BrandService
{
    private BrandRepository $brandRepository;

    public function __construct()
    {
        $this->brandRepository = new BrandRepository();
    }


    public function insertBrand(): string
    {   
        //Vérifie si tous les champs ont bien été remplie
        if(empty($_POST["description_brand"])
        || empty($_POST["name"])
        || empty($_POST["descriptionMarque"]))
        {
            return "Veuillez ramplir tous les champs du formulaire";
        }

        //Nettoie les données
        Tools::sanitizeArray($_POST);

        //Vérifie si la marque existe déjà
        $brand = $this->brandRepository->findByName($_POST["name"]);

        if($brand){
            return "Cette marqe a déjà été renseignée";
        }


        $newBrand = Brand::hydrate($_POST);

        $this->brandRepository->create($newBrand);

        return $_POST["name"] . " a bien été ajouté";
    }

}

