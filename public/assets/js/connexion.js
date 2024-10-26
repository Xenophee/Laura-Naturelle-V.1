

import { checkInput, checkTextarea, errorDisplay, errorRemove, errorMessage, counterLenght } from './form.js';


const REGEX_EMAIL = new RegExp(email.pattern);

const validBtn = document.querySelector('button[type="submit"]');



email.addEventListener('change', () => {
    checkInput(email, 'votre adresse mail', REGEX_EMAIL);
});

password.addEventListener('change', () => {
    checkInput(password, 'votre mot de passe');
});

// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION AU CLICK DE VALIDATION

validBtn.addEventListener('click', () => {
    checkInput(email, 'votre adresse mail', REGEX_EMAIL);
    checkInput(password, 'votre mot de passe');
});