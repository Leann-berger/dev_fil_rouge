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
    pNote.innerText = `${note}/10`;
    buttonBrand.innerText = brand.toUpperCase();
    pDes.innerText = desc;
    h2.innerText = catBrand.toUpperCase();

    // ajout des balises dans le fichier index.html
    main.appendChild(section);
    section.append(divBrand, pDes, divCat);
    divBrand.append(pNote, buttonBrand);
    divCat.appendChild(h2);
    
}


// récupération des données dans le localeStorage
const newBrand = JSON.parse(localStorage.getItem("brand"));


// Si il y a des données, apelle de la fonction creatBrand
if (newBrand){
    createBrand(newBrand.nom, newBrand.note, newBrand.desBrand, newBrand.catBrand);
}

// localStorage.clear()