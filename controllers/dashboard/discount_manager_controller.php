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
    // Récupération de l'id pour savoir si on se trouve en présence d'un ajout ou d'une modification
    // ------------------------------------------------
    $id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
    // ------------------------------------------------


    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    if (empty($id)) {
        $document_title = TITLES['discount_add'];
    } else {
        $document_title = TITLES['discount_update'];
    }
    // ------------------------------------------------



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ===================================================================================================================================
        // DATES DE DÉBUT ET DE FIN DE PROMOTION
        // ===================================================================================================================================

        $dates = FormValidator::validate_dates('startDate', 'endDate');
        $errors[] = ($dates['first_date']['message'] || $dates['last_date']['message']) ? true : false;


        // ===================================================================================================================================
        // TYPE DE RÉDUCTION
        // ===================================================================================================================================

        $euro = FormValidator::validate_bool('discountType', 'sur le type de réduction');
        $errors[] = ($euro['message']) ? true : false;


        // ===================================================================================================================================
        // MONTANT DE LA RÉDUCTION
        // ===================================================================================================================================

        $advantage = FormValidator::validate_int('advantage', 'le montant de la réduction');
        $errors[] = ($advantage['message']) ? true : false;


        // ===================================================================================================================================
        // PRESTATIONS CONCERNÉES PAR LA PROMOTION
        // ===================================================================================================================================

        $which_services = FormValidator::validate_int('whichServices', 'sur les prestations concernées par cette promotion', true, [1, 2]);

        if ($which_services['data'] == 2) {
            $services = filter_input(INPUT_POST, 'services', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY) ?? [];
            $errors[] = (empty($services)) ? true : false;
            $which_services['message'] = (empty($services)) ? 'Veuillez effectuer un choix de prestations.' : '';
        }


        // ===================================================================================================================================
        // ENREGISTREMENT DE LA MISE À JOUR EN BASE S'IL N'Y A PAS D'ERREURS
        // ===================================================================================================================================

        if (!in_array(true, $errors)) {

            // ------------------------------------------------
            // Création & hydratation de l'objet Discount
            $new_discount = new Discount;

            $new_discount->set_start_date($dates['first_date']['data']);
            $new_discount->set_end_date($dates['last_date']['data']);
            $new_discount->set_euro($euro['data']);
            $new_discount->set_advantage($advantage['data']);
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
                $is_valid_discount_request = $new_discount->insert();
                // ------------------------------------------------

                // ------------------------------------------------
                // Récupération de l'id de la promotion nouvellement enregistrée
                $id_discount = $pdo->lastInsertId();
                // ------------------------------------------------

                // ------------------------------------------------
                // Ajout de la promotion aux prestations concernées
                if ($which_services['data'] == 1) {
                    $is_valid_service_discounted[] = Service::add_discount($id_discount);
                } else {
                    foreach ($services as $key => $service) {
                        $is_valid_service_discounted[] = Service::add_discount($id_discount, $service);
                    }
                }
                // ------------------------------------------------

            } else {
                // =============================================================================================
                // MODIFICATION EN BASE DE DONNÉES
                // =============================================================================================

                // ------------------------------------------------
                // Ajout des informations de base
                $is_valid_discount_request = $new_discount->update($id);
                // ------------------------------------------------

                // ------------------------------------------------
                // Reset les id de la promotion liée aux prestations
                $is_valid_service_discounted[] = Service::reset_discount($id);
                // ------------------------------------------------

                // ------------------------------------------------
                // Ajout de la promotion aux prestations concernées
                if ($which_services['data'] == 1) {
                    $is_valid_service_discounted[] = Service::add_discount($id);
                } else {
                    foreach ($services as $key => $service) {
                        $is_valid_service_discounted[] = Service::add_discount($id, $service);
                    }
                }
                // ------------------------------------------------
            }


            // ===================================================================================================================================
            // AFFICHAGE D'UN MESSAGE À L'UTILISATEUR APRÈS L'ENREGISTREMENT EN BASE DE DONNÉES
            // ===================================================================================================================================
            if ($is_valid_discount_request && !in_array(false, $is_valid_service_discounted)) {
                $pdo->commit();
                ($id === 0) ? Flash::setMessage('La promotion a été ajoutée.') : Flash::setMessage('La promotion a été mise à jour.');
                if ($id === 0) {
                    header('location: /gestion/liste-des-promotions');
                    die;
                }
            } else {
                $pdo->rollBack();
                ($id === 0) ? Flash::setMessage('Une erreur est survenue : la promotion n\'a pas été ajoutée.', false) : Flash::setMessage('Une erreur est survenue : la promotion n\'a pas été mise à jour.', false);
            }
        }
    }


    // ------------------------------------------------
    // Récupération de la prestation concernée et ajout d'une information pour le bouton prestation à checker
    // ------------------------------------------------
    if (!empty($id)) {
        $discount = Discount::fetch($id);
        $id_services = explode(', ', $discount->id_services);
        $count = Service::count();
        $discount->services = (count($id_services) == $count) ? 1 : 2;
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // Stockage des id de prestations sélectionnées ou création d'un tableau vide
    // ------------------------------------------------
    if (isset($services)) {
        $id_services = $services;
    } else if (isset($id_services)) {
        $id_services = $id_services;
    } else {
        $id_services = [];
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // Récupération des catégories & prestations pour le formulaire
    // ------------------------------------------------
    $categories = Category::fetchAll(true);

    foreach ($categories as $key => $category) {
        $category->id_services = explode(', ', $category->id_services);
        $category->service_names = explode(', ', $category->service_names);
        $category->genders = explode(', ', $category->genders);

        foreach ($category->id_services as $key => $cat_id_service) {
            $category->status[] = (in_array($cat_id_service, $id_services)) ? 'checked' : '';
        }
    }
    // ------------------------------------------------
    

    // ------------------------------------------------
    // Récupération des identifiants de prestations ayant déjà une promotion
    // ------------------------------------------------
    $is_discounts_exist = Service::is_discounts_exist($id);
    // ------------------------------------------------


    // ------------------------------------------------
    // Nom des fichiers js nécessaire au fonctionnement
    // ------------------------------------------------
    $js = ['discount'];
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

include(__DIR__ . './../../views/dashboard/discount_manager.php');

include_once(__DIR__ . './../../views/templates/footer.php');
