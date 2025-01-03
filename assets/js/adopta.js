const navbarMenu = document.querySelector(".navbar .links");
const hamburgerBtn = document.querySelector(".hamburger-btn");
const hideMenuBtn = navbarMenu.querySelector(".close-btn");
const showPopupBtn = document.querySelector(".login-btn");
const formPopup = document.querySelector(".form-popup");
const hidePopupBtn = formPopup.querySelector(".close-btn");
const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");

// Show mobile menu
hamburgerBtn.addEventListener("click", () => {
    navbarMenu.classList.toggle("show-menu");
});

// Hide mobile menu
hideMenuBtn.addEventListener("click", () =>  hamburgerBtn.click());

// Show login popup
showPopupBtn.addEventListener("click", () => {
    document.body.classList.toggle("show-popup");
});

// Hide login popup
hidePopupBtn.addEventListener("click", () => showPopupBtn.click());

// Show or hide signup form
signupLoginLink.forEach(link => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        formPopup.classList[link.id === 'signup-link' ? 'add' : 'remove']("show-signup");
    });
});

const carouselWrapper = document.querySelector(".carousel-wrapper");
const carousel = carouselWrapper.querySelector(".carousel");
const firstCardWidth = carousel.querySelector(".card").offsetWidth;
const arrowBtns = carouselWrapper.querySelectorAll(".carousel-wrapper i");
const carouselChildrens = [...carousel.children];

let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;

// Get the number of cards that can fit in the carousel at once
let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);

// Insert copies of the last few cards to beginning of carousel for infinite scrolling
carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
    carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
});

// Insert copies of the first few cards to end of carousel for infinite scrolling
carouselChildrens.slice(0, cardPerView).forEach(card => {
    carousel.insertAdjacentHTML("beforeend", card.outerHTML);
});

// Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
carousel.classList.add("no-transition");
carousel.scrollLeft = carousel.offsetWidth;
carousel.classList.remove("no-transition");

// Add event listeners for the arrow buttons to scroll the carousel left and right
arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
    });
});

const dragStart = (e) => {
    isDragging = true;
    carousel.classList.add("dragging");
    // Records the initial cursor and scroll position of the carousel
    startX = e.pageX;
    startScrollLeft = carousel.scrollLeft;
}

const dragging = (e) => {
    if(!isDragging) return; // if isDragging is false return from here
    // Updates the scroll position of the carousel based on the cursor movement
    carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
}

const dragStop = () => {
    isDragging = false;
    carousel.classList.remove("dragging");
}

const infiniteScroll = () => {
    // If the carousel is at the beginning, scroll to the end
    if(carousel.scrollLeft === 0) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
        carousel.classList.remove("no-transition");
    }
    // If the carousel is at the end, scroll to the beginning
    else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");
    }

    // Clear existing timeout & start autoplay if mouse is not hovering over carousel
    clearTimeout(timeoutId);
    if(!carouselWrapper.matches(":hover")) autoPlay();
}

const autoPlay = () => {
    if(window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
    // Autoplay the carousel after every 2500 ms
    timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 2500);
}
autoPlay();

carousel.addEventListener("mousedown", dragStart);
carousel.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);
carousel.addEventListener("scroll", infiniteScroll);
carouselWrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
carouselWrapper.addEventListener("mouseleave", autoPlay);

window.addEventListener('DOMContentLoaded', () => {
const posts = document.querySelectorAll('.posts .post');
const breakPoint = 3; // Cambia este valor según cuántos contenedores deseas tener por fila antes de que uno baje.

window.addEventListener('resize', () => {
    rearrangePosts();
});

rearrangePosts();

function rearrangePosts() {
    if (window.innerWidth > 768) { // Solo realiza el ajuste si la pantalla es más grande que 768px
        let rowCounter = 0;
        posts.forEach((post, index) => {
            if (index % breakPoint === 0 && index !== 0) {
                rowCounter++;
            }
            post.style.gridColumnStart = (index % breakPoint) + 1;
            post.style.gridRowStart = rowCounter + 1;
        });
    } else {
        posts.forEach(post => {
            post.style.gridColumnStart = 'auto';
            post.style.gridRowStart = 'auto';
        });
    }
}
});

function changeCategory(category) {
    var posts = document.querySelectorAll('.post');
    posts.forEach(function(post) {
        if (category === 'TODOS' || post.dataset.category === category) {
            post.style.display = 'block';
        } else {
            post.style.display = 'none';
        }
    });

    var labels = document.querySelectorAll('.container-category label');
    labels.forEach(function(label) {
        if (label.getAttribute('for') === category) {
            label.classList.add('active');
        } else {
            label.classList.remove('active');
        }
    });
}
function ordenarPosts(criterio) {
    var posts = Array.from(document.querySelectorAll('.post'));
    
    console.log('Criterio seleccionado:', criterio);
    console.log('Número de posts encontrados:', posts.length);
    posts.forEach(post => {
        console.log('Post ID:', post.dataset.idMascota);
    });

    posts.sort(function(a, b) {
        var nombreA = a.querySelector('.overlay h3').innerText.toUpperCase();
        var nombreB = b.querySelector('.overlay h3').innerText.toUpperCase();
        var idA = parseInt(a.dataset.idMascota, 10);
        var idB = parseInt(b.dataset.idMascota, 10);

        console.log('Comparando ' + idA + ' con ' + idB + ' para criterio ' + criterio);

        if (criterio === 'nombre-az') {
            return nombreA.localeCompare(nombreB);
        } else if (criterio === 'nombre-za') {
            return nombreB.localeCompare(nombreA);
        } else if (criterio === 'nuevo') {
            return idB - idA;  // Ordenar por id_mascota de forma descendente
        }
    });

    var container = document.querySelector('.posts');
    container.innerHTML = '';
    posts.forEach(function(post) {
        container.appendChild(post);
    });
    console.log('Posts ordenados y reinsertados en el DOM');
}