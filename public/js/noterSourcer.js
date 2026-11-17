
// const addExist    = document.querySelector("#ajoutOuExiste");
const note        = document.querySelector("#note");
const displayNote = document.querySelector("#displayNote");
// const addOnly     = document.querySelectorAll(".ajoutUniquement");

// Affichage en direct de la note
note.addEventListener("input", () => {
    displayNote.innerText = `${note.value}/10`;
});

// // "Ajouter une marque" vs "Noter une marque existante"
// addExist.addEventListener("change", () => {
//     const isExisting = addExist.value === "existe";
//     addOnly.forEach((el) => {
//         el.style.display = isExisting ? "none" : "flex";
//         el.querySelectorAll("select, textarea, input").forEach((field) => {
//             field.required = !isExisting;
//             field.disabled = isExisting;   // un champ désactivé n'est pas envoyé
//         });
//     });
// });




