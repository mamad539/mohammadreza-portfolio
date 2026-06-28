const burger = document.getElementById("burger");
const nav = document.getElementById("nav");
const lang = document.getElementById("lang");

burger?.addEventListener("click",()=>{
nav.style.display = nav.style.display==="flex"?"none":"flex";
});

/* scroll reveal */
const observer = new IntersectionObserver(entries=>{
entries.forEach(entry=>{
if(entry.isIntersecting){
entry.target.classList.add("active");
}
});
},{threshold:0.1});

document.querySelectorAll(".reveal").forEach(el=>{
observer.observe(el);
});

/* simple lang toggle (demo lightweight) */
let isFA = false;

lang?.addEventListener("click",()=>{
isFA = !isFA;
lang.innerText = isFA ? "EN" : "FA";
document.querySelectorAll(".fa").forEach(el=>{
el.style.display = isFA ? "block" : "none";
});
});
