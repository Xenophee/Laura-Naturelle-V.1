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
    // Publication de l'élément (id) concerné dans la table (param) concernée
    // ------------------------------------------------
    switch ($param) {
        case '1':
            // PUBLICATION D'UNE CATEGORIE
            $is_activated = Category::activate($id);
            
            if ($is_activated) {
                Flash::setMessage('La catégorie a été activée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la catégorie n\'a pas été activée.');
            }
            break;
            // ===================================================================
        case '2':
            // PUBLICATION DU SERVICE
            $is_activated = Service::activate($id);

            if ($is_activated) {
                Flash::setMessage('La prestation a été activée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la prestation n\'a pas été activée.');
            }
            break;
        case '3':
            // ACTIVATION D'UNE PROMOTION
            $is_activated = Discount::activate($id);

            if ($is_activated) {
                Flash::setMessage('La promotion a été activée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la promotion n\'a pas été activée.', false);
            }
            break;
            // ===================================================================
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
