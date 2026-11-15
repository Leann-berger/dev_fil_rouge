<?php

namespace App\Service;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Repository\CategoryBrandRepository;
use App\Utils\Tools;


class BrandService
{
    private BrandRepository $brandRepository;
    private CategoryBrandRepository $categoryBrandRepository;

    public function __construct()
    {
        $this->brandRepository = new BrandRepository();
        $this->categoryBrandRepository = new CategoryBrandRepository();
    }


    public function insertBrand(): string
    {   
        //Vérifie si tous les champs ont bien été remplie
        if(empty($_POST["descriptionBrand"])
        || empty($_POST["name"])
        || empty($_POST["descriptionSource"])
        || empty($_POST["source"])
        || $_POST["categorieBrand"] == "")
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

        $categoryBrand = $this->categoryBrandRepository->findByName($_POST["categorieBrand"]);


        $newBrand = Brand::hydrate($_POST, $categoryBrand);

        $this->brandRepository->create($newBrand);

        return $_POST["name"] . " a bien été ajouté";
    }


    public function getAllBrand(): array
    {
        // récupération des marques et de toute les infos nécessaire pour les afficher.
        $brands = $this->brandRepository->findAll();

        //création d'un tableau pour ou elles seront stockées rangées
        $brandsStock = [];

        //Rangement des marques pour quelle respecte la structure du html
        foreach($brands as $brand){

            //si l'id est unset dans $brandsStock ont créer la structure de stockage voulue en laissant vide grades, total et alternatives pour le moment
            //(Il peut y avoir plusieurs fois la mêmem marque mais avec des catégorie de source différentes. Ont les ajoute donc a part)
            if (!isset($brandsStock[$brand["id_brand"]])){
                $brandsStock[$brand["id_brand"]] = [
                    "id" => $brand["id_brand"], "name" => $brand["name_brand"], "description" => $brand["description_brand"],
                    "category" => $brand["category_brand"], "grades" => [], "total" => null, "alternatives" => [],
                ];
            }

            //ont viens ensuite ajouter pour chaque marque, chaque catégories (label), avec la moyenne des notes (avg) et le nombre de notes (nb)
            $brandsStock[$brand["id_brand"]]["grades"][$brand["id_grade_category"]] = [
                "label" => $brand["name_grade_category"],
                "avg"   => $brand["avg_grade"] !== null ? $brand["avg_grade"] : null,
                "nb"    => $brand["nb_grades"],
            ];

        }

        foreach($brandsStock as $brand){
            $count = 0;
            $nb = 0;
            foreach($brand["grades"] as $grades){
                if ($grades["avg"] != null){
                    $count += $grades["avg"];
                    $nb ++;
                }               
            } 
            
        }

    }


    public function getBrandsForHome(): array
    {
        $brands = [];
        foreach ($this->brandRepository->findAllWithScores() as $r) {
            $id = (int) $r["id_brand"];
            $brands[$id] ??= [
                "id" => $id, "name" => $r["name_brand"], "description" => $r["description_brand"],
                "category" => $r["category_brand"], "grades" => [], "total" => null, "alternatives" => [],
            ];
            $brands[$id]["grades"][(int) $r["id_grade_category"]] = [
                "label" => $r["name_grade_category"],
                "avg"   => $r["avg_grade"] !== null ? (float) $r["avg_grade"] : null,
                "nb"    => (int) $r["nb_grades"],
            ];
        }

        // Note globale /30 : même logique que ton JS (3 × la note), généralisée à la moyenne des catégories notées
        foreach ($brands as &$b) {
            $known = array_filter(array_column($b["grades"], "avg"), fn($v) => $v !== null);
            $b["total"] = $known ? (int) round(3 * array_sum($known) / count($known)) : null;
        }
        unset($b);

        foreach ($this->brandRepository->findAllAlternatives() as $row) {
            $alt = $brands[(int) $row["id_alternative"]] ?? null;
            if ($alt) {
                $brands[(int) $row["id_brand"]]["alternatives"][] = ["name" => $alt["name"], "total" => $alt["total"]];
            }
        }
        return array_values($brands);
    }

}

