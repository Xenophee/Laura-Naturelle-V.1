<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');

require_once(__DIR__ . './../../models/Announcement.php');
require_once(__DIR__ . './../../models/Category.php');
require_once(__DIR__ . './../../models/Service.php');
require_once(__DIR__ . './../../models/Discount.php');

// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {

    // ------------------------------------------------
    // Vérification des droits de l'utilisateur
    // ------------------------------------------------
    if (empty($_SESSION['user'])) {
        header('location: /404.php');
        die;
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // Récupération des informations dans l'url
    // ------------------------------------------------
    $id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
    $param = intval(filter_input(INPUT_GET, 'param', FILTER_SANITIZE_NUMBER_INT));
    $method = intval(filter_input(INPUT_GET, 'method', FILTER_SANITIZE_NUMBER_INT));
    // ------------------------------------------------


    // ------------------------------------------------
    // Suppression de l'élément (id) concerné dans la table (param) concernée
    // ------------------------------------------------
    switch ($param) {

        case '1':
            // SUPPRESSION D'UNE CATEGORIE
            $is_deleted = Category::delete($id);

            unlink(LOCATION_CATEGORIES['original'] . $id . '.jpeg');
            unlink(LOCATION_CATEGORIES['original'] . $id . '.jpg');
            unlink(LOCATION_CATEGORIES['categories'] . $id . '-xl.webp');
            unlink(LOCATION_CATEGORIES['categories'] . $id . '.webp');
            unlink(LOCATION_CATEGORIES['min'] . $id . '.webp');
            
            if ($is_deleted) {
                Flash::setMessage('La catégorie a été supprimée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la catégorie n\'a pas été supprimée.', false);
            }
            break;
        // ===================================================================
        case '2':
            // SUPPRESSION DU SERVICE
            $is_deleted = Service::delete($id);

            if ($is_deleted) {
                Flash::setMessage('La prestation a été supprimée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la prestation n\'a pas été supprimée.', false);
            }
            break;
        // ===================================================================    
        case '3':
            // SUPPRESSION D'UNE OU PLUSIEURS PROMOTIONS
            switch ($method) {
                case '1':
                    $is_deleted = Discount::delete($id, true);
                    break;
                case '2':
                    $is_deleted = Discount::delete($id);
                    break;
            }

            if ($is_deleted) {
                Flash::setMessage('La suppression a été effectuée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la suppression n\'a pas été effectuée.', false);
            }
            break;
        // ===================================================================
        case '4':
            // SUPPRESSION D'UNE OU PLUSIEURS ANNONCES
            switch ($method) {
                case '1':
                    $is_deleted = Announcement::deleteAll($_SESSION['except_id'] ?? null);
                    unset($_SESSION['except_id']);
                    break;
                case '2':
                    $is_deleted = Announcement::delete($id);
                    break;
            }
            
            if ($is_deleted) {
                Flash::setMessage('La suppression a été effectuée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la suppression n\'a pas été effectuée.', false);
            }
            break;
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // Redirection vers la page précédente
    // ------------------------------------------------
    header('location: ' . $_SERVER['HTTP_REFERER']);
    die;
    // ------------------------------------------------

} catch (\Throwable $th) {
    include_once(__DIR__ . './../../views/templates/header.php');
    include_once(__DIR__ . './../../views/error.php');
    include_once(__DIR__ . './../../views/templates/footer.php');
    die;
}

