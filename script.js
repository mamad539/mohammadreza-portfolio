const langBtn = document.getElementById("langBtn");
const menu = document.getElementById("menu");
const burger = document.getElementById("burger");

let lang = "en";

const dict = {
en:{
home:"Home",
about:"About",
projects:"Projects",
contact:"Contact",
title:"Full Stack Web Developer",
subtitle:"Building fast, scalable & modern web apps",
about_en:"I am a full-stack developer focused on modern scalable apps.",
about_fa:"من یک توسعه‌دهنده فول استک هستم که روی ساخت سیستم‌های مدرن تمرکز دارم."
},
fa:{
home:"خانه",
about:"درباره",
projects:"پروژه‌ها",
contact:"تماس",
title:"توسعه‌دهنده فول استک",
subtitle:"ساخت اپلیکیشن‌های سریع و مدرن",
about_en:"I am a full-stack developer focused on modern scalable apps.",
about_fa:"من یک توسعه‌دهنده فول استک هستم که روی ساخت سیستم‌های مدرن تمرکز دارم."
}
};

langBtn.onclick=()=>{
lang = lang==="en"?"fa":"en";
langBtn.innerText = lang==="en"?"FA":"EN";

document.querySelectorAll("[data-i18n]").forEach(el=>{
let key = el.getAttribute("data-i18n");
if(dict[lang][key]) el.innerText = dict[lang][key];
});
};

burger.onclick=()=>{
menu.classList.toggle("active");
};

/* smooth scroll feel */
document.querySelectorAll("a").forEach(a=>{
a.addEventListener("click",()=>{
menu.classList.remove("active");
});
});
