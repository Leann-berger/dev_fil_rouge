


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
    const brand = {
        nom: nom.value,
        desBrand: desBrand.value,
        note: note.value,
        catBrand: catBrand.value,
        
        catsSource: {
            catEcolo : {
                noteSource: "",
                source: "",
                desSource: "",
            },
            catTrans: {
                noteSource: "",
                source: "",
                desSource: "",
            },
            catCondi: {
                noteSource: "",
                source: "",
                desSource: "",
            },
        },
        brandAlts: [],
    }

    if (catSource.value === "ecologie"){
        brand.catsSource.catEcolo.source = source.value;
        brand.catsSource.catEcolo.desSource = desSource.value;
    } else {
        if  (catSource.value === "Transparence"){
            brand.catsSource.catTrans.source = source.value;
            brand.catsSource.catTrans.desSource = desSource.value;
        } else {
            brand.catsSource.catCondi.source = source.value;
            brand.catsSource.catCondi.desSource = desSource.value;
        }
    }

    if (brandAlt.value){
        brand.brandAlts.push({nom :brandAlt.value})
    }
    

    const brands = JSON.parse(localStorage.getItem("brands")) || []
    brands.push(brand)
    console.log(brands)
    // convertion de l'objet en chaîne de charactère pour le stocker dans le localeStorage
    localStorage.setItem("brands", JSON.stringify(brands));
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
            element.required = false
        })
    } else {
        addOnly.forEach((element)=>{
            // affiche l'élément
            element.style.display = "flex"
            // remet l'attribut "required"
            element.required = true
        })
    }
})

