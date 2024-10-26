<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');

require_once(__DIR__ . './../../helpers/FormValidator.php');


// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {

    // ------------------------------------------------
    // Vérification des droits de l'utilisateur
    // ------------------------------------------------
    if (empty($_SESSION['user'])) {
        header('location: /404');
        die;
    } else {
        $user = $_SESSION['user'];
    }
    // ------------------------------------------------

    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = TITLES['account'];
    // ------------------------------------------------


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ===================================================================================================================================
        // ADRESSE MAIL
        // ===================================================================================================================================

        $email = FormValidator::validate_email();
        $errors[] = ($email['message']) ? true : false;


        // ===================================================================================================================================
        // NUMÉRO DE TÉLÉPHONE
        // ===================================================================================================================================

        $phone = FormValidator::validate_phone();
        $errors[] = ($phone['message']) ? true : false;


        // ===================================================================================================================================
        // ADRESSE
        // ===================================================================================================================================

        $address = FormValidator::validate_address(TEXT_LIMIT['medium']);
        $errors[] = ($address['message']) ? true : false;


        // ===================================================================================================================================
        // CODE POSTAL
        // ===================================================================================================================================

        $zipcode = FormValidator::validate_zipcode();
        $errors[] = ($zipcode['message']) ? true : false;


        // ===================================================================================================================================
        // VILLE
        // ===================================================================================================================================

        $city = FormValidator::validate_text('city', 'un nom de ville', TEXT_LIMIT['medium']);
        $errors[] = ($city['message']) ? true : false;


        // ===================================================================================================================================
        // MOTS DE PASSE
        // ===================================================================================================================================

        $passwords = FormValidator::validate_password($user->password);

        $errors[] = ($passwords['password']['message']) ? true : false;
        $errors[] = ($passwords['newPassword']['message']) ? true : false;
        $errors[] = ($passwords['confirmPassword']['message']) ? true : false;


        // ===================================================================================================================================
        // ENREGISTREMENT DE LA MISE À JOUR EN BASE S'IL N'Y A PAS D'ERREURS
        // ===================================================================================================================================

        if (!in_array(true, $errors)) {
            $user_update = new User;
            $user_update->set_email($email['data']);
            $user_update->set_phone($phone['data']);
            $user_update->set_address($address['data']);
            $user_update->set_zipcode($zipcode['data']);
            $user_update->set_city($city['data']);

            if (empty($passwords['newPassword']['data'])) {

                $is_updated = $user_update->update($user->id_user);
            } else {
                $user_update->set_password($passwords['passwordHash']);

                $is_updated = $user_update->update($user->id_user, true);
            }

            // ===================================================================================================================================
            // AFFICHAGE D'UN MESSAGE À L'UTILISATEUR APRÈS L'ENREGISTREMENT EN BASE DE DONNÉES
            // ===================================================================================================================================
            if ($is_updated) {
                Flash::setMessage('Les informations de compte ont été mises à jour.');
            } else {
                Flash::setMessage('Une erreur est survenue : les informations n\'ont pas été mises à jour.', false);
            }
        }
    }
    // ===================================================================================================================================


    // ------------------------------------------------
    // Récupération des informations de l'utilisateur
    // ------------------------------------------------
    $user = $_SESSION['user'] = User::fetch('id_user', $user->id_user);
    // ------------------------------------------------


} catch (\Throwable $th) {
    include_once(__DIR__ . './../../views/templates/header.php');
    include_once(__DIR__ . './../../views/error.php');
    include_once(__DIR__ . './../../views/templates/footer.php');
    die;
}



// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// AFFICHAGE DES VUES

include_once(__DIR__ . './../../views/templates/header.php');

include(__DIR__ . './../../views/dashboard/account.php');

include_once(__DIR__ . './../../views/templates/footer.php');
