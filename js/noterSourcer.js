


// Récupération des données du formulaire

const addExist = document.querySelector("#ajoutOuExiste");
const nom = document.querySelector("#name");
const desBrand = document.querySelector("#descriptionMarque");
const catSource = document.querySelector("#categories");
const note = document.querySelector("#note");
const source = document .querySelector("#source");
const desSource = document.querySelector("#descriptionSource");
const brandAlt = document.querySelector("#marqueAlternative");
const catBrand = document.querySelector("#categorieMarque");
const displayNote = document.querySelector("#displayNote")
const form = document.querySelector("form");
const addOnly = document.querySelectorAll(".ajoutUniquement")

// fonction pour stocker toutes les données dans le locale storage

function stockData(){

    // Objet contenant toute les données
    const newBrand = {
        nom: nom.value,
        desBrand: desBrand.value,
        catSource: catSource.value,
        note: note.value,
        source: source.value,
        desSource: desSource.value,
        brandAlt: brandAlt.value,
        catBrand: catBrand.value,
    };


    // convertion de l'objet en chaîne de charactère pour le stocker dans le localeStorage
    localStorage.setItem("brand", JSON.stringify(newBrand));
}




// Ecoute du boutton Validez du formulaire:
// 1) Apelle la fonction pour stocker les données.
// 2) reset le formulaire.

form.addEventListener("submit", (event)=>{
    event.preventDefault()

    stockData();
    
    form.reset()
})


//mise à jours en temps réelle du curseur de la note

note.addEventListener("input", (event)=>{
    event.preventDefault();
    displayNote.innerText = `${note.value}/10`
})



// gestion affichage en fonction des choix "ajouter une marque" ou "noter une marque existante"


addExist.addEventListener("input", (event)=>{
    event.preventDefault()
    if (addExist.value === "existe"){
        addOnly.forEach((element)=>{
            // cache l'élément
            element.style.display = "none"
            // enlève l'attribut "required"
            element.removeAttribute("required")
        })
    } else {
        addOnly.forEach((element)=>{
            // affiche l'élément
            element.style.display = "flex"
            // remet l'attribut "required"
            element.setAttribute("required")
        })
    }
})

