<?php

require_once(__DIR__ . '/../config/init.php');

require_once(__DIR__ . './../models/Category.php');
require_once(__DIR__ . './../models/Service.php');
require_once(__DIR__ . './../models/Discount.php');

// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {

    // ------------------------------------------------
    // Récupération de l'id pour savoir si on se trouve en présence d'un ajout ou d'une modification
    // ------------------------------------------------
    $id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
    // ------------------------------------------------


    // ------------------------------------------------
    // Récupération des données nécessaires
    // ------------------------------------------------
    $category = Category::fetch($id);

    if (is_null($category)) {
        header('location: /404');
        die;
    }

    if (empty($_SESSION['user'])) {
        $services = Service::fetchAll($id);
    } else {
        $services = Service::fetchAll($id, true);
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = $category->name . ' - prestations l\'Aura Natur\'elle';
    $meta_description = 'Explorez nos prestations d\'esthétique de ' . $category->name . ' ; laissez l\'Aura Natur\'elle sublimer votre beauté avec des traitements personnalisés et des produits de qualité.';
    // ------------------------------------------------


    // ------------------------------------------------
    // Création des tableaux de répartition nécessaires
    // ------------------------------------------------
    $male_services = [];
    $female_services = [];

    $female_exclusives = [];
    $female_classics = [];
    $female_packages = [];

    $male_exclusives = [];
    $male_classics = [];
    $male_packages = [];
    // ------------------------------------------------


    foreach ($services as $key => $service) {

        // ------------------------------------------------
        // Formatage de la date pour les prestations exclusives
        // ------------------------------------------------
        if ($service->end_exclusive_date) {
            $service->end_exclusive_date = format_date($service->end_exclusive_date, false);
        }
        // ------------------------------------------------

        // ------------------------------------------------
        // Création d'un tableau de prix et de durées s'il y en a plusieurs & formatage des décimals
        // ------------------------------------------------
        if (strpos($service->prices, ', ')) {
            $service->durations = explode(', ', $service->durations);
            $service->prices = explode(', ', $service->prices);

            foreach ($service->prices as $key => $price) {
                $service->prices[$key] = format_float($price);
            }
        } else {
            $service->prices = format_float($service->prices);
        }
        // ------------------------------------------------


        // ------------------------------------------------
        // Calcul de la promotion si elle existe
        // ------------------------------------------------
        $service->discount_display = ($service->discount_start_date > date('Y-m-d') || $service->discount_end_date < date('Y-m-d')) ? 0 : 1;

        if ($service->discount_display) {

            if (is_array($service->prices)) {
                foreach ($service->prices as $key => $price) {
                    $service->reduced_prices[] = Discount::discount_calc($service->euro, $price, $service->advantage);
                }
            } else {
                $service->reduced_prices = Discount::discount_calc($service->euro, $service->prices, $service->advantage);
            }
        }
        // ------------------------------------------------


        // ------------------------------------------------
        // Séparation du tableau principal par genre
        // ------------------------------------------------
        if ($service->gender == 1) {
            $male_services[] = $service;
        } else if ($service->gender == 2) {
            $female_services[] = $service;
        }
        // ------------------------------------------------
    }

    // ------------------------------------------------
    // Remplissage des tableaux femmes
    // ------------------------------------------------
    foreach ($female_services as $key => $service) {
        if ($service->start_exclusive_date) {
            $service->accordion_class = 'accordion-pink';
            $female_exclusives[] = $service;
        } else if ($service->package) {
            $service->accordion_class = 'accordion-brown';
            $female_packages[] = $service;
        } else {
            $service->accordion_class = 'accordion-green';
            $female_classics[] = $service;
        }
    }
    // ------------------------------------------------

    // ------------------------------------------------
    // Remplissage des tableaux hommes
    // ------------------------------------------------
    foreach ($male_services as $key => $service) {
        if ($service->start_exclusive_date) {
            $service->accordion_class = 'accordion-pink';
            $male_exclusives[] = $service;
        } else if ($service->package) {
            $service->accordion_class = 'accordion-brown';
            $male_packages[] = $service;
        } else {
            $service->accordion_class = 'accordion-green';
            $male_classics[] = $service;
        }
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

if ($category->view == 1) {
    include(__DIR__ . '/../views/services_lines.php');
} else {
    include(__DIR__ . '/../views/services_grid.php');
}

include_once(__DIR__ . '/../views/templates/footer.php');


// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// MODAL ALERT SITE NON OFFICIEL
include_once(__DIR__ . '/../views/templates/alert_modal.php');