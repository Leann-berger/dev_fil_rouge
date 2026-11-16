<?php

namespace App\Service;

use App\Repository\BrandRepository;
use App\Repository\GradeCategoryRepository;
use App\Utils\Tools;


class BrandService
{
    private BrandRepository $brandRepository;
    private GradeCategoryRepository $gradeCategoryRepository;

    public function __construct()
    {
        $this->brandRepository = new BrandRepository();
        $this->gradeCategoryRepository = new GradeCategoryRepository();
    }



    public function getAllBrand(): array
    {
        
        $emptyGrades = [];
        foreach ($this->gradeCategoryRepository->findAll() as $category) {
            $emptyGrades[$category->getId()] = [
                "label" => $category->getNameCategoryGrade(),
                "avg"   => null,
                "nb"    => 0,
            ];
        }

        $brands = $this->brandRepository->findAll();
        $brandsStock = [];

        foreach ($brands as $brand) {
            if (!isset($brandsStock[$brand["id_brand"]])) {
                $brandsStock[$brand["id_brand"]] = [
                    "id" => $brand["id_brand"], "name" => $brand["name_brand"], "description" => $brand["description_brand"],
                    "category" => $brand["category_brand"],
                    "grades" => $emptyGrades,      // <- au lieu de []
                    "total" => null, "alternatives" => [],
                ];
            }

            //ajoute pour chaque marque, chaque catégories (label), avec la moyenne des notes (avg) et le nombre de notes (nb)
            $brandsStock[$brand["id_brand"]]["grades"][$brand["id_grade_category"]] = [
                "label" => $brand["name_grade_category"],
                "avg"   => $brand["avg_grade"] !== null ? $brand["avg_grade"] : null,
                "nb"    => $brand["nb_grades"],
            ];

        }

        foreach ($brandsStock as $id => $brand) {
            $sum = 0;
            $nb = 0;
            foreach ($brand["grades"] as $grade) {
                if ($grade["avg"] !== null) {
                    $sum += $grade["avg"];
                    $nb++;
                }
            }

            if ($nb > 0) {
                $brandsStock[$id]["total"] = round(3 * $sum / $nb);
            }
        }

        // ajout des marques alternatives
        foreach ($this->brandRepository->findAllAlternatives() as $brand) {
            $alt = $brandsStock[$brand["id_alternative"]] ?? null;
            if ($alt !== null) {
                $brandsStock[$brand["id_brand"]]["alternatives"][] = [
                    "name"  => $alt["name"],
                    "total" => $alt["total"],
                ];
            }
        }

        return $brandsStock;

    }
}
