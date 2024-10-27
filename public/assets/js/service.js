

import { checkInput, checkNumbers, checkRadio, errorDisplay, errorRemove, errorMessage, counterLenght, checkTextarea } from './form.js';


const REGEX_TEXT = new RegExp(title.pattern);
const REGEX_DATE = new RegExp(startExclusiveDate.pattern);

const textarea = document.querySelector('textarea');
const value = Number(counterChar.textContent);

const dates = document.querySelector('.exclusive-dates');
const inputDates = document.querySelectorAll('.exclusive-dates .form-control');

const genderBtns = document.querySelectorAll('input[name="gender"]');
const packageBtns = document.querySelectorAll('input[name="package"]');
const exclusiveBtns = document.querySelectorAll('input[name="exclusive"]');

const validBtn = document.querySelector('button[type="submit"]');


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// Fait le décompte du nombre de caractères sur le textarea et affiche le message d'erreur
textarea.addEventListener('input', () => {
    counterLenght(textarea, value);
});

// Appel de la fonction de comptage au démarrage pour pallier les cas de modification
counterLenght(textarea, value);
// ----------------------------------------------------------------------



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// Affiche les dates à enregistrer en cas de prestation spéciale et les rends obligatoire

const displayDates = () => {

    for (const type of exclusiveBtns) {

        if (type.checked && type.value == 1) {

            dates.classList.remove('d-none');
            for (const inputDate of inputDates) {
                inputDate.required = true;
            };

        } else {

            dates.classList.add('d-none');
            for (const inputDate of inputDates) {
                inputDate.required = false;
            };
        };
    };

};


displayDates();


for (const type of exclusiveBtns) {
    type.addEventListener('click', displayDates);
};
// ----------------------------------------------------------------------



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// Supprime une tarification

const deleteClone = () => {

    let count = document.querySelectorAll('.pricing').length;

    count--;

    if (count == 1) {
        deletePricing.classList.add('d-none');
    };

    addError.classList.add('d-none');

    let toDelete = document.querySelector('.pricing:last-child');
    toDelete.remove();
};


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// Affiche le bouton de suppression d'une tarification

const displayDeleteBtn = () => {
    if (document.querySelectorAll('.pricing').length > 1) {
        deletePricing.classList.remove('d-none');
        deletePricing.addEventListener('click', deleteClone);
    };
};


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// Ajoute une tarification

const clone = () => {

    let count = document.querySelectorAll('.pricing').length;

    if (count == 3) {
        addError.classList.remove('d-none');
        return false;
    };

    count++;

    let cloned = pricing1.cloneNode(true);
    cloned.id = (cloned.id).slice(0, -1) + count;


    let labels = cloned.querySelectorAll('label');
    for (const label of labels) {
        label.setAttribute('for', (label.getAttribute('for')).slice(0, -1) + count);
    };

    let inputs = cloned.querySelectorAll('input');
    for (const input of inputs) {
        input.setAttribute('id', (input.getAttribute('id')).slice(0, -1) + count);
        input.setAttribute('name', (input.getAttribute('name')).slice(0, -1) + count);
        input.value = '';
        input.classList.remove('error-form');
    };

    let smalls = cloned.querySelectorAll('small');
    for (const small of smalls) {
        small.setAttribute('id', (small.getAttribute('id')).slice(0, -1) + count);
        small.setAttribute('aria-errormessage', (small.getAttribute('aria-errormessage')).slice(0, -1) + count);
        small.classList.add('d-none');
    };

    pricings.append(cloned);

    displayDeleteBtn();
};




displayDeleteBtn();


addPricing.addEventListener('click', clone);


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION DU FORMULAIRE


category.addEventListener('change', () => {
    checkNumbers(category, 'une catégorie pour la prestation');
});

title.addEventListener('change', () => {
    checkInput(title, 'un nom de catégorie', REGEX_TEXT);
});





// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION AU CLICK DE VALIDATION

const verifPricings = (inputId, message, messageLocationId) => {

    let input = document.getElementById(inputId);
    let messageLocation = document.getElementById(messageLocationId);

    if (input.required && input.value == '') {

        input.classList.add('error-form');
        messageLocation.classList.remove('d-none');
        messageLocation.textContent = `Veuillez saisir ${message}.`;
    } else {

        input.classList.remove('error-form');
        messageLocation.classList.add('d-none');
    };
};


validBtn.addEventListener('click', () => {

    checkNumbers(category, 'une catégorie pour la prestation');
    checkInput(title, 'un nom de prestation', REGEX_TEXT);

    const pricingBlocks = document.querySelectorAll('.pricing');
    console.log(pricingBlocks);

    pricingBlocks.forEach((pricingBlock, key) => {
        verifPricings(`duration${key + 1}`, 'une durée', `durationError${key + 1}`);
        verifPricings(`price${key + 1}`, 'un prix', `priceError${key + 1}`);
    });

    checkRadio(genderBtns, 'un choix de clientèle', genderError);
    checkRadio(packageBtns, 'le type de la prestation', packageError);

    if (!checkRadio(exclusiveBtns, 'le type de la prestation', exclusiveError)) {
        checkInput(startExclusiveDate, 'une date de début', REGEX_DATE);
        checkInput(endExclusiveDate, 'une date de fin', REGEX_DATE);
    };

});