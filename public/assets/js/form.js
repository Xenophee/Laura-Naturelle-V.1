


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION D'AFFICHAGE D'ERREUR DANS LE FORMULAIRE (modification des classes)

const errorDisplay = (input) => {
    let messageLocation = document.getElementById(`${input.id}Error`);
    input.classList.add('error-form');
    messageLocation.classList.remove('d-none');
};


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE RETRAIT D'ERREUR DANS LE FORMULAIRE (modification des classes)

const errorRemove = (input) => {
    let messageLocation = document.getElementById(`${input.id}Error`);
    input.classList.remove('error-form');
    messageLocation.classList.add('d-none');
};


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE PERSONNALISATION DU MESSAGE D'ERREUR

const errorMessage = (input, message, empty = false) => {

    let messageLocation = document.getElementById(`${input.id}Error`);

    if (empty) {
        messageLocation.textContent = `Veuillez saisir ${message}.`;
    } else {
        messageLocation.textContent = `Veuillez saisir ${message} valide.`;
    };
};


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE VÉRIFICATION POUR UN INPUT DU FORMULAIRE

const checkInput = (input, message, regex) => {

    let error = false;

    if (input.value == '') {

        if (input.required) {
            errorDisplay(input);
            errorMessage(input, message, true);
            error = true;
        } else {
            errorRemove(input);
        };
        

    } else if (regex && !regex.test(input.value)) {

        errorDisplay(input);
        errorMessage(input, message);
        error = true;
        
    } else {
        errorRemove(input);
    };

    return error;
};


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE VÉRIFICATION POUR UNE VALEUR NUMÉRIQUE

const checkNumbers = (input, message, limit) => {

    let error = false;

    if (input.value == 0) {

        if (input.required) {
            errorDisplay(input);
            errorMessage(input, message, true);
            error = true;
        } else {
            errorRemove(input);
        };
        
    } else if (limit && !limit.includes(Number(input.value))) {

        errorDisplay(input);
        errorMessage(input, message);
        error = true;
        
    } else {
        errorRemove(input);
    };

    return error;
};


// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE VÉRIFICATION POUR DES BOUTONS RADIOS

const checkRadio = (inputs, message, messageLocation) => {

    let error = true;

    for (var i = 0; i < inputs.length; i++) {
        // Vérifier si un bouton radio est coché
        if (inputs[i].checked) {
            error = false;
        };
    };

    if (error) {
        messageLocation.textContent = `Veuillez sélectionner ${message}.`;
        messageLocation.classList.remove('d-none');
    } else {
        messageLocation.classList.add('d-none');
    };

    return error;
};



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE VÉRIFICATION POUR UN TEXTAREA DU FORMULAIRE

const checkTextarea = (textarea, message) => {

    let textareaMessage = document.getElementById(`${textarea.id}Error`);

    if (textarea.value == '') {

        if (textarea.required) {
            errorDisplay(textarea);
            textareaMessage.textContent = message;
        } else {
            errorRemove(textarea);
            textarea.textContent = '';
        };
        
    } else {
        errorRemove(textarea);
        textarea.textContent = '';
    };
};



// ==============================================================================================
// ----------------------------------------------------------------------------------------------
// FONCTION DE COMPTAGE SUR lES TEXTAREA

const counterLenght = (textarea, value) => {

    let content = textarea.value.length;
    let message = document.getElementById(`${textarea.id}Lenght`);
    
    if (value) {
        counterChar.textContent = value - content;
        
        // Ajout d'un message d'erreur en cas de dépassement
        if (Number(counterChar.textContent) < 0) {
            message.textContent = 'Vous avez dépassé le nombre de caractères autorisés.';
        } else {
            message.textContent = '';
        };
    } else {
        counterChar.textContent = content;
    };

};



export { errorDisplay, errorRemove, errorMessage, checkInput, checkNumbers, checkRadio, checkTextarea, counterLenght };





