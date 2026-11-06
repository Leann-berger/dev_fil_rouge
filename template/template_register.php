<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="firstname">Entrez votre Prénom : </label>
        <input type="text" name="firstname" placeholder="Ex: Pierre">
        <label for="lastname">Entrez votre Nom : </label>
        <input type="text" name="lastname" placeholder="Ex: Dupont">
        <label for="age">Entrez votre date de naissance : </label>
        <input type="date" name="age" >
        <label for="pseudo">Saisir un pseudo</label>
        <input type="text" name="pseudo" placeholder="Ex: PierreDu123">
        <label for="email">Entrez votre email : </label>
        <input type="text" name="email" placeholder="pierre.dupont@exemple.com">
        <label for="password">Saisir un mot de passe : </label>
        <input type="password" name="password" placeholder="...............">
        <label for="comfirm-password">Comfirmer votre mot de passe : </label>
        <input type="password" name="confirm-password" placeholder=".................">
        <label for="img_profil">importer une image de profil </label>
        <input type="file" name="img_profil">
        
        <input type="submit" value="Validez" name="submit">
    </form>
</body>
</html>