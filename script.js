const cursor = document.getElementById("cursor");

/* custom cursor */
document.addEventListener("mousemove",(e)=>{
cursor.style.left = e.clientX + "px";
cursor.style.top = e.clientY + "px";
});

/* THREE.JS BACKGROUND */
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);

const renderer = new THREE.WebGLRenderer({alpha:true});
renderer.setSize(window.innerWidth, window.innerHeight);
document.getElementById("webgl").appendChild(renderer.domElement);

const geometry = new THREE.BufferGeometry();
const vertices = [];

for(let i=0;i<500;i++){
vertices.push((Math.random()-0.5)*10);
vertices.push((Math.random()-0.5)*10);
vertices.push((Math.random()-0.5)*10);
}

geometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices,3));

const material = new THREE.PointsMaterial({color:0x7c3aed,size:0.02});
const points = new THREE.Points(geometry, material);

scene.add(points);
camera.position.z = 5;

function animate(){
requestAnimationFrame(animate);
points.rotation.y += 0.001;
points.rotation.x += 0.0005;
renderer.render(scene,camera);
}
animate();

/* resize */
window.addEventListener("resize",()=>{
camera.aspect = window.innerWidth/window.innerHeight;
camera.updateProjectionMatrix();
renderer.setSize(window.innerWidth, window.innerHeight);
});
