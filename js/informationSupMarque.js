const brands = document.querySelectorAll(".nomMarque");
const sectionMain = document.querySelectorAll("main>section");
const emptySection = document.querySelector("#emptySection")
const pDes= document.querySelectorAll(".description");
// const catBrand = document.querySelectorAll(".categories")

const newBrand = JSON.parse(localStorage.getItem("brand"))

brands.forEach((element, index)=>{
    element.addEventListener("click", (event)=>{
        event.preventDefault();

        const currentSection = element.closest("section");
        const desSection = currentSection.querySelector(".description")
        const catSection = currentSection.querySelector(".categories")
        const nameAndRate = currentSection.querySelector(".nomEtNote")
        const alternative = currentSection.querySelector("#alternative")

        const catDeroulant =  currentSection.querySelector(".catDeroulant")


        catDeroulant.classList.toggle("open")
       
        if (catDeroulant.className === "catDeroulant open"){
            catDeroulant.style.display = "flex"
            desSection.style.display = "none"; 
            catSection.style.display = "none"
            // Cache toutes les sections sauf la current section
            sectionMain.forEach((el)=>{
                if (el !== currentSection && el !==emptySection){
                    el.style.display = "none"
                } 
            })
        } else {
            catDeroulant.style.display = "none"
            desSection.style.display = "grid"; 
            catSection.style.display = "flex"
            // Cache toutes les sections sauf la current section
            sectionMain.forEach((el)=>{
                if (el !== currentSection && el !==emptySection){
                    el.style.display = "grid"
                } 
            })
        }

        ;
        
        
        



        // déplace la marque restante tout en haut.
        nameAndRate.style.alignSelf = "start"

        
        
        
    })
})













// <div id="catDeroulant">
//     <section class="infoPour1Cat">
//         <div class="categorieMarque">
//             <p>3/10</p>
//             <h2>ÉCOLOGIE</h2>
//             <a href="#">
//                 <button>
//                     Plus de n source
//                 </button>
//             </a>
//         </div>
//         <div>
//             <a href="./NoterSourcer.html">
//                 <button class="noterSourcerCat">
//                     Noter <br> et <br> Sourcer 
//                 </button>
//             </a>
//         </div>
//     </section>
//     <section class="infoPour1Cat">
//         <div class="categorieMarque">
//             <p>3/10</p>
//             <h2>TRANSPARENCE</h2>
//             <a href="#">
//                 <button>
//                     Plus de n source
//                 </button>
//             </a>
//         </div>
//         <div>
//             <a href="./NoterSourcer.html">
//                 <button class="noterSourcerCat">
//                     Noter <br> et <br> Sourcer 
//                 </button>
//             </a>
//         </div>
//     </section>
//     <section class="infoPour1Cat">
//         <div class="categorieMarque">
//             <p>1/10</p>
//             <h2>CONDITION DE <br> TRAVAIL</h2>
//             <a href="#">
//                 <button>
//                     Plus de n source
//                 </button>
//             </a>
//         </div>
//         <div>
//             <a href="./NoterSourcer.html">
//                 <button class="noterSourcerCat">
//                     Noter <br> et <br> Sourcer 
//                 </button>
//             </a>
//         </div>
//     </section>
//     <section id="alternative">
//         <p>Alternative</p>
//         <div id="toutesLesAlternatives">
//             <div class="marqueAlternative">
//                 <p>24/30</p>
//                 <h3>FAGUO</h3>
//             </div>
//             <a href="#">
//                 <button>
//                     Proposer une alternative
//                 </button>
//             </a>
            
//             <div class="marqueAlternative">
//                 <p>21/30</p>
//                 <h3>VEJA</h3>
//             </div>
//         </div>
//     </section>
// </div>