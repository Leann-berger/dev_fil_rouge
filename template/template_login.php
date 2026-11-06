<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/accueil.css">
</head>
<body>
    <?php include 'component/header.php'; ?>
    <h2>Connexion</h2>
    <form action="" method="POSTE">
        <label for="email">Entrez votre email : </label>
        <input type="text" name="email" placeholder="pierre.dupont@exemple.com">
        <label for="password">Entrez votre mot de passe : </label>
        <input type="text" name="password" placeholder="............">
        <input type="submit" name="submit" value="Valider">
    </form>
</body>
</html>