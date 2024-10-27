
// ==================================================================================================================================
// ----------------------------------------------------------------------------------------------------------------------------------
// AFFICHAGE DE LA CARTE

const latitude = 49.83763;
const longitude = 3.26675;

var map = L.map('map').setView([latitude, longitude], 16);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([latitude, longitude]).addTo(map)
    .bindPopup('L\'aura Natur\'elle.')
    .openPopup();



// ==================================================================================================================================
// ----------------------------------------------------------------------------------------------------------------------------------
// MODIFICATION DYNAMIQUE DES IMAGES DE PRESTATIONS



const image = document.querySelector('.services-index-img');
const text = document.querySelector('.prestations-text-index');
const btn = document.querySelector('.btn-services-index');
const source = document.querySelector('#diapo source');
const img = document.querySelector('#diapo img');




if (window.innerWidth >= 768) {

    fetch('/controllers/ajax/get_categories.php')
        .then(response => {
            return (response.json())
        })
        .then(categories => {

            // Fonction pour changer l'image toutes les X millisecondes
            const changeImage = () => {

                text.classList.remove('lightmode');
                btn.classList.remove('lightmode');

                image.style.opacity = 0;

                setTimeout(() => {

                    let linkImg = '../public/uploads/categories/';

                    currentIndex = (currentIndex + 1) % categories.length;

                    source.srcset = linkImg + `${categories[currentIndex].id_category}-xl.webp`;
                    img.src = linkImg + `${categories[currentIndex].id_category}.webp`;

                    image.style.opacity = 1;

                    if (categories[currentIndex].darkmode == false) {
                        text.classList.add('lightmode');
                        btn.classList.add('lightmode');
                    }
                }, 1000);
            };


            let currentIndex = 0; // Index de l'image suivante à afficher

            // Lancement de l'animation uniquement pour les formats tablettes et supérieurs
            if (categories.length != 0) {
                // 1000 = 1s
                setInterval(changeImage, 8000);
            };
        });
};







// ==================================================================================================================================
// ----------------------------------------------------------------------------------------------------------------------------------
// CHANGEMENT DE L'IMAGE AU SURVOL SUR LA CARTE DE FIDÉLITÉ


const fidelitySource = document.querySelector('.fidelity-img source');
const fidelityImg = document.querySelector('.fidelity-img img');


fidelityImg.addEventListener('mouseover', () => {
    fidelitySource.srcset = '/public/assets/img/illustrations/others/carte-xl.webp';
    fidelityImg.src = '/public/assets/img/illustrations/others/carte.webp';
});

fidelityImg.addEventListener('mouseleave', () => {
    fidelitySource.srcset = '/public/assets/img/illustrations/others/carte-xl-verso.webp';
    fidelityImg.src = '/public/assets/img/illustrations/others/carte-verso.webp';
});

