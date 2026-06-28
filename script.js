/* ==========================================
   Mohammadreza Portfolio
========================================== */

/* Loader */

window.addEventListener("load", () => {
    const loader = document.getElementById("loader");

    setTimeout(() => {
        loader.style.opacity = "0";
        loader.style.visibility = "hidden";
    }, 1200);
});

/* ==========================================
   Cursor
========================================== */

const cursor = document.getElementById("cursor");

let mouseX = 0;
let mouseY = 0;

document.addEventListener("mousemove", (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
});

function animateCursor() {

    cursor.style.left = mouseX + "px";
    cursor.style.top = mouseY + "px";

    requestAnimationFrame(animateCursor);
}

animateCursor();

/* Hover Effect */

document.querySelectorAll("a,button,.skill,.project-card").forEach(item => {

    item.addEventListener("mouseenter", () => {

        cursor.style.width = "55px";
        cursor.style.height = "55px";
        cursor.style.borderColor = "#06B6D4";

    });

    item.addEventListener("mouseleave", () => {

        cursor.style.width = "22px";
        cursor.style.height = "22px";
        cursor.style.borderColor = "#8B5CF6";

    });

});

/* ==========================================
   Navbar
========================================== */

const navbar = document.querySelector(".navbar");

window.addEventListener("scroll", () => {

    if(window.scrollY > 80){

        navbar.style.height = "65px";
        navbar.style.background = "rgba(8,10,20,.75)";
        navbar.style.backdropFilter = "blur(30px)";

    }else{

        navbar.style.height = "75px";
        navbar.style.background = "rgba(255,255,255,.05)";

    }

});

/* ==========================================
   Reveal Animation
========================================== */

const observer = new IntersectionObserver((entries)=>{

entries.forEach(entry=>{

if(entry.isIntersecting){

entry.target.style.opacity="1";

entry.target.style.transform="translateY(0)";

}

});

},{
threshold:.15
});

document.querySelectorAll("section").forEach(section=>{

section.style.opacity="0";
section.style.transform="translateY(70px)";
section.style.transition=".8s";

observer.observe(section);

});

/* ==========================================
   Project Tilt
========================================== */

document.querySelectorAll(".project-card").forEach(card=>{

card.addEventListener("mousemove",(e)=>{

const rect = card.getBoundingClientRect();

const x = e.clientX - rect.left;
const y = e.clientY - rect.top;

const rotateY = ((x / rect.width)-0.5)*20;
const rotateX = ((y / rect.height)-0.5)*-20;

card.style.transform = `
perspective(1000px)
rotateX(${rotateX}deg)
rotateY(${rotateY}deg)
translateY(-10px)
`;

});

card.addEventListener("mouseleave",()=>{

card.style.transform="perspective(1000px) rotateX(0) rotateY(0)";

});

});

/* ==========================================
   THREE.JS
========================================== */

const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(
75,
window.innerWidth/window.innerHeight,
0.1,
1000
);

const renderer = new THREE.WebGLRenderer({
alpha:true,
antialias:true
});

renderer.setSize(window.innerWidth,window.innerHeight);

document.getElementById("webgl").appendChild(renderer.domElement);

const geometry = new THREE.BufferGeometry();

const vertices=[];

for(let i=0;i<2500;i++){

vertices.push((Math.random()-0.5)*20);
vertices.push((Math.random()-0.5)*20);
vertices.push((Math.random()-0.5)*20);

}

geometry.setAttribute(
'position',
new THREE.Float32BufferAttribute(vertices,3)
);

const material = new THREE.PointsMaterial({

color:0x8B5CF6,
size:0.03

});

const stars = new THREE.Points(geometry,material);

scene.add(stars);

camera.position.z=6;

function animate(){

requestAnimationFrame(animate);

stars.rotation.x +=0.0003;
stars.rotation.y +=0.0006;

renderer.render(scene,camera);

}

animate();

window.addEventListener("resize",()=>{

camera.aspect=window.innerWidth/window.innerHeight;

camera.updateProjectionMatrix();

renderer.setSize(window.innerWidth,window.innerHeight);

});/* ===========================
   LANGUAGE SYSTEM
=========================== */

const translations = {

en:{

home:"Home",
about:"About",
skills:"Skills",
projects:"Projects",
contact:"Contact",
hire:"Hire Me",

hello:"Hello I'm",

job:"Full Stack Developer",

hero:"I build modern websites, web apps and beautiful user experiences with clean code.",

projectsBtn:"View Projects",

cv:"Download CV",

cardTitle:"Creative Developer",

aboutTitle:"About Me",

aboutText:"I'm passionate about building fast, beautiful and scalable web applications.",

skillsTitle:"Skills",

projectsTitle:"Projects",

contactTitle:"Let's Work Together",

send:"Send Message",

name:"Name",

email:"Email",

message:"Message",

footer:"© 2026 Mohammadreza Portfolio"

},

fa:{

home:"خانه",

about:"درباره من",

skills:"مهارت‌ها",

projects:"پروژه‌ها",

contact:"تماس",

hire:"استخدام من",

hello:"سلام، من",

job:"برنامه نویس فول استک",

hero:"من وب سایت های مدرن، سریع و حرفه ای طراحی و توسعه می دهم.",

projectsBtn:"مشاهده پروژه ها",

cv:"دانلود رزومه",

cardTitle:"توسعه دهنده خلاق",

aboutTitle:"درباره من",

aboutText:"علاقه مند به ساخت وب سایت های سریع، مدرن و مقیاس پذیر هستم.",

skillsTitle:"مهارت ها",

projectsTitle:"پروژه ها",

contactTitle:"همکاری با من",

send:"ارسال پیام",

name:"نام",

email:"ایمیل",

message:"پیام",

footer:"© ۲۰۲۶ محمدرضا"

}

};

