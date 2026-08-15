// Récupération de la balise "main"

const main = document.querySelector("main");


// création d'une fonction pour créer la marque sur le fichier index.html

function createBrand(brand, note, desc, catBrand){
    
    // création des balises
    const section = document.createElement("section");
    const divBrand = document.createElement("div");
    const pNote = document.createElement("p");
    const buttonBrand = document.createElement("button");
    const pDes = document.createElement("p");
    const divCat = document.createElement("div");
    const h2 =  document.createElement("h2");
    
    //ajout des informations dans les balises
    pNote.innerText = `${3*note}/30`;
    buttonBrand.innerText = brand.toUpperCase();
    pDes.innerText = desc;
    h2.innerText = catBrand.toUpperCase();


    // ajout des balises dans le fichier index.html
    main.appendChild(section);
    section.append(divBrand, pDes, divCat);
    divBrand.append(pNote, buttonBrand);
    divCat.appendChild(h2);

    // ajout aria-label sur la marque.
    buttonBrand.setAttribute(`aria-label="Information sur la marque ${brand}"`)

    // ajout de class pour la lisibilité du html
    pDes.classList("description")
    divCat.classList("categories")
    
}


// récupération des données dans le localeStorage
const newBrand = JSON.parse(localStorage.getItem("brand"));


// Si il y a des données, apelle de la fonction creatBrand
if (newBrand){
    createBrand(newBrand.nom, newBrand.note, newBrand.desBrand, newBrand.catBrand);
}

// localStorage.clear()