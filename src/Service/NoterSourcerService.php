<?php
namespace App\Service;

use App\Database\Mysql;
use App\Repository\BrandRepository;
use App\Repository\BrandCategoryRepository;
use App\Repository\GradeCategoryRepository;
use App\Repository\UserRepository;
use App\Repository\SourceRepository;
use App\Repository\GradeRepository;
use App\Entity\Brand;
use App\Entity\CategoryBrand;
use App\Entity\CategoryGrade;
use App\Entity\Source;
use App\Entity\Grade;


class NoterSourcerService
{
    private BrandRepository $brandRepository;
    private BrandCategoryRepository $brandCategoryRepository;
    private UserRepository $userRepository;
    private GradeCategoryRepository $gradeCategoryRepository;
    private SourceRepository $sourceRepository;
    private GradeRepository $gradeRepository;

    public function __construct()
    {
        $this->brandRepository = new BrandRepository();
        $this->brandCategoryRepository = new BrandCategoryRepository();
        $this->gradeCategoryRepository = new GradeCategoryRepository();
        $this->sourceRepository = new SourceRepository();
        $this->gradeRepository = new GradeRepository();
        $this->userRepository = new UserRepository();
    }

    /** Données pour remplir les listes du formulaire */
    public function getFormData(): array
    {
        return [
            "brandCategories" => $this->brandCategoryRepository->findAll(),
            "gradeCategories" => $this->gradeCategoryRepository->findAll(),
            "brandNames"      => $this->brandRepository->findAllNames(),
        ];
    }


    public function submit(array $post, int $userId): array
    {
        // ÉTAPE 1 : récupération des valeurs du formulaire
        // trim() enlève les espaces au début et à la fin du texte
        // "?? ''" donne une valeur vide si le champ n'existe pas dans le formulaire

        $brandName = trim($post["name"] ?? "");
        $altName = trim($post["marqueAlternative"] ?? "");
        $description = trim($post["descriptionSource"] ?? "");
        $url = trim($post["source"] ?? "");
        $gradeCategoryId = (int) ($post["categories"] ?? 0);

        // verifie si c'est un entier compris entre 0 et 10
        if ($post["note"] < 0 || $post["note"]>10 || is_double($post["note"])){
            $note = false;
        } else {
            $note = $post["note"];
        }
        


        // check si les champs sont remplit
        if (empty($brandName) || empty($description) || empty($url) || $note === false) {
            return ["success" => false, "msg" => "Veuillez remplir tous les champs obligatoires."];
        }

        
        //check le nombre de charactère
        if (mb_strlen($brandName) > 50) {
            return ["success" => false, "msg" => "Nom de marque trop long (50 caractères max)."];
        }

        if (mb_strlen($description) < 40 || mb_strlen($description) > 200) {
            return ["success" => false, "msg" => "La description de la source doit faire entre 40 et 200 caractères."];
        }

        // test l'url
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (!filter_var($url, FILTER_VALIDATE_URL)
            || ($scheme !== "http" && $scheme !== "https")
            || mb_strlen($url) > 255) {
            return ["success" => false, "msg" => "L'URL de la source n'est pas valide."];
        }



        // check si l'url d'une source est unique
        if ($this->sourceRepository->FindByUrl($url) === null) {
            return ["success" => false, "msg" => "Cette source a déjà été renseignée."];
        }


        
        // check si la marque existe déjà 
        $brand = $this->brandRepository->findByName($brandName);

        $description = "";
        $brandCategoryId = 0;

        
    
        // Ajoute une nouvelle marque
        if ($brand !== null) {
            return ["success" => false, "msg" => "Cette marque existe déjà : choisissez « Noter une marque existante »."];
        }

        //  vérifie sa description et sa catégorie
        $description = trim($post["descriptionMarque"] ?? "");
        $brandCategoryId = (int) ($post["categorieMarque"] ?? 0);

        if (mb_strlen($description) < 20 || mb_strlen($description) > 120) {
            return ["success" => false, "msg" => "La description de la marque doit faire entre 20 et 120 caractères."];
        }

        $brandCategories = $this->brandCategoryRepository->findAll();
        if (!array_key_exists($brandCategoryId, $brandCategories)) {
            return ["success" => false, "msg" => "Catégorie de marque invalide."];
        }
        


        // ÉTAPE 5 : vérification de la marque alternative (facultative)
        // Si elle est invalide, on ne bloque pas tout : on l'ignore et on prévient l'utilisateur.

        $alternativeId = null;  
        $messageAlternative = "";

        if ($altName !== "") {
            $alternativeBrand = $this->brandRepository->findByName($altName);

            // L'alternative doit exister et etre differente de la marque que l'on note
            $isSameBrand = mb_strtolower($altName) === mb_strtolower($brandName);

            if ($alternativeBrand === null || $isSameBrand) {
                $messageAlternative = " (l'alternative proposée a été ignorée : elle doit être une autre marque déjà référencée)";
            } else {
                $alternativeId = $alternativeBrand->getId();
            }
        }


        
        //Lance une seule connexion en bdd pour ajouter tout d'un coup
        $pdo = Mysql::connectBdd();
        $pdo->beginTransaction();

        try {
            //créer l'objet brand
            $user = $this->userRepository->findById($userId);
            $catBrand = CategoryBrand::hydrate(["categoryBrand" => $brandCategories]);
            $brand = Brand::hydrate(["name_brand" => $brandName, "description_brand" => $description], $catBrand, $user);
            
            //ajoute en bdd
            $this->brandRepository->create($brand);
            
            //crée la source
            $source = Source::hydrate(["descritpion" => $description, "url" => $url]);

            //l'ajoute en bdd
            $this->sourceRepository->create($source);

            // créer la note
            $gradeCategory = $this->gradeCategoryRepository->findById($gradeCategoryId);
            $grade = Grade::hydrate(["valueGrade" => $note], $user, $gradeCategory, $brand, $source);

            //l'ajoute en bdd
            $this->gradeRepository->create($grade);

            //  créer le lien entre les deux marques
            if ($alternativeId !== null) {
                $this->brandRepository->addAlternative($brand->getId(), $alternativeId);
            }

            // on valide
            $pdo->commit();

        } catch (\Throwable $e) {
            //on annule tout ce qui a été écrit dans ce bloc
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            // L'erreur détaillée va dans les logs, l'utilisateur voit un message simple
            error_log("Erreur noter/sourcer : " . $e->getMessage());
            return ["success" => false, "msg" => "Une erreur est survenue, rien n'a été enregistré."];
        }


        // renvoie le succès au controller

        return ["success" => true, "msg" => "Merci, votre avis sur " . $brandName . " a bien été enregistré" . $messageAlternative . "."];
    }
}