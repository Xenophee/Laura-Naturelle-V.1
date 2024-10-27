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
    // ------------------------------------------------


    // ------------------------------------------------
    // Désactivation de l'élément (id) concerné dans la table (param) concernée
    // ------------------------------------------------
    switch ($param) {
        case '1':
            // DÉSACTIVATION D'UNE CATEGORIE
            $is_deactivated = Category::deactivate($id);
            
            if ($is_deactivated) {
                Flash::setMessage('La catégorie a été désactivée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la catégorie n\'a pas été désactivée.');
            }
            break;
            // ===================================================================
        case '2':
            // DÉSACTIVATION DU SERVICE
            $is_deactivated = Service::deactivate($id);

            if ($is_deactivated) {
                Flash::setMessage('La prestation a été désactivée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la prestation n\'a pas été désactivée.');
            }
            break;
            // ===================================================================
        case '3':
            // DÉSACTIVATION D'UNE PROMOTION
            $is_deactivated = Discount::deactivate($id);

            if ($is_deactivated) {
                Flash::setMessage('La promotion a été désactivée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la promotion n\'a pas été désactivée.', false);
            }
            break;
            // ===================================================================
        case '4':
            // DÉSACTIVATION D'UNE ANNONCE
            $is_deactivated = Announcement::deactivate($id);

            if ($is_deactivated) {
                Flash::setMessage('L\'annonce a été désactivée.');
            } else {
                Flash::setMessage('Une erreur est survenue : l\'annonce n\'a pas été désactivée.');
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
