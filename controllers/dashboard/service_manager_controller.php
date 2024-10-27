<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');

require_once(__DIR__ . './../../models/Category.php');
require_once(__DIR__ . './../../models/Service.php');
require_once(__DIR__ . './../../models/Pricing.php');
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
    // Récupération de l'id pour savoir si on se trouve en présence d'un ajout ou d'une modification
    // ------------------------------------------------
    $id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
    // ------------------------------------------------


    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    if (empty($id)) {
        $document_title = TITLES['service_add'];
    } else {
        $document_title = TITLES['service_update'];
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // Récupération des catégories
    // ------------------------------------------------
    $categories = Category::fetchAll();
    // ------------------------------------------------


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ------------------------------------------------
        // Récupération des données la prestation concernée en cas de mise à jour
        // ------------------------------------------------
        if (!empty($_SESSION['service'])) {
            $service = $_SESSION['service'];
        }
        // ------------------------------------------------

        // ===================================================================================================================================
        // CHOIX DE LA CATEGORIE
        // ===================================================================================================================================

        $id_category = FormValidator::validate_int('category', 'de catégorie', true);
        $errors[] = ($id_category['message']) ? true : false;


        // ===================================================================================================================================
        // NOM DE LA PRESTATION
        // ===================================================================================================================================

        $name = FormValidator::validate_text('title', 'un nom de prestation', TEXT_LIMIT['short']);
        $errors[] = ($name['message']) ? true : false;


        // ===================================================================================================================================
        // DESCRIPTION DE LA PRESTATION
        // ===================================================================================================================================

        $description = FormValidator::validate_textarea('description', 'une description de prestation', TEXT_LIMIT['medium_plus'], false);
        $errors[] = ($description['message']) ? true : false;


        // ===================================================================================================================================
        // DURÉE & TARIF
        // ===================================================================================================================================

        for ($i = 1; $i <= PRICINGS_NUMBER_ALLOWED; $i++) {
            $durations[$i] = FormValidator::validate_int('duration' . $i, 'une durée', false, [0, 999]);
            $prices[$i] = FormValidator::validate_float('price' . $i, 'un tarif', false, [0, 999, 2]);

            // Vérification de la nullité des données sur les durées et les tarifs
            $is_data_null[$i] = is_null($durations[$i]['data']) && is_null($prices[$i]['data']);

            // Suppression des clefs comportant uniquement des données null
            if ($i > 1 && $is_data_null[$i]) {
                unset($durations[$i]);
                unset($prices[$i]);
            }
        }

        // ---------------------------------------------------------------------
        // Reformatage du tableau pour remettre les clefs numériques selon un ordre logique
        $durations = array_values($durations);
        $durations = array_combine(range(1, count($durations)), $durations);

        $prices = array_values($prices);
        $prices = array_combine(range(1, count($prices)), $prices);
        // ---------------------------------------------------------------------

        // ---------------------------------------------------------------------
        // Stockage du nombre d'itérations à exécuter plus tard dans la vue
        $count_pricings = count($prices);
        // ---------------------------------------------------------------------

        // ---------------------------------------------------------------------
        // Vérification de la présence d'un message d'erreur
        $all_messages = array_column($durations, 'message');

        foreach ($all_messages as $message) {
            if (!empty($message)) {
                $errors[] = true;
                break;
            }
        }
        // ---------------------------------------------------------------------


        // ===================================================================================================================================
        // CHOIX DU GENRE DE LA CLIENTÈLE POUR CETTE PRESTATION
        // ===================================================================================================================================

        $gender = FormValidator::validate_int('gender', 'de clientèle', true, [1, 2]);
        $errors[] = ($gender['message']) ? true : false;


        // ===================================================================================================================================
        // FORFAIT
        // ===================================================================================================================================

        $package = FormValidator::validate_bool('package', '');
        $errors[] = ($package['message']) ? true : false;


        // ===================================================================================================================================
        // EXCLUSIF
        // ===================================================================================================================================

        $exclusive = FormValidator::validate_bool('exclusive', '');
        $errors[] = ($exclusive['message']) ? true : false;


        // ===================================================================================================================================
        // DATES EXCLUSIVES
        // ===================================================================================================================================

        if ($exclusive['data']) {
            $dates = FormValidator::validate_dates('startExclusiveDate', 'endExclusiveDate');
            $errors[] = ($dates['first_date']['message'] || $dates['last_date']['message']) ? true : false;
        }


        // ===================================================================================================================================
        // ENREGISTREMENT DE LA MISE À JOUR EN BASE S'IL N'Y A PAS D'ERREURS
        // ===================================================================================================================================

        if (!in_array(true, $errors)) {

            // ------------------------------------------------
            // Création & hydratation de l'objet Service
            $new_service = new Service;

            $new_service->set_name($name['data']);
            $new_service->set_gender($gender['data']);
            $new_service->set_description($description['data']);
            $new_service->set_package($package['data']);
            $new_service->set_id_category($id_category['data']);
            // ------------------------------------------------

            // ------------------------------------------------
            // Hydratation des dates en cas de prestation exclusive
            if ($exclusive['data']) {
                $new_service->set_start_exclusive_date($dates['first_date']['data']);
                $new_service->set_end_exclusive_date($dates['last_date']['data']);
            }
            // ------------------------------------------------

            // ------------------------------------------------
            // Création & hydratation des objets Pricing
            foreach ($prices as $key => $price) {

                $pricing_object = new Pricing;
                $pricing_object->set_duration($durations[$key]['data']);
                $pricing_object->set_price($price['data']);

                $pricing_objects[] = $pricing_object;
            }
            // ------------------------------------------------

            // ------------------------------------------------
            // Lancement de la transaction pour garantir l'intégrité des deux tables lors de l'enregistrement
            $pdo = Database::getInstance();
            $pdo->beginTransaction();
            // ------------------------------------------------

            if ($id === 0) {
                // =============================================================================================
                // AJOUT EN BASE DE DONNÉES
                // =============================================================================================

                // ------------------------------------------------
                // Ajout des informations de base
                $is_valid_service_request = $new_service->insert($exclusive['data']);
                // ------------------------------------------------

                // ------------------------------------------------
                // Récupération de l'id de la prestation nouvellement enregistrée
                $id_service = $pdo->lastInsertId();
                // ------------------------------------------------

                // ------------------------------------------------
                // Ajout des tarifications
                foreach ($pricing_objects as $key => $pricing_object) {
                    $pricing_object->set_id_service($id_service);
                    $is_valid_pricing_request[] = $pricing_object->insert();
                }
                // ------------------------------------------------

            } else {
                // =============================================================================================
                // MODIFICATION EN BASE DE DONNÉES
                // =============================================================================================

                // ------------------------------------------------
                // Mise à jour des informations de base
                // ------------------------------------------------
                $is_valid_service_request = $new_service->update($id, $exclusive['data']);
                // ------------------------------------------------


                // ------------------------------------------------
                // Vérification préalable de cas de suppression de tarifs
                // ------------------------------------------------
                if (count($pricing_objects) < count($service->id_pricing)) {
                    for ($i = count($service->id_pricing); $i > count($pricing_objects); $i--) { 
                        $is_valid_pricing_request[] = $pricing_object::delete($id, $service->id_pricing[$i -1]);
                    }
                }
                // ------------------------------------------------


                // ------------------------------------------------
                // Mets à jour les tarifs existants et en ajoute le cas échéant
                // ------------------------------------------------
                foreach ($pricing_objects as $key => $pricing_object) {

                    $pricing_object->set_id_service($id);

                    if (isset($service->id_pricing[$key])) {
                        $is_valid_pricing_request[] = $pricing_object->update($id, $service->id_pricing[$key]);
                    } else {
                        $is_valid_pricing_request[] = $pricing_object->insert();
                    }
                }
                // ------------------------------------------------
            }


            // ===================================================================================================================================
            // AFFICHAGE D'UN MESSAGE À L'UTILISATEUR APRÈS L'ENREGISTREMENT EN BASE DE DONNÉES
            // ===================================================================================================================================
            if ($is_valid_service_request && !in_array(false, $is_valid_pricing_request)) {
                $pdo->commit();
                unset($id_category, $name, $description, $durations, $prices, $gender, $package, $exclusive, $dates);
                ($id === 0) ? Flash::setMessage('La prestation a été ajoutée.') : Flash::setMessage('La prestation a été mise à jour.');
            } else {
                $pdo->rollBack();
                ($id === 0) ? Flash::setMessage('Une erreur est survenue : la prestation n\'a pas été ajoutée.', false) : Flash::setMessage('Une erreur est survenue : la prestation n\'a pas été mise à jour.', false);
            }
        }
    }


    // ------------------------------------------------
    // Récupération de la prestation concernée
    // ------------------------------------------------
    if (!empty($id)) {
        $service = Service::fetch($id);
        $service->duration = explode(', ', $service->duration);
        $service->price = explode(', ', $service->price);
        $service->id_pricing = explode(', ', $service->id_pricing);
        $_SESSION['service'] = $service;
        $count_pricings = count($service->price);
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // Mise en place de la variable pour l'affichage du select
    // ------------------------------------------------
    $selected_category = $id_category['data'] ?? $service->id_category ?? '';
    // ------------------------------------------------


    // ------------------------------------------------
    // Détermine le nombre d'itérations pour les tarifs sur la vue
    // ------------------------------------------------
    $pricings_number = $count_pricings ?? 1;
    // ------------------------------------------------


    // ------------------------------------------------
    // Nom des fichiers js nécessaire au fonctionnement
    // ------------------------------------------------
    $js = ['form', 'service'];
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

include(__DIR__ . './../../views/dashboard/service_manager.php');

include_once(__DIR__ . './../../views/templates/footer.php');
