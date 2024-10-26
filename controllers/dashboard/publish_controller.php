<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');

require_once(__DIR__ . './../../models/Announcement.php');
require_once(__DIR__ . './../../models/Category.php');
require_once(__DIR__ . './../../models/Service.php');

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
            $is_published = Category::publish($id);

            if ($is_published) {
                Flash::setMessage('La catégorie a été publiée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la catégorie n\'a pas été publiée.');
            }
            break;
        // ===================================================================
        case '2':
            // PUBLICATION DU SERVICE
            $is_published = Service::publish($id);
            
            if ($is_published) {
                Flash::setMessage('La prestation a été publiée.');
            } else {
                Flash::setMessage('Une erreur est survenue : la prestation n\'a pas été publiée.');
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

