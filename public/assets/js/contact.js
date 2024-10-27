

import { checkInput, checkNumbers, checkRadio, errorDisplay, errorRemove, errorMessage, counterLenght, checkTextarea } from './form.js';


const sendBtn = document.querySelector('button[type="submit"]');
const civilities = document.querySelectorAll('input[name="civility"]');

const REGEX_TEXT = new RegExp(lastname.pattern);
const REGEX_EMAIL = new RegExp(email.pattern);


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION DU FORMULAIRE


// -------------------------------------------------
// VÉRIFICATION DU NOM

lastname.addEventListener('change', () => {
    checkInput(lastname, 'votre nom', REGEX_TEXT);
});

// -------------------------------------------------
// VÉRIFICATION DU PRENOM

firstname.addEventListener('change', () => {
    checkInput(firstname, 'votre prénom', REGEX_TEXT);
});

// -------------------------------------------------
// VÉRIFICATION DU MAIL

email.addEventListener('change', () => {
    checkInput(email, 'votre adresse mail', REGEX_EMAIL);
});

// -------------------------------------------------
// VÉRIFICATION DE L'OBJET

object.addEventListener('change', () => {
    checkNumbers(object, 'un objet', [1, 2, 3, 4]);
});

// -------------------------------------------------
// VÉRIFICATION DU TEXTAREA

request.addEventListener('change', () => {
    checkTextarea(request, 'Veuillez saisir votre message.');
});



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION SUPPLÉMENTAIRE SUR LE CLICK DU BOUTON POUR L'UX UTILISATEUR

sendBtn.addEventListener('click', () => {
    checkRadio(civilities, 'une civilité', civilityError);
    checkInput(lastname, 'votre nom', REGEX_TEXT);
    checkInput(firstname, 'votre prénom', REGEX_TEXT);
    checkInput(email, 'votre adresse mail', REGEX_EMAIL);
    checkNumbers(object, 'un objet', [1, 2, 3, 4]);
    checkTextarea(request, 'Veuillez saisir votre message.');
});