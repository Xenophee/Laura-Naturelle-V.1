

import { checkInput, checkNumbers, checkRadio, errorDisplay, errorRemove, errorMessage, counterLenght, checkTextarea } from './form.js';

const REGEX_TEXT = new RegExp(title.pattern);

const textarea = document.querySelector('textarea');
const maxChar = counterChar.textContent;

const darkmodeBtns = document.querySelectorAll('input[name="darkmode"]');
const viewBtns = document.querySelectorAll('input[name="view"]');
const validBtn = document.querySelector('button[type="submit"]');



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VISUALISATION DE L'IMAGE DANS UN INPUT FILE

const coverInput = document.getElementById('cover');
const coverPreview = document.querySelector('.cover');

if (coverInput != undefined) {
    
    coverInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
        const reader = new FileReader();
        reader.addEventListener('load', () => {
            coverPreview.setAttribute('src', reader.result);
        });
        reader.readAsDataURL(file);
        };
    });
};
// ----------------------------------------------------------------------



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// COMPTAGE DES CARACTÈRES DANS LE TEXTAREA

// Fait le décompte du nombre de caractères sur le textarea et affiche le message d'erreur
textarea.addEventListener('input', () => {
    counterLenght(textarea, maxChar);
});

// Appel de la fonction de comptage au démarrage pour pallier les cas de modification
counterLenght(textarea, maxChar);
// ----------------------------------------------------------------------



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION DU FORMULAIRE

title.addEventListener('change', () => {
    checkInput(title, 'un nom de catégorie', REGEX_TEXT);
});


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION AU CLICK DE VALIDATION

validBtn.addEventListener('click', () => {

    if (coverInput.files.length === 0) {
        errorDisplay(cover);
        errorMessage(cover, 'une image de couverture', true);
    } else {
        errorRemove(cover);
    };

    checkRadio(darkmodeBtns, 'un mode d\'affichage du texte', darkmodeError);
    checkInput(title, 'un nom de catégorie', REGEX_TEXT);
    checkRadio(viewBtns, 'un mode d\'affichage pour les prestations', viewError);
});