let currentLang = localStorage.getItem("lang") || "en";/* ==========================================
   LANGUAGE SYSTEM (PART 2) & CONTACT FORM
========================================== */

// تابع اصلی برای اعمال زبان، راست‌چین کردن و تغییر فونت پورتفولیو
function setLanguage(lang) {
    currentLang = lang;
    localStorage.setItem("lang", lang);
    const isFa = lang === "fa";

    // ۱. تنظیم جهت صفحه (RTL/LTR) و فونت متناسب با زبان
    document.body.style.direction = isFa ? "rtl" : "ltr";
    document.body.style.fontFamily = isFa ? "'Vazirmatn', sans-serif" : "'Space Grotesk', sans-serif";

    // ۲. تغییر متن دکمه سوئیچ زبان
    const langToggleBtn = document.getElementById("langToggle");
    if(langToggleBtn) {
        langToggleBtn.innerText = isFa ? "EN English" : "🇮🇷 فارسی";
    }

    // ۳. ترجمه منوی ناوبری (Navbar)
    document.getElementById("nav-home").innerText = translations[lang].home;
    document.getElementById("nav-about").innerText = translations[lang].about;
    document.getElementById("nav-skills").innerText = translations[lang].skills;
    document.getElementById("nav-projects").innerText = translations[lang].projects;
    document.getElementById("nav-contact").innerText = translations[lang].contact;
    document.getElementById("hire-btn").innerText = translations[lang].hire;

    // ۴. ترجمه بخش هیرو (Hero Section)
    document.getElementById("hello").innerText = translations[lang].hello;
    document.getElementById("job-title").innerText = translations[lang].job;
    document.getElementById("hero-text").innerText = translations[lang].hero;
    document.getElementById("projects-btn").innerText = translations[lang].projectsBtn;
    document.getElementById("cv-btn").innerText = translations[lang].cv;
    document.getElementById("card-title").innerText = translations[lang].cardTitle;

    // ۵. ترجمه بخش درباره من (About)
    document.getElementById("about-title").innerText = translations[lang].aboutTitle;
    document.getElementById("about-text").innerText = translations[lang].aboutText;

    // ۶. ترجمه عناوین اصلی بخش‌ها
    document.getElementById("skills-title").innerText = translations[lang].skillsTitle;
    document.getElementById("projects-title").innerText = translations[lang].projectsTitle;
    document.getElementById("contact-title").innerText = translations[lang].contactTitle;

    // ۷. ترجمه پِلیس‌هولدرها و دکمه فرم تماس
    document.getElementById("send-btn").innerText = translations[lang].send;
    document.getElementById("name-input").placeholder = translations[lang].name;
    document.getElementById("email-input").placeholder = translations[lang].email;
    document.getElementById("message-input").placeholder = translations[lang].message;

    // ۸. ترجمه متن فوتر
    document.getElementById("footer-text").innerText = translations[lang].footer;
}

// رویداد کلیک دکمه تغییر زبان
const langBtn = document.getElementById("langToggle");
if(langBtn) {
    langBtn.addEventListener("click", () => {
        const newLang = currentLang === "en" ? "fa" : "en";
        setLanguage(newLang);
    });
}

// اجرای اولیه برای خواندن زبان ذخیره شده کاربر
setLanguage(currentLang);


// ==========================================
// CONTACT FORM AJAX SUBMIT (ارسال فرم به بک‌اند)
// ==========================================
const contactForm = document.querySelector("#contact form");
if(contactForm) {
    contactForm.addEventListener("submit", (e) => {
        e.preventDefault(); // جلوگیری از رفرش شدن ناگهانی صفحه
        
        const name = document.getElementById("name-input").value;
        const email = document.getElementById("email-input").value;
        const message = document.getElementById("message-input").value;
        const sendBtn = document.getElementById("send-btn");

        // غیرفعال کردن دکمه جهت جلوگیری از ارسال چندباره پیام پشت سر هم
        sendBtn.disabled = true;
        sendBtn.innerText = currentLang === "fa" ? "در حال ارسال..." : "Sending...";

        // آماده‌سازی داده‌ها برای ارسال به PHP
        const formData = new FormData();
        formData.append("name", name);
        formData.append("email", email);
        formData.append("message", message);

        // ارسال درخواست AJAX به فایل send.php
        fetch("send.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message); // نمایش پیام پاسخ سرور به کاربر
            if(data.status === "success") {
                contactForm.reset(); // پاک کردن فرم در صورت موفقیت‌آمیز بودن ثبت پیام
            }
        })
        .catch(() => {
            alert(currentLang === "fa" ? "خطایی در اتصال به سرور رخ داد!" : "An error occurred while connecting to the server!");
        })
        .finally(() => {
            // فعال‌سازی مجدد دکمه پس از اتمام فرآیند
            sendBtn.disabled = false;
            sendBtn.innerText = translations[currentLang].send;
        });
    });
}
