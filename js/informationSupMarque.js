const brands = document.querySelectorAll("section div button");
const sectionMain = document.querySelectorAll("main section");
const emptySection = document.querySelector("#emptySection")
const pDes= document.querySelectorAll(".description");
const catBrand = document.querySelectorAll("categories")

brands.forEach((element, index)=>{
    element.addEventListener("click", (event)=>{
        event.preventDefault();
        // element.setAttribute("id","use")
        const currentSection = element.closest("section");
        const desSection = currentSection.querySelector(".description")
        const catSection = currentSection.querySelector(".categories")

        desSection.style.display = "none";
        catSection.style.display = "none";
        
        sectionMain.forEach((el)=>{
            if (el !== currentSection && el !==emptySection){
                el.style.display = "none"
            }
        })

    })
})