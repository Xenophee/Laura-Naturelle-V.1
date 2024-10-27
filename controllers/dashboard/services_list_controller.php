<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');

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
        header('location: /404');
        die;
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = TITLES['services_list'];
    // ------------------------------------------------


    // ------------------------------------------------
    // Récupération des données nécessaires
    // ------------------------------------------------
    $categories = Category::fetchAll();
    $services = Service::fetchAll();
    // ------------------------------------------------

    // ------------------------------------------------
    // MISE EN PLACE DU NOM DE L'URL
    // ------------------------------------------------
    foreach ($categories as $key => $category) {
        $category->link = strtr($category->name, ACCENT_CHARACT);
        $category->link = strtolower($category->link);
    }
    // ------------------------------------------------



    // ===================================================================================================================================
    // CRÉATION DU NOUVEAU TABLEAU GLOBAL QUI SERA AFFICHE DANS LA VUE
    // ===================================================================================================================================
    $categories_services = [];

    // Boucle sur les catégories.
    foreach ($categories as $category) {
        // Initialise l'association
        $id_category = $category->id_category;

        // Initialise un tableau vide pour les services et les pricings associés à cette catégorie.
        $categories_services[$id_category] = [
            'category' => $category,
            'services' => []
        ];
    }

    // Boucle sur les services.
    foreach ($services as $service) {
        // Établis l'association
        $id_category = $service->id_category;

        // Ajoute le service au tableau global $categories_services.
        $categories_services[$id_category]['services'][] = $service;
    }
    // ===================================================================================================================================



    // ===================================================================================================================================
    // FORMATAGE & AJOUT DE DONNÉES DU TABLEAU GLOBAL POUR AFFICHAGE OPTIMAL SUR LA VUE
    // ===================================================================================================================================
    foreach ($categories_services as $key => $category_service) {

        $category = $category_service['category'];
        $services = $category_service['services'];

        // ------------------------------------------------
        // Création de la propriété contenant la classe css de la catégorie
        // ------------------------------------------------
        $category->class_row = '';

        if ($category->deactivated_at) {
            $category->class_row = 'deactivated';
        } else if (!$category->published_at) {
            $category->class_row = 'shelved';
        }
        // ------------------------------------------------

        foreach ($services as $service) {

            // ------------------------------------------------
            // Création de la propriété contenant la classe css de la prestation
            // ------------------------------------------------
            $service->class_row = '';

            if ($service->service_deactivated_at) {
                $service->class_row = 'deactivated';
            } else if (!$service->service_published_at) {
                $service->class_row = 'shelved';
            }
            // ------------------------------------------------


            // ------------------------------------------------
            // Formattage des dates des prestations exclusives
            // ------------------------------------------------
            if ($service->start_exclusive_date && $service->end_exclusive_date) {
                $service->start_exclusive_date = format_date($service->start_exclusive_date);
                $service->end_exclusive_date = format_date($service->end_exclusive_date);
            }
            // ------------------------------------------------


            // ------------------------------------------------
            // Détermine si l'icone "Nouveauté" doit être affiché ou non
            // ------------------------------------------------
            $service->icon_new = false;

            if ($service->service_published_at && is_null($service->start_exclusive_date)) {
                $service->icon_new = Service::new_display($service->service_published_at);
            }
            // ------------------------------------------------


            // ------------------------------------------------
            // Création de tableaux pour les tarifs et la durée sur les données groupées
            // ------------------------------------------------
            $service->durations = explode(', ', $service->durations);
            $service->prices = explode(', ', $service->prices);

            foreach ($service->prices as $key => $price) {

                $service->prices[$key] = format_float($price);
            }
            // ------------------------------------------------

            // ------------------------------------------------
            // Création d'une propriété qui gère l'autorisation d'affichage des promotions dans la vue
            // ------------------------------------------------
            $service->discount_display = ($service->discount_start_date > date('Y-m-d') || $service->discount_end_date < date('Y-m-d')) ? 0 : 1;
            // ------------------------------------------------

            // ------------------------------------------------
            // Formatage des prix, calcul de la promotion si elle existe et ajout d'une propriété contenant les tarifs réduits
            // ------------------------------------------------
            foreach ($service->prices as $key => $price) {

                $service->prices[$key] = format_float($price);

                if ($service->discount_display) {

                    $service->reduced_prices[] = Discount::discount_calc($service->euro, $price, $service->advantage);
                }
            }

            if ($service->discount_display) {
                $service->discount_start_date = format_date($service->discount_start_date);
                $service->discount_end_date = format_date($service->discount_end_date);
            }
            // ------------------------------------------------


            if ($service->gender == 1) {
                $male_services[] = $service;
            } else if ($service->gender == 2) {
                $female_services[] = $service;
            }
        }
    }
    // ==================================================================================================================================


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

include(__DIR__ . './../../views/dashboard/services_list.php');

include_once(__DIR__ . './../../views/templates/footer.php');
