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
            <input type="text" id="name" name="name" list="brandNames" maxlength="50" required>
            <datalist id="brandNames">
                <?php foreach ($data["brandNames"] ?? [] as $n): ?>
                    <option value="<?= htmlspecialchars($n) ?>">
                <?php endforeach; ?>
            </datalist>

            <select name="categorieMarque" id="categorieMarque" required>
                <option value="">Choisissez une catégorie</option>
                <?php foreach ($data["brandCategories"] ?? [] as $id => $label): ?>
                    <option value="<?= $id ?>"><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
            </select>

            <select name="categories" id="categories">
                <?php foreach ($data["gradeCategories"] ?? [] as $id => $label): ?>
                    <option value="<?= $id ?>"><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- ... note, source, descriptions inchangés ... -->
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