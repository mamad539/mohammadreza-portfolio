const translations = {
  en: {
    nav_home: "Home",
    nav_about: "About",
    nav_projects: "Projects",
    nav_contact: "Contact",

    hero_title: "Full Stack Web Developer",
    hero_subtitle: "Building scalable, modern, high-performance web applications",
    btn_projects: "View Projects",
    btn_contact: "Contact Me",

    about_title: "About Me",
    about_en: "I am a full-stack web developer focused on building scalable, modern, and user-friendly web applications.",
    about_fa: "من یک توسعه‌دهنده فول استک هستم که روی ساخت وب‌سایت‌های مدرن، سریع و مقیاس‌پذیر تمرکز دارم.",

    skills_title: "Skills",
    projects_title: "Projects",
    services_title: "Services",
    collab_title: "Let’s Work Together",
    contact_title: "Contact",

    p1_title: "E-commerce Platform",
    p1_desc: "Full online store system with cart and payment.",
    p2_title: "Personal Blog System",
    p2_desc: "SEO optimized blogging platform.",
    p3_title: "Admin Dashboard",
    p3_desc: "Powerful analytics dashboard UI.",

    s1: "Web Development",
    s2: "Backend Development",
    s3: "UI Optimization"
  },

  fa: {
    nav_home: "خانه",
    nav_about: "درباره من",
    nav_projects: "پروژه‌ها",
    nav_contact: "تماس",

    hero_title: "توسعه‌دهنده فول استک وب",
    hero_subtitle: "ساخت وب‌اپلیکیشن‌های مدرن، سریع و مقیاس‌پذیر",
    btn_projects: "مشاهده پروژه‌ها",
    btn_contact: "تماس با من",

    about_title: "درباره من",
    about_en: "I am a full-stack web developer focused on building scalable, modern, and user-friendly web applications.",
    about_fa: "من یک توسعه‌دهنده فول استک هستم که روی ساخت وب‌سایت‌های مدرن، سریع و مقیاس‌پذیر تمرکز دارم.",

    skills_title: "مهارت‌ها",
    projects_title: "پروژه‌ها",
    services_title: "خدمات",
    collab_title: "بیا با هم کار کنیم",
    contact_title: "تماس",

    p1_title: "پلتفرم فروشگاهی",
    p1_desc: "سیستم فروشگاه آنلاین با سبد خرید و پرداخت.",
    p2_title: "سیستم وبلاگ شخصی",
    p2_desc: "وبلاگ بهینه شده برای سئو.",
    p3_title: "داشبورد مدیریتی",
    p3_desc: "رابط کاربری حرفه‌ای برای تحلیل داده‌ها.",

    s1: "توسعه وب",
    s2: "توسعه بک‌اند",
    s3: "بهینه‌سازی UI"
  }
};

let currentLang = "en";

const toggleBtn = document.getElementById("langToggle");

function updateLanguage(lang){
  document.querySelectorAll("[data-i18n]").forEach(el=>{
    const key = el.getAttribute("data-i18n");
    if(translations[lang][key]){
      el.textContent = translations[lang][key];
    }
  });

  document.documentElement.lang = lang;
  toggleBtn.textContent = lang === "en" ? "FA" : "EN";
  currentLang = lang;
}

toggleBtn.addEventListener("click", ()=>{
  updateLanguage(currentLang === "en" ? "fa" : "en");
});

/* smooth UX micro animation */
document.addEventListener("scroll", ()=>{
  document.querySelectorAll(".card").forEach(card=>{
    const rect = card.getBoundingClientRect();
    if(rect.top < window.innerHeight - 100){
      card.style.opacity = 1;
      card.style.transform = "translateY(0)";
    }
  });
});