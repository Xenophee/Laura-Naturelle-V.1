

// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VARIABLES

const schedules = document.getElementById('schedules-form');

const scheduleBtnGroup = document.querySelectorAll('.schedule-btn-group');
const firstSchedules = document.querySelectorAll('.schedules-first-bloc');
const secondSchedules = document.querySelectorAll('.schedules-second-bloc');

const closeMidHour = document.querySelectorAll('.close-mid-hour');
const closeHour = document.querySelectorAll('.close-hour');

const hourInputs = document.querySelectorAll('.hour');
const minutesInputs = document.querySelectorAll('.minutes');



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION D'AFFICHAGE DU FORMULAIRE

const displayForm = (value, index) => {

    // -----------------------------------------------------
    // Place les inputs dans le bon ordre selon que le jour est sans interruption ou non
    if (value == 1) {
        firstSchedules[index].insertBefore(closeHour[index], null);
        secondSchedules[index].insertBefore(closeMidHour[index], null);
        
    } else if (value == 2) {
        firstSchedules[index].insertBefore(closeMidHour[index], null);
        secondSchedules[index].insertBefore(closeHour[index], null);
    };
    // -----------------------------------------------------

    // -----------------------------------------------------
    // Sélection des inputs après la mise en ordre
    let firstSchedulesInputs = firstSchedules[index].querySelectorAll('.schedules-first-bloc input');
    let secondSchedulesInputs = secondSchedules[index].querySelectorAll('.schedules-second-bloc input');
    // -----------------------------------------------------

    // -----------------------------------------------------
    // Reset la mise en page
    firstSchedules[index].classList.add('d-none');
    secondSchedules[index].classList.add('d-none');

    for(const firstSchedulesInput of firstSchedulesInputs) {
        firstSchedulesInput.required = false;
    };

    for(const secondSchedulesInput of secondSchedulesInputs) {
        secondSchedulesInput.required = false;
    };
    // -----------------------------------------------------

    
    // -----------------------------------------------------
    // Rends les inputs obligatoires selon que le jour est sans interruption ou non
    if (value == 1 || value == 2) {

        firstSchedules[index].classList.remove('d-none');

        for(const firstSchedulesInput of firstSchedulesInputs) {
            firstSchedulesInput.required = true;
        };

        if (value == 2) {

            secondSchedules[index].classList.remove('d-none');

            for(const secondSchedulesInput of secondSchedulesInputs) {
                secondSchedulesInput.required = true;
            };

        };
    };
    // -----------------------------------------------------
};



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE VÉRIFICATION DES HORAIRES

const verifSchedules = () => {

    let isSchedulesOk = [];

    // -----------------------------------------------------
    // Vérification sur les heures
    for(const hourInput of hourInputs) {
        if (hourInput.required == true) {
            if (hourInput.value < 0 || hourInput.value > 23) {
                hourInput.classList.add('error-form');
                isSchedulesOk.push(false);
            } else {
                hourInput.classList.remove('error-form');
                isSchedulesOk.push(true);
            };
        };
    };
    // -----------------------------------------------------

    // -----------------------------------------------------
    // Vérification sur les minutes
    for(const minutesInput of minutesInputs) {
        if (minutesInput.required == true) {
            if (minutesInput.value < 0 || minutesInput.value > 59) {
                minutesInput.classList.add('error-form');
                isSchedulesOk.push(false);
            } else {
                minutesInput.classList.remove('error-form');
                isSchedulesOk.push(true);
            };
        };
    };
    // -----------------------------------------------------

    return isSchedulesOk;
};



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE FORMATAGE DES HORAIRES POUR GARDER UNE COHÉRENCE VISUELLE

const formatNumber = (element) => {

    if (element.value.length == 0) {
        element.value = '00';
    } else if (element.value.length == 1) {
        element.value = '0' + element.value;
    };
};



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// LANCEMENT DE LA FONCTION DISPLAYFORM AU LANCEMENT DE LA PAGE ET AU CHANGEMENT DE STATUT DES HORAIRES

scheduleBtnGroup.forEach((element, index) => {

    let scheduleBtns = element.querySelectorAll('.scheduleBtn');

    for(const btn of scheduleBtns) {

        if (btn.checked) {
            displayForm(Number(btn.value), index);
        };

        btn.addEventListener('change', () => {
            displayForm(Number(btn.value), index);
        });
    };

});



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// VÉRIFICATION DYNAMIQUE DES HORAIRES ET REMPLISSAGE AUTO POUR LES ÉLÉMENTS VIDE

for(const hourInput of hourInputs) {
    hourInput.addEventListener('input', verifSchedules);
    hourInput.addEventListener('change', (event) => {
        formatNumber(event.target);
    });
};

for(const minutesInput of minutesInputs) {
    minutesInput.addEventListener('input', verifSchedules);
    minutesInput.addEventListener('change', (event) => {
        formatNumber(event.target);
    });
};



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// LANCEMENT DE LA FONCTION DE VÉRIFICATION À LA VALIDATION DU FORMULAIRE

schedules.addEventListener('submit', (event) => {

    event.preventDefault();

    let isSchedulesOk = verifSchedules();

    if (isSchedulesOk.includes(false)) {
        errorMessage.textContent = 'Un ou plusieurs horaires que vous avez saisis ne sont pas valides !';
        schedules.scrollIntoView();
    } else {
        schedules.submit();
    };
    
});
