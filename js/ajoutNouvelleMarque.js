// Récupération de la balise "main"

const main = document.querySelector("main");

// récupération des données dans le localeStorage
const brands = JSON.parse(localStorage.getItem("brands"));


// création d'une fonction pour créer la marque sur le fichier index.html

function createBrand(brand){
    
    // création des balises
    const section = document.createElement("section");
    const divBrand = document.createElement("div");
    const pNote = document.createElement("p");
    const buttonBrand = document.createElement("button");
    const pDes = document.createElement("p");
    const divCat = document.createElement("div");
    const h2 =  document.createElement("h2");
    
    //ajout des informations dans les balises
    pNote.innerText = `${3*brand.note}/30`;
    buttonBrand.innerText = brand.nom.toUpperCase();
    pDes.innerText = brand.desBrand;
    h2.innerText = brand.catBrand.toUpperCase();


    // ajout des balises dans le fichier index.html
    main.appendChild(section);
    section.append(divBrand, pDes, divCat);
    divBrand.append(pNote, buttonBrand);
    divCat.appendChild(h2);

    // ajout aria-label sur la marque.
    buttonBrand.setAttribute("aria-label" ,`Information sur la marque ${brand.nom}`)

    // ajout de class pour la lisibilité du html
    pDes.className = "description";
    divCat.className = "categories";
    divBrand.className = "nomEtNote";
    pNote.className = "noteGenerale";
    buttonBrand.className = "nomMarque";

    // ajout aria label
    buttonBrand.setAttribut ="aria-label", `Information sur la marque ${brand.nom}`

    // creation de la version  2 de accueil
    createCatDeroulant(section, brand);
    
}








function createCatDeroulant(currentSection, brand){
    
    // Création div principale 
    const divMain = document.createElement("div");
    divMain.className = "catDeroulant";
    divMain.style.display = "none"
    
    // Création des trois catégories.
    createCat("ÉCOLOGIE", divMain, brand.catsSource.catEcolo, brand)
    createCat("TRANSPARENCE", divMain, brand.catsSource.catTrans, brand);
    createCat("CONDITION", divMain, brand.catsSource.catCondi, brand);
    
    
    // creation section Alternative:
    const sectionAlt = document.createElement("section");
    sectionAlt.className = "alternative";
    
    // creation contenue setion alternative
    const pAtl = document.createElement("p");
    pAtl.innerText = "Alternative"
    
    const div1SectionAlt = document.createElement("div");
    div1SectionAlt.className = "toutesLesAlternatives";
    
    // marque alt 1
    const divMarqueAlt1 = document.createElement("div")
    divMarqueAlt1.className = "marqueAlternative";
    
    const pNoteAlt1 = document.createElement("p");
    pNoteAlt1.innerText = "24/30";
    
    const h3Alt1 = document.createElement("h3")
    if (brand.brandAlts){
        h3Alt1.innerText = brand.brandAlts[0].nom;
    } else{
        h3Alt1.innerText = "Pas de Marque" 
    }
    
    // Bouton proposer une atl
    const aAlt = document.createElement("a");
    aAlt.setAttribute = "href", "#";
    aAlt.setAttribute = "tabindex", "-1";
    
    const buttonAlt = document.createElement("button");
    buttonAlt.innerText = "Proposer une alternative";
    
    
    // marque alt 2
    const divMarqueAlt2 = document.createElement("div")
    divMarqueAlt2.className = "marqueAlternative";
    
    const pNoteAlt2 = document.createElement("p");
    pNoteAlt2.innerText = "24/30";
    
    const h3Alt2 = document.createElement("h3") 
    h3Alt2.innerText = "Pas de Marque" 
    


    // ajout section Alt dans la div principale
    divMain.appendChild(sectionAlt)
    sectionAlt.append(pAtl, div1SectionAlt);
    div1SectionAlt.append(divMarqueAlt1, aAlt, divMarqueAlt2);
    divMarqueAlt1.append(pNoteAlt1, h3Alt1);
    aAlt.append(buttonAlt);
    divMarqueAlt2.append(pNoteAlt2, h3Alt2);

    // ajout de la div principale dans la section concernée
    currentSection.appendChild(divMain)
    
}







// fonction pour créer les 3 section : ecologie, transparence, condition

function createCat (nom, divMain, cat, brand){
    // creation Section1 :
    const section = document.createElement("section");
    section.className = "infoPour1Cat";
    
    // creation contenue de section1
    const div1Section = document.createElement("div");
    div1Section.className = "categorieMarque";
    
    const pNote = document.createElement("p");
    if (cat.source !== ""){
        pNote.innerText = `${brand.note}/10`;
    }  else {
        pNote.innerText = `X/10`;
    };
    
    const h2 = document.createElement("h2");
    h2.innerText = nom;
    
    const a = document.createElement("a");
    a.setAttribute ="href","#";
    a.setAttribute = "tabindex", "-1";
    
    const buttonSource = document.createElement("button");
    buttonSource.innerText = "Plus de n source";
    
    const div2Section = document.createElement("div");
    
    const aNoterSourcer = document.createElement("a");
    aNoterSourcer.setAttribute="href", "./NoterSourcer.html";
    aNoterSourcer.setAttribute = "tabindex", "-1";
    
    const buttonNoterSourcer = document.createElement("button");
    buttonNoterSourcer.className = "noterSourcerCat";
    buttonNoterSourcer.innerText = "Noter\net\nSourcer";


    divMain.appendChild(section)
    section.append(div1Section, div2Section);
    div1Section.append(pNote, h2, a)
    a.appendChild(buttonSource);
    div2Section.appendChild(aNoterSourcer)
    aNoterSourcer.appendChild(buttonNoterSourcer);
}








// Si il y a des données dans localeStorage, apelle de la fonction creatBrand
if (brands){
    for (const brand of brands){
        createBrand(brand);
    }
}



// localStorage.clear()