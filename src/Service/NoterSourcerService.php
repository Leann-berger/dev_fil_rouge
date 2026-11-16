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

    //Données pour remplir les listes du formulaire 
    public function getFormData(): array
    {
        return [
            "brandCategories" => $this->brandCategoryRepository->findAll(),
            "gradeCategories" => $this->gradeCategoryRepository->findAll(),
        ];
    }


    public function submit(array $post, int $userId): array
    {
        // récupération des valeurs du formulaire

        $brandName         = trim($post["name"] ?? "");
        $brandDescription  = trim($post["descriptionMarque"] ?? "");
        $brandCategoryId   = (int) ($post["categorieMarque"] ?? 0);
        $sourceDescription = trim($post["descriptionSource"] ?? "");
        $url               = trim($post["source"] ?? "");
        $gradeCategoryId   = (int) ($post["categories"] ?? 0);
        $altName           = trim($post["marqueAlternative"] ?? "");

        // false si la note n'est pas un entier compris entre 0 et 10
        $note = filter_var($post["note"] ?? null, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0, "max_range" => 10]]);


        //vérification des champs
        if (empty($brandName) || empty($brandDescription) || empty($sourceDescription) || empty($url) || $note === false) {
            return ["success" => false, "msg" => "Veuillez remplir tous les champs obligatoires."];
        }

        if (mb_strlen($brandName) > 50) {
            return ["success" => false, "msg" => "Nom de marque trop long (50 caractères max)."];
        }

        if (mb_strlen($brandDescription) < 20 || mb_strlen($brandDescription) > 120) {
            return ["success" => false, "msg" => "La description de la marque doit faire entre 20 et 120 caractères."];
        }

        if (mb_strlen($sourceDescription) < 40 || mb_strlen($sourceDescription) > 200) {
            return ["success" => false, "msg" => "La description de la source doit faire entre 40 et 200 caractères."];
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (!filter_var($url, FILTER_VALIDATE_URL)
            || ($scheme !== "http" && $scheme !== "https")
            || mb_strlen($url) > 255) {
            return ["success" => false, "msg" => "L'URL de la source n'est pas valide."];
        }


        //vérifications avec la BDD

        // check si la source existe deja
        if ($this->sourceRepository->findByUrl($url) !== null) {
            return ["success" => false, "msg" => "Cette source a déjà été renseignée."];
        }

        // check si la marque existe deja
        if ($this->brandRepository->findByName($brandName) !== null) {
            return ["success" => false, "msg" => "Cette marque a déjà été renseignée."];
        }

        // check les catégories
        $brandCategory = $this->brandCategoryRepository->findById($brandCategoryId);
        if ($brandCategory === null) {
            return ["success" => false, "msg" => "Catégorie de marque invalide."];
        }

        $gradeCategory = $this->gradeCategoryRepository->findById($gradeCategoryId);
        if ($gradeCategory === null) {
            return ["success" => false, "msg" => "Catégorie de note invalide."];
        }

        // check l'utilisateur connecté
        $user = $this->userRepository->findById($userId);
        if ($user === null) {
            return ["success" => false, "msg" => "Utilisateur introuvable, reconnectez-vous."];
        }


        // vérification de la marque alternative

        // check la marque alternative.
        $alternativeId = null;
        $messageAlternative = "";

        if ($altName !== "") {
            $alternativeBrand = $this->brandRepository->findByName($altName);

            // L'alternative doit exister et être différente de la marque que l'on ajoute
            $isSameBrand = mb_strtolower($altName) === mb_strtolower($brandName);

            if ($alternativeBrand === null || $isSameBrand) {
                $messageAlternative = " (l'alternative proposée a été ignorée : elle doit être une autre marque déjà référencée)";
            } else {
                $alternativeId = $alternativeBrand->getId();
            }
        }


        //enregistrement en BDD
        $pdo = Mysql::connectBdd();
        $pdo->beginTransaction();

        try {
            // la marque
            $brand = Brand::hydrate(["name_brand" => $brandName, "description_brand" => $brandDescription], $brandCategory, $user);
            $this->brandRepository->create($brand);

            // la source
            $source = Source::hydrate(["description" => $sourceDescription, "url" => $url]);
            $this->sourceRepository->create($source);

            // la note
            $grade = Grade::hydrate(["valueGrade" => $note], $user, $gradeCategory, $brand, $source);
            $this->gradeRepository->create($grade);

            // le lien avec la marque alternative
            if ($alternativeId !== null) {
                $this->brandRepository->addAlternative($brand->getId(), $alternativeId);
            }

            $pdo->commit();

        } catch (\Throwable $e) {
            // on annule tout ce qui a été écrit dans ce bloc si il y a la moindre error
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            error_log("Erreur noter/sourcer : " . $e->getMessage());
            return ["success" => false, "msg" => "Une erreur est survenue, rien n'a été enregistré."];
        }

        return ["success" => true, "msg" => "Merci, la marque " . $brandName . " a bien été ajoutée" . $messageAlternative . "."];
    }
}