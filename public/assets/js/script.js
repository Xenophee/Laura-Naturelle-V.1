

fetch('/controllers/ajax/alert_modal.php')
    .then(response => {
        return (response.json())
    })
    .then(displayModal => {

        const alertModalElement = document.getElementById('staticBackdrop');

        if (displayModal && alertModalElement != undefined) {
            const alertModal = new bootstrap.Modal(alertModalElement);
            alertModal.show();
        };
    });




const dropdown = document.querySelector('.drop-menu');
const links = dropdown.querySelector('.drop-links');


if (window.innerWidth >= 1200) {

    let timeoutId;

    dropdown.addEventListener('mouseenter', () => {
        clearTimeout(timeoutId); // Annuler tout délai en cours
        links.classList.remove('d-none');
    });

    dropdown.addEventListener('mouseleave', () => {
        // Cacher le contenu après un délai de 350 millisecondes
        timeoutId = setTimeout(() => {
            links.classList.add('d-none');
        }, 350);
    });

} else {

    dropdown.addEventListener('click', (event) => {
        if (event.target.classList.contains('header-link')) {
            event.preventDefault();
            links.classList.toggle('d-none');
        };
    });

};


const genderCategory = document.querySelectorAll('.gender-category');
const female = document.getElementById('female');
const male = document.getElementById('male');

const displayBlock = (event) => {

    for (const category of genderCategory) {
        category.classList.remove('active');
    };

    event.target.classList.add('active');

    if (event.target == genderCategory[1]) {
        male.classList.remove('d-none');
        female.classList.add('d-none');
    } else {
        female.classList.remove('d-none');
        male.classList.add('d-none');
    };
};

if (genderCategory != null) {
    for (const category of genderCategory) {
        category.addEventListener('click', displayBlock);
    };
};