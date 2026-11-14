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
    <?php if (!empty($data["msg"])): ?>
        <p><?= htmlspecialchars($data["msg"]) ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <label for="email">Entrez votre email : </label>
        <input type="text" name="email" placeholder="pierre.dupont@exemple.com">
        <label for="password">Entrez votre mot de passe : </label>
        <input type="password" name="password" >
        <input type="submit" name="submit" value="Valider">
    </form>
</body>
</html>