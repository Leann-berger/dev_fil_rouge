<header>
    <a href="/" aria-label="Actualiser la page" tabindex="1"><img src="/assets/img/logo_fil_rouge.png" alt="image du logo d'Ethima"></a>
    <div>
        <h1>ETHIMA</h1>
        <nav>
            <input type="search" id="search_bar" name="search_bar" placeholder="Rechercher une marque..." aria-label="Barre de recherche" tabindex="1">
            <button aria-label="Rechercher" tabindex="1"><img src="/assets/img/search.svg" alt="icone loupe"></button>
        </nav>
    </div>
    <a href="#" aria-label="Liens vers votre profile" tabindex="1"><img src="/assets/img/profil/photo_profil_fil_rouge.png" alt="image de votre photo de profil"></a>
    <?php if (isset($_SESSION["user"])): ?>
        <span><?= htmlspecialchars($_SESSION["user"]["pseudo"]) ?></span>
        <a href="/logout">déconnexion</a>
    <?php else: ?>
        <a href="/login">connexion</a>
        <a href="/register">inscription</a>
    <?php endif; ?>
</header>