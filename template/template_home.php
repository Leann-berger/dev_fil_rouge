<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/accueil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php include 'component/header.php'; ?>
    
    <div id="centerOfPage">
        <main class="scroller" tabindex="-1" >
            <div id="greenBand">
                
            </div>
            <section id="emptySection">
                <div id="emptyDiv">
                </div>
            </section>
            <section>
                <div class="nomEtNote">
                    <p class="noteGenerale">7/30</p> 
                    <button aria-label="Information sur la marque Nike" class="nomMarque">NIKE</button>
                </div>
                <p class="description"> entreprise américaine spécialisée dans les chaussures et vêtements de sport</p> 
                <div class="categories">
                    <h2>TEXTILE</h2>
                </div>
                <div class="catDeroulant">
                    <section class="infoPour1Cat">
                        <div class="categorieMarque">
                            <p>3/10</p>
                            <h2>ÉCOLOGIE</h2>
                            <a href="#">
                                <button>
                                    Plus de n source
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="/noterSourcer">
                                <button class="noterSourcerCat">
                                    Noter <br> et <br> Sourcer 
                                </button>
                            </a>
                        </div>
                    </section>
                    <section class="infoPour1Cat">
                        <div class="categorieMarque">
                            <p>3/10</p>
                            <h2>TRANSPARENCE</h2>
                            <a href="#">
                                <button>
                                    Plus de n source
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="/noterSourcer">
                                <button class="noterSourcerCat">
                                    Noter <br> et <br> Sourcer 
                                </button>
                            </a>
                        </div>
                    </section>
                    <section class="infoPour1Cat">
                        <div class="categorieMarque">
                            <p>1/10</p>
                            <h2>CONDITION DE <br> TRAVAIL</h2>
                            <a href="#">
                                <button>
                                    Plus de n source
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="/noterSourcer">
                                <button class="noterSourcerCat">
                                    Noter <br> et <br> Sourcer 
                                </button>
                            </a>
                        </div>
                    </section>
                    <section class="alternative">
                        <p>Alternative</p>
                        <div class="toutesLesAlternatives">
                            <div class="marqueAlternative">
                                <p>24/30</p>
                                <h3>FAGUO</h3>
                            </div>
                            <a href="#">
                                <button>
                                    Proposer une alternative
                                </button>
                            </a>
                            
                            <div class="marqueAlternative">
                                <p>21/30</p>
                                <h3>VEJA</h3>
                            </div>
                        </div>
                    </section>
                </div>
                
                
            </section>
            <?php if (!empty($data["flash"])): ?>
                <p role="status"><?= htmlspecialchars($data["flash"]) ?></p>
            <?php endif; ?>

            <?php foreach ($data["brands"] ?? [] as $brand): ?>
            <section>
                <div class="nomEtNote">
                    <p class="noteGenerale"><?= $brand["total"] ?? "X" ?>/30</p>
                    <button class="nomMarque"
                            aria-label="Information sur la marque <?= htmlspecialchars($brand["name"]) ?>">
                        <?= htmlspecialchars(mb_strtoupper($brand["name"])) ?>
                    </button>
                </div>
                <p class="description"><?= htmlspecialchars($brand["description"]) ?></p>
                <div class="categories"><h2><?= htmlspecialchars(mb_strtoupper($brand["category"])) ?></h2></div>

                <div class="catDeroulant">
                    <?php foreach ($brand["grades"] as $idCat => $grade): ?>
                    <section class="infoPour1Cat">
                        <div class="categorieMarque">
                            <p><?= $grade["avg"] !== null ? $grade["avg"] : "X" ?>/10</p>
                            <h2><?= htmlspecialchars(mb_strtoupper($grade["label"])) ?></h2>
                            <a href="#"><button>Plus de <?= $grade["nb"] ?> source<?= $grade["nb"] > 1 ? "s" : "" ?></button></a>
                        </div>
                        <div>
                            <a href="/noterSourcer"><button class="noterSourcerCat">Noter <br> et <br> Sourcer</button></a>
                        </div>
                    </section>
                    <?php endforeach; ?>

                    <section class="alternative">
                        <p>Alternative</p>
                        <div class="toutesLesAlternatives">
                            <?php foreach (array_slice($brand["alternatives"], 0, 2) as $alt): ?>
                            <div class="marqueAlternative">
                                <p><?= $alt["total"] ?? "X" ?>/30</p>
                                <h3><?= htmlspecialchars(mb_strtoupper($alt["name"])) ?></h3>
                            </div>
                            <?php endforeach; ?>
                            <a href="/noterSourcer"><button>Proposer une alternative</button></a>
                        </div>
                    </section>
                </div>
            </section>
            <?php endforeach; ?>
            
            
        </main>
        <div id="buttonAndAside">
            <div id="myButton">
                <button tabindex="1">
                    Filtrer
                    <img src="/assets/img/funnel.svg" alt="icone Filtrer">
                </button>
                <a href="/noterSourcer" tabindex="-1"><button tabindex="1">Noter<br> et <br>Sourcer</button></a>
            </div>
            
            <aside>
                <h3>Qui somme nous</h3>
                <p>
                    Ethima est un site qui souhaite mettre en avant le respect des travailleur, de la planète et celui du consommateur. il a pour but de pousser vers une consommation éco-responsable
                </p>
            </aside>
        </div>
    </div>
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
    <script type="module" src="/js/informationSupMarque.js"></script>
</body>
</html>