<?php

require_once(__DIR__ . '/../config/init.php');
require_once(__DIR__ . '/../models/Category.php');


// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {

    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = TITLES['services_categories'];
    $meta_description = META_DESCRIPTION['services_categories'];
    // ------------------------------------------------


    // ------------------------------------------------
    // Récupération de l'annonce s'il y en a une
    // ------------------------------------------------
    if (empty($_SESSION['user'])) {
        $categories = Category::fetch_index(true);
    } else {
        $categories = Category::fetch_index(true, true);
    }
    // ------------------------------------------------

    // ------------------------------------------------
    // MISE EN PLACE DU NOM DE L'URL
    // ------------------------------------------------
    foreach ($categories as $key => $category) {
        $category->link = slug($category->name);
    }
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

include(__DIR__ . '/../views/services_categories.php');

include_once(__DIR__ . '/../views/templates/footer.php');



// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// MODAL ALERT SITE NON OFFICIEL
include_once(__DIR__ . '/../views/templates/alert_modal.php');