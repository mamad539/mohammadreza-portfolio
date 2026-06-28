const cursor = document.querySelector(".cursor");

document.addEventListener("mousemove",(e)=>{
cursor.style.left = e.clientX + "px";
cursor.style.top = e.clientY + "px";
});

/* parallax mouse effect */
document.addEventListener("mousemove",(e)=>{
document.querySelectorAll(".blob").forEach(blob=>{
const speed = 0.02;
const x = (window.innerWidth - e.pageX)*speed;
const y = (window.innerHeight - e.pageY)*speed;
blob.style.transform = `translate(${x}px, ${y}px)`;
});
});

/* smooth reveal */
const observer = new IntersectionObserver(entries=>{
entries.forEach(entry=>{
if(entry.isIntersecting){
entry.target.style.opacity = 1;
entry.target.style.transform = "translateY(0)";
}
});
});

document.querySelectorAll(".card, h2, p").forEach(el=>{
el.style.opacity = 0;
el.style.transform = "translateY(30px)";
el.style.transition = "0.6s";
observer.observe(el);
});
