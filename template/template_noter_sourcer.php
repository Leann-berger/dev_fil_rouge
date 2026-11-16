<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/NoterSourcer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php include 'component/header.php'; ?>

    <main>
        <?php if (!empty($data["msg"])): ?>
            <p role="alert"><?= htmlspecialchars($data["msg"]) ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="name">Nom de la marque:</label>
            <div>
                <input type="text" id="name" name="name" placeholder="Ex: Décathlon" maxlength="50" required>
            </div>

            <label for="categorieMarque">De quelle catégorie fait partie cette marque?</label>
            <div>
                <select name="categorieMarque" id="categorieMarque" required>
                    <option value="">Choisissez une catégorie</option>
                    <?php foreach ($data["brandCategories"] ?? [] as $category): ?>
                        <option value="<?= $category->getId() ?>"><?= htmlspecialchars($category->getCategoryBrand()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label for="descriptionMarque">Description de la marque: </label>
            <div>
                <textarea id="descriptionMarque" name="descriptionMarque" maxlength="120" minlength="20" placeholder="Écrivez une description simple de la marque." required></textarea>
            </div>

            <label for="categories">Choisissez la catégorie que vous souhaitez noter:</label>
            <div>
                <select name="categories" id="categories">
                    <?php foreach ($data["gradeCategories"] ?? [] as $category): ?>
                        <option value="<?= $category->getId() ?>"><?= htmlspecialchars($category->getNameCategoryGrade()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label for="note">Quelle note voulez vous mettre à cette marque? <br> (par rapport a la catégorie selectionnée)</label>
            <div>
                <p id="displayNote">5/10</p>
                <input type="range" id="note" name="note" min="0" max="10" value="5" required>
            </div>

            <label for="source">Ajouter une source pour appuyer votre avis:</label>
            <div>
                <input type="text" id="source" name="source" placeholder="Ex: https://masource/monarticle/" required>
            </div>

            <label for="descriptionSource">Description de la source:</label>
            <div>
                <textarea id="descriptionSource" name="descriptionSource" maxlength="200" minlength="40" placeholder="Écrivez une description simple de la source pour donner envie au autres utlisateurs." required></textarea>
            </div>

            <label for="marqueAlternative">Une marque alternative à proposer? (doit déjà être référencée)</label>
            <div>
                <input type="text" id="marqueAlternative" name="marqueAlternative" placeholder="Ex: Patagonia">
            </div>

            <button type="submit" name="submit" id="valider">Valider</button>
        </form>
    </main>
    
    <footer>
        <section>
            <p>Raison sociale</p>
            <p>Siret</p>
            <p>Numéro RCS</p>
            <p>Numéor TVA</p>
            <p>@copie 2026. ETHIMA.fr</p>
        </section>
        <section>
            <a href="#">Mentions légales</a>
            <a href="#">Politique de protection des données</a>
        </section>
        
    </footer>
    
    <script type="module" src="/js/noterSourcer.js"></script>
</body>
</html>