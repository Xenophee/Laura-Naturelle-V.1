<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');

require_once(__DIR__ . './../../models/Announcement.php');
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
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = TITLES['announcement'];
    // ------------------------------------------------


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ===================================================================================================================================
        // RÉCUPÉRATION DE L'ID POUR SAVOIR SI ON VA FAIRE APPEL À INSERT OU UPDATE À LA FIN
        // ===================================================================================================================================

        $id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));

        // ===================================================================================================================================
        // CONTENU DE L'ANNONCE
        // ===================================================================================================================================

        $content = FormValidator::validate_textarea('content', 'le contenu de l\'annonce', TEXT_LIMIT['large']);
        $errors[] = ($content['message']) ? true : false;

        // ===================================================================================================================================
        // DATES DE L'ANNONCE
        // ===================================================================================================================================

        $dates = FormValidator::validate_dates('startDate', 'endDate');
        $errors[] = ($dates['first_date']['message'] || $dates['last_date']['message']) ? true : false;

        // ===================================================================================================================================
        // ENREGISTREMENT DE LA MISE À JOUR EN BASE S'IL N'Y A PAS D'ERREURS
        // ===================================================================================================================================

        if (!in_array(true, $errors)) {

            $announcement_object = new Announcement;
            $announcement_object->set_content($content['data']);
            $announcement_object->set_start_date($dates['first_date']['data']);
            $announcement_object->set_end_date($dates['last_date']['data']);

            if ($id === 0) {
                $is_valid_request = $announcement_object->insert();
            } else {
                $is_valid_request = $announcement_object->update($id);
            }


            // ===================================================================================================================================
            // AFFICHAGE D'UN MESSAGE À L'UTILISATEUR APRÈS L'ENREGISTREMENT EN BASE DE DONNÉES
            // ===================================================================================================================================
            if ($is_valid_request) {
                ($id === 0) ? Flash::setMessage('L\'annonce a été ajoutée.') : Flash::setMessage('L\'annonce a été mise à jour.');
            } else {
                ($id === 0) ? Flash::setMessage('Une erreur est survenue : l\'annonce n\'a pas été ajoutée.', false) : Flash::setMessage('Une erreur est survenue : l\'annonce n\'a pas été mise à jour.', false);
            }
        }
    }


    // ===================================================================================================================================
    // PRÉPARATION DE L'AFFICHAGE
    // ===================================================================================================================================

    // ------------------------------------------------
    // Compteur pour le tableau
    $count = 1;
    // ------------------------------------------------

    // ------------------------------------------------
    // Récupération des annonces en base de données
    $announcements = Announcement::fetchAll();
    // ------------------------------------------------

    // ------------------------------------------------
    // Vérification de l'existence d'une annonce en cours (si la désactivation est à null pour le dernier élément)
    if (!empty($announcements) && is_null(end($announcements)->deactivated_at)) {

        $last_announcement = array_pop($announcements);

        if (new DateTime($last_announcement->end_date) >= new DateTime()) {
            $actual_announcement = $last_announcement;
            // La session sert pour les cas de suppression globale
            $_SESSION['except_id'] = $actual_announcement->id_announcement;
        }
        
    }
    // ------------------------------------------------

    // ------------------------------------------------
    // Formatage des dates des annonces en français
    foreach ($announcements as $announcement) {
        $announcement->start_date = format_date($announcement->start_date);
        $announcement->end_date = format_date($announcement->end_date);
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // Nom des fichiers js nécessaire au fonctionnement
    // ------------------------------------------------
    $js = ['form', 'modal.link', 'announcement'];
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

include(__DIR__ . './../../views/dashboard/announcement.php');

include_once(__DIR__ . './../../views/templates/footer.php');
