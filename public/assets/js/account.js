
import { checkInput, errorDisplay, errorRemove, errorMessage, counterLenght } from './form.js';



const REGEX_EMAIL = new RegExp(email.pattern);
const REGEX_PHONE = new RegExp(phone.pattern);
const REGEX_ADDRESS = new RegExp(address.pattern);
const REGEX_ZIPCODE = new RegExp(zipcode.pattern);
const REGEX_CITY = new RegExp(city.pattern);
const REGEX_PASSWORD = new RegExp(newPassword.pattern);

const validBtn = document.querySelector('button[type="submit"]');


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE VÉRIFICATION SUR LE MOT DE PASSE

const checkPassword = () => {
    if (newPassword.value != '') {

        if (newPassword.value != confirmPassword.value) {
            errorDisplay(confirmPassword);
            confirmPasswordError.textContent = 'Les deux mots de passe ne sont pas identiques.'
        } else {
            errorRemove(confirmPassword);
        };

        if (password.value == '') {
            errorDisplay(password);
            passwordError.textContent = 'Veuillez renseigner votre mot de passe actuel.'
        } else {
            errorRemove(password);
        };

    } else {
        errorRemove(confirmPassword);
    };
};



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// ÉVÉNEMENTS SUR LE FORMULAIRE

email.addEventListener('change', () => {
    checkInput(email, 'une adresse mail', REGEX_EMAIL);
});

phone.addEventListener('change', () => {
    checkInput(phone, 'un numéro de téléphone', REGEX_PHONE);
});

address.addEventListener('change', () => {
    checkInput(address, 'une adresse', REGEX_ADDRESS);
});

zipcode.addEventListener('change', () => {
    checkInput(zipcode, 'un code postal', REGEX_ZIPCODE);
});

city.addEventListener('change', () => {
    checkInput(city, 'une ville', REGEX_CITY);
});

newPassword.addEventListener('change', () => {
    checkInput(newPassword, 'un mot de passe', REGEX_PASSWORD);
});

confirmPassword.addEventListener('change', checkPassword);


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION AU CLICK DE VALIDATION

validBtn.addEventListener('click', () => {
    checkInput(email, 'une adresse mail', REGEX_EMAIL);
    checkInput(phone, 'un numéro de téléphone', REGEX_PHONE);
    checkInput(address, 'une adresse', REGEX_ADDRESS);
    checkInput(zipcode, 'un code postal', REGEX_ZIPCODE);
    checkInput(city, 'une ville', REGEX_CITY);
    checkInput(newPassword, 'un mot de passe', REGEX_PASSWORD);
    checkPassword();
});