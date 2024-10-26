<?php

require_once(__DIR__ . '/../config/init.php');
require_once(__DIR__ . '/../models/Announcement.php');


// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {

    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = TITLES['home'];
    $meta_description = META_DESCRIPTION['home'];
    // ------------------------------------------------


    // ------------------------------------------------
    // Récupération de l'annonce s'il y en a une
    // ------------------------------------------------
    $announcement = Announcement::fetch();
    // ------------------------------------------------
    

    // ------------------------------------------------
    // Nom des fichiers js nécessaire au fonctionnement
    // ------------------------------------------------
    $js = ['home'];
    $leaflet_css = '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">';
    $map_location = '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>';
    $review_google = '<script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>';
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

include(__DIR__ . '/../views/home.php');

include_once(__DIR__ . '/../views/templates/footer.php');



// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// MODAL ALERT SITE NON OFFICIEL
include_once(__DIR__ . '/../views/templates/alert_modal.php');