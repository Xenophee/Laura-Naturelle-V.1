<?php

require_once(__DIR__ . '/../config/init.php');

require_once(__DIR__ . './../helpers/Flash.php');
require_once(__DIR__ . './../helpers/FormValidator.php');
require_once(__DIR__ . './../helpers/Mail.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require '../vendor/autoload.php';


// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {

    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = TITLES['contact'];
    $meta_description = META_DESCRIPTION['contact'];
    // ------------------------------------------------

    // ------------------------------------------------
    // Script spécifique pour le captcha google
    // ------------------------------------------------
    $captcha_script = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    // ------------------------------------------------


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ===================================================================================================================================
        // CIVILITÉ
        // ===================================================================================================================================

        $civility = FormValidator::validate_int('civility', 'de civilité', true, [1, 2]);
        $civility_string = ($civility['data'] == 1) ? 'M' : 'Mme';
        $errors[] = ($civility['message']) ? true : false;


        // ===================================================================================================================================
        // NOM
        // ===================================================================================================================================

        $lastname = FormValidator::validate_text('lastname', 'votre nom', TEXT_LIMIT['short']);
        $errors[] = ($lastname['message']) ? true : false;


        // ===================================================================================================================================
        // PRÉNOM
        // ===================================================================================================================================

        $firstname = FormValidator::validate_text('firstname', 'votre prénom', TEXT_LIMIT['short']);
        $errors[] = ($firstname['message']) ? true : false;


        // ===================================================================================================================================
        // EMAIL
        // ===================================================================================================================================

        $email = FormValidator::validate_email();
        $errors[] = ($email['message']) ? true : false;


        // ===================================================================================================================================
        // OBJET
        // ===================================================================================================================================

        $object = FormValidator::validate_int('object', 'd\'objet', true, [1, count(OBJECTS_MAIL)]);
        $errors[] = ($object['message']) ? true : false;


        // ===================================================================================================================================
        // REQUÊTE
        // ===================================================================================================================================

        $request = FormValidator::validate_textarea('request', 'votre message', 3000);
        $errors[] = ($request['message']) ? true : false;


        // ===================================================================================================================================
        // CAPTCHA
        // ===================================================================================================================================

        $recaptcha = new \ReCaptcha\ReCaptcha(SECRET_KEY_CAPTCHA);

        $response = $_POST['g-recaptcha-response'];

        $resp = $recaptcha->setExpectedHostname(HOST_NAME)
            ->verify($response);

        if ($resp->isSuccess()) {
            $errors[] = false;
        } else {
            $errors_resp = $resp->getErrorCodes();
            $captcha['message'] = 'Vous n\'avez pas été reconnu comme étant un humain.';
            $errors[] = true;
        }


        // ===================================================================================================================================
        // ENVOI DU MAIL SI TOUT EST BON
        // ===================================================================================================================================

        if (!in_array(true, $errors)) {

            $person = $civility_string . ' ' . $lastname['data'] . ' ' . $firstname['data'];

            $data_mail = [
                'addReplyTo' => $email['data'],
                'object' => OBJECTS_MAIL[$object['data'] - 1],
                'content' => '<html>
                                <body>
                                    <h1 style="text-align: center;">Mail reçu par le formulaire de contact</h1>
                                    <hr style="margin-top: 50px;">
                                    <ul>
                                        <li>Message envoyé par : ' .  $person . '</li>
                                        <li>Mail : ' .  $email['data'] . '</li>
                                    </ul>
                                    <hr style="margin-bottom: 50px;">
                                    <p>' .  $request['data'] . '</p>
                                </body>
                            </html>'
            ];

            $new_mail = new Mail();
            $is_mail_send = $new_mail->send_mail($data_mail, true);

            unset($civility, $lastname, $firstname, $email, $object, $request);

            if ($is_mail_send === true) {
                Flash::setMessage('Votre message a été envoyé !');
            } else {
                Flash::setMessage('Une erreur est survenue ; votre message n\'a pas pu être envoyé.', false);
            }
            

            ($is_mail_send === true) ? Flash::setMessage('Votre message a été envoyé !') : Flash::setMessage('Une erreur est survenue ; votre message n\'a pas pu être envoyé.', false);
        }
    }


    // ------------------------------------------------
    // Nom des fichiers js nécessaire au fonctionnement
    // ------------------------------------------------
    $js = ['form', 'contact'];
    // ------------------------------------------------


} catch (\Throwable $th) {
    include_once(__DIR__ . '/../views/templates/header.php');
    include_once(__DIR__ . '/../views/error.php');
    include_once(__DIR__ . '/../views/templates/footer.php');
    die;
}



// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// AFFICHAGE DES VUES

include_once(__DIR__ . '/../views/templates/header.php');

include(__DIR__ . '/../views/contact.php');

include_once(__DIR__ . '/../views/templates/footer.php');



// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// MODAL ALERT SITE NON OFFICIEL
include_once(__DIR__ . '/../views/templates/alert_modal.php');