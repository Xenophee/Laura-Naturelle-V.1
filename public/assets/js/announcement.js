


import { checkInput, checkTextarea, errorDisplay, errorRemove, errorMessage, counterLenght } from './form.js';

const REGEX_DATE = new RegExp(startDate.pattern);

const textarea = document.querySelector('textarea');
const textareaBtn = document.querySelector('.formatting');
const maxChar = counterChar.textContent;

const validBtn = document.querySelector('button[type="submit"]');


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// MISE À JOUR DE L'APERÇU EN FONCTION DU TEXTAREA

// Fonction qui transpose le contenu du textarea dans l'aperçu
const previewText = () => {
    preview.innerHTML = textarea.value;
};

// Appel de la fonction en cas de changement dans le textarea
textarea.addEventListener('input', () => {
    previewText();
});

// Appel de la fonction au démarrage de la page pour mettre en place l'aperçu immédiatement
previewText();
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
// MODIFICATION DU CONTENU DU TEXTAREA EN METTANT LE MORCEAU SURLIGNE EN VALEUR

textareaBtn.addEventListener('click', () => {
    // Sélection des morceaux de texte (le surlignement, avant et après le surlignement)
    const selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd);
    const textBefore = textarea.value.substring(0, textarea.selectionStart);
    const textAfter = textarea.value.substring(textarea.selectionEnd);

    // Ajout des balises span au texte sélectionné par l'utilisateur
    let newText = `<span>${selectedText}</span>`;

    // Remise en place de l'ensemble du texte dans le textarea et dans la prévisualisation
    textarea.value = textBefore + newText + textAfter;
    preview.innerHTML = textBefore + newText + textAfter;

    // Rappel de la fonction de comptage pour prendre en compte les nouvelles balises span
    counterLenght(textarea, maxChar);
});
// ----------------------------------------------------------------------



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// AJUSTEMENT SUR LA MODAL

// ----------------------------------------------------------------------
// En cas d'annulation de la modal, retour du check sur le bouton modifier
displayModal.addEventListener('hidden.bs.modal', () => {
    const modify = document.getElementById('modify');
    if (modify != null) {
        modify.checked = true;
    };
});
// ----------------------------------------------------------------------


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION DU FORMULAIRE


content.addEventListener('input', () => {
    checkTextarea(content, 'Veuillez saisir le contenu de l\'annonce.');
});

startDate.addEventListener('input', () => {
    checkInput(startDate, 'une date', REGEX_DATE);
});

endDate.addEventListener('input', () => {
    checkInput(endDate, 'une date', REGEX_DATE);
});

// ----------------------------------------------------------------------


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION AU CLICK DE VALIDATION

validBtn.addEventListener('click', () => {
    checkTextarea(content, 'Veuillez saisir le contenu de l\'annonce.');
    checkInput(startDate, 'une date', REGEX_DATE);
    checkInput(endDate, 'une date', REGEX_DATE);
});