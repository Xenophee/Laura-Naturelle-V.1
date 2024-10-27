
import { checkInput, checkNumbers, checkRadio, errorDisplay, errorRemove, errorMessage, counterLenght, checkTextarea } from './form.js';


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FORMULAIRE DE PROMOTION

const REGEX_DATE = new RegExp(startDate.pattern);

const discountTypes = document.querySelectorAll('input[name="discountType"]');
const servicesBtns = document.querySelectorAll('input[name="whichServices"]');

const validBtn = document.querySelector('button[type="submit"]');


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// Affiche les accordéons de prestations en cas de choix ciblés

const displayServices = () => {

    for (const servicesBtn of servicesBtns) {

        if (servicesBtn.checked && servicesBtn.value == 2) {
            servicesAccordion.classList.remove('d-none');
        } else {
            servicesAccordion.classList.add('d-none');
        };
    };
};


displayServices();


for (const servicesBtn of servicesBtns) {
    servicesBtn.addEventListener('click', displayServices);
};
// ----------------------------------------------------------------------



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION DU FORMULAIRE

startDate.addEventListener('input', () => {
    checkInput(startDate, 'une date', REGEX_DATE);
});

endDate.addEventListener('input', () => {
    checkInput(endDate, 'une date', REGEX_DATE);
});

advantage.addEventListener('input', () => {
    checkNumbers(advantage, 'un montant de réduction');
});


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION AU CLICK DE VALIDATION

validBtn.addEventListener('click', () => {
    checkInput(startDate, 'une date', REGEX_DATE);
    checkInput(endDate, 'une date', REGEX_DATE);
    checkRadio(discountTypes, 'un type de réduction', discountTypeError);
    checkNumbers(advantage, 'un montant de réduction');
    checkRadio(servicesBtns, 'un choix sur les prestations concernées par cette promotion', whichServicesError);
});