<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');

require_once(__DIR__ . './../../models/Category.php');
require_once(__DIR__ . './../../models/Service.php');
require_once(__DIR__ . './../../models/Discount.php');
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
    $document_title = TITLES['discounts_list'];
    // ------------------------------------------------


    // ------------------------------------------------
    // Récupération de l'ensemble des promotions
    // ------------------------------------------------
    $discounts = Discount::fetchAll();
    
    // Redirection s'il n'y a pas de promotions enregistrées
    if (empty($discounts)) {
        header('location: /gestion/ajouter-une-promotion');
        die;
    }
    // ------------------------------------------------

    // ------------------------------------------------
    // Formatage des données récupérées sur l'ensemble des promotions
    // ------------------------------------------------
    $count = Service::count();
    $count = ($count) ? $count : 0;

    foreach ($discounts as $key => $discount) {

        $discount->icon = 0;

        if (is_null($discount->deactivated_at) || $discount->end_date < date('Y-m-d')) {
            
            if ($discount->start_date > date('Y-m-d')) {
                $discount->icon = 1;
            } else if ($discount->start_date <= date('Y-m-d') && $discount->end_date >= date('Y-m-d')) {
                $discount->icon = 2;
            }
            
        }

        // Formatage des dates
        $discount->start_date = format_date($discount->start_date);
        $discount->end_date = format_date($discount->end_date);

        // Formatage de la valeur de la promotion
        $discount->discount = '- ' . $discount->advantage;
        $discount->discount .= ($discount->euro == true) ? ' €' : ' %';

        // Ajoute la classe de désactivation si besoin
        $discount->class_row = ($discount->deactivated_at) ? 'deactivated' : '';

        // Détermine si toutes les prestations sont concernées ou non pour l'affichage dans le tableau
        $categories_number = explode(', ', $discount->id_services);

        if (count($categories_number) == $count) {
            $discount->categories = 'Toutes les prestations';
        }
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // Nom des fichiers js nécessaire au fonctionnement
    // ------------------------------------------------
    $js = ['modal.link'];
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

include(__DIR__ . './../../views/dashboard/discounts_list.php');

include_once(__DIR__ . './../../views/templates/footer.php');
